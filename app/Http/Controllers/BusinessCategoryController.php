<?php

namespace App\Http\Controllers;

use App\Http\Request;
use View;
use App\Models\Establishment;
use App\Utilities\UuidTools;
use App\Models\BusinessCategory;

class BusinessCategoryController extends Controller {

    /**
     * 
     * @return View
     */
    public function index() {
        
    }

    /**
     * 
     * @param BusinessCategory $businessCategory
     * @return type
     */
    public function edit(BusinessCategory $businessCategory) {
        
        switch ($businessCategory->status) {
            case BusinessCategory::STATUS_TO_CHECK :
                $status = array();
                $status[] = 'En attente de validation';
                $status[] = false;
                break;
            default :
                $status[] = 'Confirmé par Dinerscope';
                break;
        }

        $view = View::make('admin.business_categories')->with('businessCategory', $businessCategory)
                ->with('status', $status);
        return $view;
    }

    /**
     * 
     * @param \Illuminate\Http\Request $request
     * @param BusinessCategory $businessCategory
     * @return type
     */
    public function update(\Illuminate\Http\Request $request, BusinessCategory $businessCategory) {        
        $businessCategory->update([
            'name' => $request->get('name'),
            'type' => $request->get('type'),
            'status' => null,
        ]);
        $businessCategory->save();
       // $establishment = $this->updateEstablishment($request, $establishment);
        return redirect('/admin');
    }
    
    public function destroy( $id) {        
        die('Destroy');
        return redirect('/admin');
    }
    
    /**
     * 
     * @param type $idEstablishment
     * @param type $name
     * @param type $type
     */
    function linkBusinessCategory($idEstablishment, $name, $type) {
        $businessModel = \App\Models\BusinessCategory::where('name', '=', $name)->where('type', '=', $type)->first();
        if (checkModel($businessModel)) {
            self::feedEstablishmentBusinessCategory($businessModel->getId(), $idEstablishment);
        } else {
            $specialityModel = \App\Models\BusinessCategory::create([
                        'id' => UuidTools::generateUuid(),
                        'name' => $name,
                        'type' => $type,
                        'status' => BusinessCategory::STATUS_TO_CHECK
            ]);
            self::feedEstablishmentBusinessCategory($specialityModel->getId(), $idEstablishment);
        }
    }
}