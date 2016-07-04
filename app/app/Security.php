<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Security extends Model{
	protected $table = 'tblSecurityQuestion';
	protected $primaryKey = 'intSecQuesId';
	public $timestamps = false;
}