<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model{
	protected $table = 'tblcandidate';
	protected $primaryKey = 'strCandId';
	public $timestamps = false;
}