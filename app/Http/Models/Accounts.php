<?php


namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Accounts extends Model{

    protected  $table = 'accounts';
    protected $primaryKey = 'account_id';
    public $timestamps = false;


}