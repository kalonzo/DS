<?php

namespace App\Http\Controllers;

use App\Feeders\DatatableFeeder;

/**
 * Description of DatatableController
 *
 * @author Nico
 */
class DatatableController {

    /**
     * 
     * @param type $id
     * @return DatatableFeeder
     */
    public static function buildDatatable($id) {
        $dtFeeder = null;

        switch ($id) {
            case \App\Datatables\DtEstablishmentAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtEstablishmentAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtBookingAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtBookingAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtBookingPro::DT_ID:
                $dtFeeder = new \App\Datatables\DtBookingPro();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtBusinessCategoryAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtBusinessCategoryAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtBusinessTypeAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtBusinessTypeAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtPromotionAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtPromotionAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtEventAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtEventAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtEstablishmentMediaModeration::DT_ID:
                $dtFeeder = new \App\Datatables\DtEstablishmentMediaModeration();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtUserAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtUserAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtUserProAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtUserProAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtPaymentMethodAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtPaymentMethodAdmin();
                $dtFeeder->run();
                break;
            case \App\Datatables\DtSubscriptionAdmin::DT_ID:
                $dtFeeder = new \App\Datatables\DtSubscriptionAdmin();
                $dtFeeder->run();
                break;
        }
        return $dtFeeder;
    }

}
