<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class element extends Model{
	protected $table = 'tbluielement';
	protected $primaryKey = 'intUIId';
	public $timestamps = false;
}