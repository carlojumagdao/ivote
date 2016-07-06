<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SurveyDetail extends Model{
	protected $table = 'tblSurveyDetail';
	protected $primaryKey = 'intSDId';
	public $timestamps = false;
}