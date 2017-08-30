<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return Response
     */
    public function destroy($media) {
        $response = response();
        $jsonResponse = array('success' => 0);
        
        if(checkModel($media)){
            // TODO Additionnal checks to ensure user is allowed to delete media
            $deleted = $media->delete();
            if($deleted){
                $jsonResponse['success'] = 1;
            }
        }
        
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
}
