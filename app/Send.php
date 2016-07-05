<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Member extends Model{
	protected $table = 'tblMember';
	protected $primaryKey = 'strMemberId';
	public $timestamps = false;
}