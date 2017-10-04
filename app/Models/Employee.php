<?php

namespace App\Models;

/**
 * Class Employee
 */
class Employee extends Model implements Interfaces\EstablishmentBoundable{

    protected $table = 'employees';
    const TABLENAME = 'employees';
    
    const STATUS_ACTIVE = 1;
    
    public $timestamps = true;
    protected $fillable = [
        'lastname',
        'firstname',
        'status',
        'id_photo',
        'position',
        'id_establishment',
        'id_job_type'
    ];
    protected $guarded = [];

    public function getJobTypeLabel(){
        $jobTypeLabel = 'Type non défini';
        $jobTypeLabels = JobType::getLabelByType();
        if(isset($jobTypeLabels[$this->getIdJobType()])){
            $jobTypeLabel = $jobTypeLabels[$this->getIdJobType()];
        }
        return $jobTypeLabel;
    }
    
    /**
     * 
     * @param Employee $employees
     * @param type $jsonEncoded
     * @return string
     */
    public static function getMediaConfigForInputFile($employees, $jsonEncoded = true) {
        $mediaConfig = array();
        if ($employees instanceof Employee) {
            $employees = array($employees);
        }
        if (!empty($employees)) {
            foreach ($employees as $employee) {
                $media = $employee->media()->first();
                if($media instanceof Media){
                    $instanceConfig = array(
                        'caption' => $employee->getFirstname().' '.$employee->getLastname()
                                    .'<br/>'
                                    .$employee->getPosition(),
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
     * @return Establishment
     */
    public function establishment(){
        return $this->hasOne(Establishment::class, 'id', 'id_establishment');
    }
    
    /**
     * 
     * @return Media
     */
    public function media(){
        return $this->hasOne(EstablishmentMedia::class, 'id', 'id_photo');
    }
    
    /**
     * @return mixed
     */
    public function getLastname() {
        return $this->lastname;
    }

    /**
     * @return mixed
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getIdPhoto() {
        return $this->id_photo;
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
    public function getIdEstablishment() {
        return $this->id_establishment;
    }

    /**
     * @return mixed
     */
    public function getIdJobType() {
        return $this->id_job_type;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setLastname($value) {
        $this->lastname = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setFirstname($value) {
        $this->firstname = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setStatus($value) {
        $this->status = $value;
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
    public function setIdEstablishment($value) {
        $this->id_establishment = $value;
        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setIdJobType($value) {
        $this->id_job_type = $value;
        return $this;
    }

}
