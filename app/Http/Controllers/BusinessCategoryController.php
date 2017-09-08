<?php

namespace App\Http\Controllers;

use View;
use App\Utilities\UuidTools;
use App\Models\BusinessCategory;

class BusinessCategoryController extends Controller {
    /**
     * 
     * @param \App\Http\Request $request
     * @param BusinessCategory $businessCategory
     * @return type
     */
    public function edit(\App\Http\Request $request, BusinessCategory $businessCategory) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $view = null;
        
        if(checkModel($businessCategory)){
            switch ($businessCategory->getStatus()) {
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
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
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
        return redirect('/admin');
    }

    public function destroy($id) {
        $businessCategory = BusinessCategory::where('id', '=', $id)->first();
        if (checkModel($businessCategory)) {
            $businessCategory->delete();
        }
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
