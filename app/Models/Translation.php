<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Translation
 */
class Translation extends Model
{
    protected $table = 'translations';

    public $timestamps = false;

    protected $fillable = [
        'content',
        'id_language'
    ];

    protected $guarded = [];

    
	/**
	 * @return mixed
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @return mixed
	 */
	public function getIdLanguage() {
		return $this->id_language;
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
	public function setIdLanguage($value) {
		$this->id_language = $value;
		return $this;
	}



}