<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    public $timestamps = false;
    protected $fillable = ['nama_product','deskripsi','harga','foto_product'];
}
