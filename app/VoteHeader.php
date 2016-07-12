<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class VoteHeader extends Model{
	protected $table = 'tblvoteheader';
	protected $primaryKey = 'strVHCode';
	public $timestamps = false;
}