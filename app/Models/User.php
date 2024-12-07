<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ethereum_wallet_address',    // Added Ethereum wallet
        'celo_wallet_address',        // Added Celo wallet
        'stellar_wallet_address',     // Added Stellar wallet
        'stellar_wallet_secret',      // Added Stellar wallet secret
        'mobile_money_wallet_id',     // Added Mobile Money wallet ID
        'mobile_money_phone',         // Added Mobile Money phone number
        'mobile_money_network',       // Added Mobile Money network
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'stellar_wallet_secret',       
        'ethereum_wallet_address',
        'celo_wallet_address',
        'mobile_money_wallet_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',        // Automatically hash passwords
    ];
}
