<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SurveyHeader extends Model{
	protected $table = 'tblSurveyHeader';
	protected $primaryKey = 'intSHId';
	public $timestamps = false;
}