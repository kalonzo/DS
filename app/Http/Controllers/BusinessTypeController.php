<?php
namespace App\Http\Controllers;

use App\Http\Controllers\FileController;
use App\Models\BusinessCategory;
use App\Models\BusinessType;
use App\Models\Media;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BusinessTypeController extends Controller
{
    /**
     * 
     * @param int $idBusinessType
     * @return type
     */
    public function edit($idBusinessType) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $view = null;
        
        $businessType = BusinessType::find($idBusinessType);
        if(checkModel($businessType)){
            $jsonResponse['test'] = $businessType->getId();
            $view = View::make('admin.admin.business_type.feed')->with('businessType', $businessType)
                    ->with('status', BusinessType::getLabelByStatus());
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    /**
     * 
     * @param Request $request
     * @param BusinessCategory $businessType
     * @return type
     */
    public function update(\App\Http\Requests\StoreBusinessType $request, BusinessType $businessType) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        try {
            if(checkModel($businessType)){
                $businessType->update([
                    'label' => $request->get('label'),
                    'status' => $request->get('status'),
                ]);
                $jsonResponse['success'] = 1;
                $jsonResponse['test'] = $businessType->getLabel();
                $media = FileController::storeFile('media', Media::TYPE_USE_BUSINESS_TYPE, $businessType, $businessType->media()->first());
                if(checkModel($media)){
                    $businessType->setIdMedia($media->getId());
                }
                $businessType->save();
            }
        } catch (Exception $ex) {
            foreach ($createdObjects as $createdObject) {
                if ($createdObject instanceof Model) {
                    $createdObject->delete();
                }
            }
            $jsonResponse['error'] = $ex->getMessage();
        }
        
        if($request->ajax()){
            $responsePrepared = $response->json($jsonResponse);
            return $responsePrepared;
        } else {
            return redirect('/admin');
        }
    }
}
