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
    const TYPE_VIDEO = 2;
    const TYPE_APPLICATION = 3;
    const TYPE_TEXT = 4;
    
    const TYPE_USE_ETS_LOGO = 1;
    const TYPE_USE_ETS_HOME_PICS = 2;
    const TYPE_USE_ETS_GALLERY_ITEM = 3;
    const TYPE_USE_ETS_MENU = 4;
    const TYPE_USE_ETS_DISH = 5;
    const TYPE_USE_ETS_EMPLOYEE = 6;
    const TYPE_USE_ETS_STORY = 7;
    const TYPE_USE_ETS_VIDEO = 8;
    const TYPE_USE_ETS_PROMO = 9;
    const TYPE_USE_ETS_EVENT = 10;
    const TYPE_USE_BUSINESS_TYPE = 11;
    const TYPE_USE_ETS_THUMBNAIL = 12;
    const TYPE_USE_PAYMENT_METHOD = 13;
    
    const STATUS_PENDING = 1;
    const STATUS_VALIDATED = 2;
    
    const DRIVE_LOCAL = 'local';
    const DRIVE_S3 = 's3';
    
    protected $fillable = [
        'status',
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
        'id_original_media',
        'drive',
        'public',
        'id_object_related'
    ];
    protected $guarded = [];
    
    public function delete() {
        if(checkModel($this)){
            switch($this->getTypeUse()){
                case self::TYPE_USE_ETS_LOGO:
                    $establishment = $this->establishment()->first();
                    if(checkModel($establishment)){
                        $establishment->setIdLogo(0)->save();
                    }
                    break;
                case self::TYPE_USE_ETS_VIDEO:
                    $establishment = $this->establishment()->first();
                    if(checkModel($establishment)){
                        $establishment->setIdVideo(0)->save();
                    }
                    break;
                case self::TYPE_USE_ETS_THUMBNAIL:
                    $establishment = $this->establishment()->first();
                    if(checkModel($establishment)){
                        $establishment->setIdThumbnail(0)->save();
                    }
                    break;
                case self::TYPE_USE_ETS_MENU:
                    $this->menu()->delete();
                    break;
                case self::TYPE_USE_ETS_DISH:
                    $this->dish()->delete();
                    break;
                case self::TYPE_USE_ETS_EMPLOYEE:
                    $this->employee()->delete();
                    break;
                case self::TYPE_USE_ETS_STORY:
                    $this->story()->delete();
                    break;
            }
            \Illuminate\Support\Facades\Storage::delete($this->getLocalPath());
        }
        return parent::delete();
    }
    
    public static function getAllClassByTablename(){
        $classByTablename = array();
        $classByTablename[EstablishmentMedia::TABLENAME] = EstablishmentMedia::class;
        $classByTablename[CvMedia::TABLENAME] = CvMedia::class;
        
        return $classByTablename;
    }
    
    public static function getAllTypeLabel(){
        $types = array();
        $types[self::TYPE_IMAGE] = 'image';
        $types[self::TYPE_VIDEO] = 'video';
        $types[self::TYPE_APPLICATION] = 'application';
        $types[self::TYPE_TEXT] = 'text';
        
        return $types;
    }
    
    public function getTypeLabel(){
        $types = self::getAllTypeLabel();
        $typeLabel = '';
        if(isset($types[$this->getType()])){
            $typeLabel = $types[$this->getType()];
        }
        return $typeLabel;
    }
    
    public function getMimeType(){
        $mimetype = null;
        $type = $this->getTypeLabel();
        $ext = $this->getExtension();
        if(!empty($type) && !empty($ext)){
            switch($ext){
                case 'doc':
                case 'docx':
                    $ext = 'msword';
                    break;
            }
            $mimetype = $type.'/'.$ext;
        }
        return $mimetype;
    }
    
    /**
     * 
     * @param type $tablename
     * @return Media
     */
    public static function getClassFromTablename($tablename){
        $class = null;
        $classByTablename = self::getAllClassByTablename();
        if(isset($classByTablename[$tablename])){
            $class = $classByTablename[$tablename];
        }
        return $class;
    }
    
    public function menu(){
        $menu = null;
        if($this->getTypeUse() == self::TYPE_USE_ETS_MENU){
            $menu = $this->hasOne(Menu::class, 'id', 'id_object_related');
        }
        return $menu;
    }
    
    public function dish(){
        $dish = null;
        if($this->getTypeUse() == self::TYPE_USE_ETS_DISH){
            $dish = $this->hasOne(Dish::class, 'id', 'id_object_related');
        }
        return $dish;
    }
    
    public function employee(){
        $employee = null;
        if($this->getTypeUse() == self::TYPE_USE_ETS_EMPLOYEE){
            $employee = $this->hasOne(Employee::class, 'id', 'id_object_related');
        }
        return $employee;
    }
    
    public function story(){
        $story = null;
        if($this->getTypeUse() == self::TYPE_USE_ETS_STORY){
            $story = $this->hasOne(EstablishmentHistory::class, 'id', 'id_object_related');
        }
        return $story;
    }
    
    public function paymentMethod(){
        $paymentMethod = null;
        if($this->getTypeUse() == self::TYPE_USE_PAYMENT_METHOD){
            $paymentMethod = $this->hasOne(PaymentMethod::class, 'id', 'id_object_related');
        }
        return $paymentMethod;
    }
    
    public function establishment(){
        $establishment = $this->hasOne(Establishment::class, 'id', 'id_establishment');
        return $establishment;
    }
    
    public function mediaOriginal(){
        return $this->hasOne(static::class, 'id', 'id_original_media');
    }
    
    public function mediaDraft(){
        return $this->hasOne(static::class, 'id', 'id_draft_media');
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

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function getIdOriginalMedia() {
        return $this->id_original_media;
    }

    function setIdOriginalMedia($id_original_media) {
        $this->id_original_media = $id_original_media;
        return $this;
    }



}
