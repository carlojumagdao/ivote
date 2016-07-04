<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DynamicField extends Model{
	protected $table = 'tblDynamicField';
	protected $primaryKey = 'intDynFieldId';
	public $timestamps = false;
}