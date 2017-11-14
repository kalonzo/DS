<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentMethod;
use App\Models\BusinessCategory;
use App\Models\PaymentMethod;
use App\Models\Media;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PaymentMethodController extends Controller
{
    /**
     * 
     * @param int $idPaymentMethod
     * @return type
     */
    public function edit($idPaymentMethod) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $view = null;
        
        $paymentMethod = PaymentMethod::find($idPaymentMethod);
        if(checkModel($paymentMethod)){
            $view = View::make('admin.admin.payment_method.feed')->with('paymentMethod', $paymentMethod)
                    ->with('status', PaymentMethod::getLabelByStatus());
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    /**
     * 
     * @param Request $request
     * @param BusinessCategory $paymentMethod
     * @return type
     */
    public function update(StorePaymentMethod $request, PaymentMethod $paymentMethod) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $createdObjects = array();
        try {
            if(checkModel($paymentMethod)){
                $paymentMethod->update([
                    'name' => $request->get('name'),
                    'status' => $request->get('status'),
                ]);
                $jsonResponse['success'] = 1;
                $logo = FileController::storeFile('logo', Media::TYPE_USE_PAYMENT_METHOD, $paymentMethod, $paymentMethod->logo()->first());
                if(checkModel($logo)){
                    $paymentMethod->setIdLogo($logo->getId());
                }
                $paymentMethod->save();
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
