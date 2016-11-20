<?php


namespace App\Http\Models;


use Illuminate\Database\Eloquent\Model;

class Cities extends Model{

    protected  $table = 'cities';
    protected $primaryKey = 'city_id';
    public $timestamps = false;

    public function byCity( $city )
    {
        if( ! $city = static::where( 'city' , 'Like' , $city.'%' )
            ->first() ){
            return false;
        }

        return $city;
    }
}