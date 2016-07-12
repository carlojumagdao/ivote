<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class VoteDetail extends Model{
	protected $table = 'tblvotedetail';
	protected $primaryKey = 'strVDVHCode';
	public $timestamps = false;
}