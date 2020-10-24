<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'avatar',
        'user_id'
    ];

// if FK is default, this Class expects that there is a customer_id in the phones table
    public function phone () {

        return $this->hasOne('App\Models\Phone');
    }

}
