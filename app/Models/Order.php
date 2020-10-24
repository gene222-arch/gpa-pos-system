<?php

namespace App\Models;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id'
    ];

    public function items() 
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments() 
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if ($this->customer)
        {
            return $this->customer->first_name;
        }
    }

    public function getTotal()
    {
        return \number_format(
            $this->items->map(fn($i) => $i->price * $i->quantity)->sum(),
            2);
    }

    public static function total($orders)
    {
        if ($orders) {
            return \number_format(
                $orders->map(fn($o)=> $o->getTotal())->sum(), 
                2
            );
        }
        
    }

    public function receivedAmount()
    {
        return \number_format(
            $this->payments->map(fn($p) => $p->amount)->sum(), 
            2
        );
    }
    
    public static function totalReceivedAmount($orders)
    {
        if ($orders) {
            return \number_format(
                $orders->map(fn($ra)=> $ra->receivedAmount())->sum(), 
                2
            );
        }
    }


}

/**
 * Each relationship of many returns either single value or an Array of values matching the id from this Model from another Model
 */
