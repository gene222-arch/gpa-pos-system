<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'customer_id'
    ];


    public function customer () {

        return $this->belongsTo('App\Models\Customer');
    }


}
