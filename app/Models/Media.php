<?php

namespace App\Models;

/**
 * Description of Media
 *
 * @author Nico
 */
class Media extends Model {

    public $timestamps = true;
    
    const TYPE_IMAGE = 1;
    
    const TYPE_USE_ETS_LOGO = 1;
    const TYPE_USE_ETS_HOME_PICS = 2;
    
    const DRIVE_LOCAL = 'local';
    const DRIVE_S3 = 's3';
    
    protected $fillable = [
        'type',
        'type_use',
        'filename',
        'extension',
        'size',
        'width',
        'height',
        'local_path',
        'position',
        'id_gallery',
        'id_draft_media',
        'drive',
        'public',
        'id_object_related'
    ];
    protected $guarded = [];
    
    
    public function delete() {
        if(checkModel($this)){
            \Illuminate\Support\Facades\Storage::delete($this->getLocalPath());
        }
        return parent::delete();
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @return mixed
     */
    public function getExtension() {
        return $this->extension;
    }

    /**
     * @return mixed
     */
    public function getSize() {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getWidth() {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight() {
        return $this->height;
    }

    /**
     * @return mixed
     */
    public function getLocalPath() {
        return $this->local_path;
    }

    /**
     * @return mixed
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * @return mixed
     */
    public function getIdGallery() {
        return $this->id_gallery;
    }

    /**
     * @return mixed
     */
    public function getIdDraftMedia() {
        return $this->id_draft_media;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setType($value) {
        $this->type = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFilename($value) {
        $this->filename = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setExtension($value) {
        $this->extension = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setSize($value) {
        $this->size = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setWidth($value) {
        $this->width = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setHeight($value) {
        $this->height = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLocalPath($value) {
        $this->local_path = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPosition($value) {
        $this->position = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdGallery($value) {
        $this->id_gallery = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdDraftMedia($value) {
        $this->id_draft_media = $value;
        return $this;
    }

    function getDrive() {
        return $this->drive;
    }

    function getPublic() {
        return $this->public;
    }

    function setDrive($drive) {
        $this->drive = $drive;
    }

    function setPublic($public) {
        $this->public = $public;
    }
    
    function getIdObjectRelated() {
        return $this->id_object_related;
    }

    function setIdObjectRelated($id_object_related) {
        $this->id_object_related = $id_object_related;
    }

    function getTypeUse() {
        return $this->type_use;
    }

    function setTypeUse($type_use) {
        $this->type_use = $type_use;
    }


}
