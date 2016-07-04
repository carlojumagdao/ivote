<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class MemberDetail extends Model{
	protected $table = 'tblMemberDetail';
	protected $primaryKey = 'intMemDeId';
	public $timestamps = false;
}