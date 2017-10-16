<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Utilities\StorageHelper;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class MediaController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
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
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
     * @return View
     */
    public function moderateMedia(\App\Models\EstablishmentMedia $media) {
        $response = response();
        $jsonResponse = array('success' => 0);
        $establishment = $media->establishment()->first();

        $view = View::make('admin.admin.media.moderate')
                ->with('new_media', $media)
                ->with('establishment', $establishment)
                ;
        if ($view instanceof \Illuminate\View\View) {
            $view->with('ajax', 1);
            $jsonResponse['content'] = $view->render();
            $jsonResponse['success'] = 1;
        }
        $responsePrepared = $response->json($jsonResponse);
        return $responsePrepared;
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
     * @return View
     */
    public function validateMedia(\App\Models\EstablishmentMedia $media) {
        try{
            if(checkModelId($media->getIdOriginalMedia())){
                $originalMedia = $media->mediaOriginal()->first();
                if(checkModel($originalMedia)){

                    $media->setIdOriginalMedia(0);
                    switch($media->getTypeUse()){
                        case Media::TYPE_USE_ETS_LOGO:
                            $establishment = $media->establishment()->first();
                            if(checkModel($establishment)){
                                $establishment->setIdLogo($media->getId())->save();
                            }
                            break;
                        case Media::TYPE_USE_ETS_VIDEO:
                            $establishment = $media->establishment()->first();
                            if(checkModel($establishment)){
                                $establishment->setIdVideo($media->getId())->save();
                            }
                            break;
                        case Media::TYPE_USE_ETS_THUMBNAIL:
                            $establishment = $media->establishment()->first();
                            if(checkModel($establishment)){
                                $establishment->setIdThumbnail($media->getId())->save();
                            }
                            break;
                    }

                    $originalMedia->setIdEstablishment(0);
                    $originalMedia->delete();
                }
            }
            $media->setStatus(Media::STATUS_VALIDATED)->save();
        } catch (Exception $ex) {
            // TODO Display errors
        }
        // TODO Send notification
        return redirect('/admin');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  Media  $media
     * @return View
     */
    public function denyMedia(\App\Models\EstablishmentMedia $media) {
        try{
            if(checkModelId($media->getIdOriginalMedia())){
                $originalMedia = $media->mediaOriginal()->first();
                if(checkModel($originalMedia)){
                    $originalMedia->setIdDraftMedia(0)->save();
                }
            }
            $media->setIdEstablishment(0);
            $media->delete();
        } catch (Exception $ex) {
            // TODO Display errors
        }
        // TODO Send notification
        return redirect('/admin');
    }
}
