<?php

namespace App\Datatables;

use App\Feeders\DatatableFeeder;
use App\Feeders\DatatableFilter;
use App\Feeders\DatatableRowAction;
use App\Http\Controllers\SessionController;
use App\Models\Bill;
use App\Models\BuyableItem;
use App\Models\Contract;
use App\Models\Establishment;
use App\Models\Subscription;
use App\Models\User;
use App\Utilities\UuidTools;
use DateTime;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use function formatDate;

/**
 * Description of DtSubscriptionAdmin
 *
 * @author Nico
 */
class DtSubscriptionAdmin extends DatatableFeeder {
    
    const DT_ID = 'dt_subscription_admin';

    public function buildActions() {
        $this->enableAction(DatatableRowAction::ACTION_SEE);
        $this->customizeAction(DatatableRowAction::ACTION_SEE)->setOnclick('getOnClickModal("Abonnement en détail", '
                                                                            . '"/admin/' . Subscription::TABLENAME . '/{{id}}");');
    }

    public function buildColumns() {
        $columns = array('num_contract' => 'Contrat', 'num_bill' => 'Facture', 'user' => 'Utilisateur', 'ets' => "Etablissement", 'subscription' => 'Abonnement',
            'start_date' => 'Début', 'end_date' => 'Fin', /*'first_call' => '1er rappel', 'second_call' => "2ème rappel",*/
            'status' => "Etat");
        return $columns;
    }

    public function buildFilters() {
        $filters = array();
        /*
        // Free search
        $freeSearch = new DatatableFilter();
        $freeSearch->setInputType(DatatableFilter::INPUT_TEXT);
        $freeSearch->setName('designation');
        $freeSearch->setPlaceholder("Etablissement...");
        $freeSearch->setTable(Establishment::TABLENAME);
//        $freeSearch->setIsRaw(true);
        $freeSearch->setField('name');
        $freeSearch->setOperator(DatatableFilter::OPERATOR_LIKE_CONTAINS);
        $freeSearch->setValue(Request::get('filter.designation'));
        $filters[] = $freeSearch;
        */
        // Valid search
        $statusSearch = new DatatableFilter();
        $statusSearch->setInputType(DatatableFilter::INPUT_SELECT);
        $statusSearch->setLabel('Statut');
        $statusSearch->setName('status');
        $statusSearch->setPlaceholder("Tous");
        $statusSearch->setTable(Subscription::TABLENAME);
        $statusSearch->setField('status');
        $statusSearch->setEnableEmpty(false);
        $statusSearch->setOperator(DatatableFilter::OPERATOR_EQUAL);
        $statusSearch->setValue(Request::get('filter.status'));
        $statusSearch->setOptions(Subscription::getLabelByStatus());
        $filters[] = $statusSearch;

        return $filters;
    }


    public function getQueryIndex() {
        return Subscription::TABLENAME . '.id';
    }
    
    public function buildQuery() {
        $typeEts = SessionController::getInstance()->getUserTypeEts();
        
        $subscriptionQuery = DB::table(Subscription::TABLENAME)
                ->select([
                    Subscription::TABLENAME . '.*',
                    Establishment::TABLENAME . '.name AS ets_name',
                    Bill::TABLENAME . '.number AS bill_number',
                    Contract::TABLENAME . '.number AS contract_number',
                    BuyableItem::TABLENAME . '.designation AS subscription_label',
                    User::TABLENAME . '.id AS id_owner',
                    DB::raw('CONCAT('.User::TABLENAME . '.lastname, " ", '.User::TABLENAME . '.firstname) AS owner')
                ])
                ->join(Establishment::TABLENAME, Establishment::TABLENAME . '.id', '=', Subscription::TABLENAME . '.id_establishment')
                ->join(BuyableItem::TABLENAME, BuyableItem::TABLENAME . '.id', '=', Subscription::TABLENAME . '.id_buyable_item')
                ->join(Bill::TABLENAME, Bill::TABLENAME . '.id', '=', Subscription::TABLENAME . '.id_bill')
                ->join(Contract::TABLENAME, Contract::TABLENAME . '.id', '=', Bill::TABLENAME . '.id_contract')
                ->join(User::TABLENAME, User::TABLENAME . '.id', '=', Establishment::TABLENAME . '.id_user_owner')
        ;
        if (!empty($typeEts)) {
            $subscriptionQuery->where(Establishment::TABLENAME . '.id_business_type', '=', $typeEts);
        }
        $subscriptionQuery->orderBy(Subscription::TABLENAME . '.end_date', 'asc');
        
        return $subscriptionQuery;
    }

    public function buildResults(Collection $queryResults) {
        $results = array();
        
        foreach ($queryResults as $queryResult) {
            $uuid = UuidTools::getUuid($queryResult->id);

            $results[$uuid]['id'] = $uuid;
            $results[$uuid]['num_contract'] = $queryResult->contract_number;
            $results[$uuid]['num_bill'] = $queryResult->bill_number;
            $results[$uuid]['user'] = $queryResult->owner;
            $results[$uuid]['ets'] = $queryResult->ets_name;
            $results[$uuid]['subscription'] = $queryResult->subscription_label;
            $results[$uuid]['start_date'] = formatDate(new DateTime($queryResult->start_date));
            $results[$uuid]['end_date'] = formatDate(new DateTime($queryResult->end_date));
            $results[$uuid]['status'] = \App\Utilities\StyleTools::buildColoredSpan(Subscription::getLabelFromStatus($queryResult->status), 
                                                                                    Subscription::getColorClassFromStatus($queryResult->status));
        }
        
        return $results;
    }
}
