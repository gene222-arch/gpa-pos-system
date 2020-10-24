<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
// Pivot table == a table which holds the connection between two tables and does not have a Model/Class 
// Products inner join user_cart using user_id 
// 3rd Arg === this Model/Class which the relationship was defined first
// 4th Arg === the Model joined tthis class which is Product
    public function cart()
    {
        return $this->belongsToMany(Product::class, 'user_cart', 'user_id', 'product_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function getName () 
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getAvatar () 
    {
        return 'https://www.gravatar.com/avatar/' . \md5($this->email) ?? '';
    }


}
