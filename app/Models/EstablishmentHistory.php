<?php

namespace App\Models;

/**
 * Class EstablishmentHistory
 */
class EstablishmentHistory extends Model {

    protected $table = 'establishment_history';
    const TABLENAME = 'establishment_history';
    
    public $timestamps = true;
    protected $fillable = [
        'year',
        'title',
        'content',
        'id_photo',
        'id_establishment',
    ];
    protected $guarded = [];

    /**
     * 
     * @param EstablishmentHistory $stories
     * @param type $jsonEncoded
     * @return string
     */
    public static function getMediaConfigForInputFile($stories, $jsonEncoded = true) {
        $mediaConfig = array();
        if ($stories instanceof EstablishmentHistory) {
            $stories = array($stories);
        }
        if (!empty($stories)) {
            foreach ($stories as $story) {
                $media = $story->media()->first();
                if($media instanceof Media){
                    $instanceConfig = array(
                        'caption' => $story->getTitle()
                                    .'<br/>'
                                    .$story->getYear(),
                        'size' => '',
                        'key' => $media->getUuid(),
                        'url' => '/delete/' . $media::TABLENAME . '/' . $media->getUuid(),
                    );
                    $mediaConfig[] = $instanceConfig;
                }
            }
        }
        if ($jsonEncoded) {
            return json_encode($mediaConfig);
        } else {
            return $mediaConfig;
        }
    }
    /**
     * 
     * @return Media
     */
    public function media(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_photo');
    }
    
    /**
     * 
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_establishment');
    }
    
    /**
     * @return mixed
     */
    public function getYear() {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getIdPhoto() {
        return $this->id_photo;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setYear($value) {
        $this->year = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setTitle($value) {
        $this->title = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setContent($value) {
        $this->content = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdPhoto($value) {
        $this->id_photo = $value;
        return $this;
    }

    function getIdEstablishment() {
        return $this->id_establishment;
    }

    function setIdEstablishment($id_establishment) {
        $this->id_establishment = $id_establishment;
    }

}
