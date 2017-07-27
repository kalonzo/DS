<?php

namespace App\Models;



/**
 * Class EstablishmentMedia
 */
class EstablishmentMedia extends Model
{
    protected $table = 'establishment_medias';

    public $timestamps = true;

    protected $fillable = [
        'type',
        'filename',
        'extension',
        'size',
        'width',
        'height',
        'local_path',
        'position',
        'id_gallery',
        'id_draft_media'
    ];

    protected $guarded = [];

    
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



}