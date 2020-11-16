<?php

namespace App\Models;
use Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class User extends Model
{
   protected $table = 'tbl_user';
   public $timestamps = false;
	
}
