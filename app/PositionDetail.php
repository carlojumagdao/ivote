<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class PositionDetail extends Model{
	protected $table = 'tblPositionDetail';
	protected $primaryKey = 'intPosDeId';
	public $timestamps = false;
}