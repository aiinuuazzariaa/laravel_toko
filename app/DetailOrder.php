<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    protected $table = 'detail_order';
    public $timestamps = false;
    protected $fillable = ['id_orders','id_product','qty', 'subtotal'];
}
