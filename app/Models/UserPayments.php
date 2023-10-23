<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayments extends Model
{
    use HasFactory;
    public function user(){
        return $this->hasOne(User::class,"id",'user_id');
    } 
    public function payment(){
        return $this->hasOne(UserPayments::class,"user_id",'id');
    } 
}
