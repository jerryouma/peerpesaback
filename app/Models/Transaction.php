<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [ 'user_id', 'type', 'transaction_hash', 'chain', 'token', 'amount','fiat_amount' ];
}
