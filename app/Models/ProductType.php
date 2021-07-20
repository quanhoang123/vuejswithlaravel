<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;
    protected $table = 'type_products';

    protected $fillabel = ['name','desciption', 'image'];

    public $timestamp = true;

    public function products(){
        return $this->hasMany('App\Product' , 'id_type' ,'id');
    }
}