<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ui extends Model{
	protected $table = 'tbluielement';
	protected $primaryKey = 'intUIId';
	public $timestamps = false;
}