<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model{
	protected $table = 'tblaudit';
	protected $primaryKey = 'tblmemaudId';
	public $timestamps = false;
}