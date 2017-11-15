<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use View;

class SubscriptionController extends Controller
{
    /**
     * 
     * @param int $subscription
     * @return type
     */
    public function edit(Subscription $subscription) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $view = null;
        
        if(checkModel($subscription)){
            $view = View::make('admin.admin.subscription.edit')->with('subscription', $subscription);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
}
