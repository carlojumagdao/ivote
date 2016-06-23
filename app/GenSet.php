<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class GenSet extends Model{
	protected $table = 'tblSetting';
	protected $primaryKey = 'intSettingId';
	public $timestamps = false;
}