<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets';

    public $timestamps = false;

    protected $fillable = [
        'created_at',
        'user_id',
        'amount',
        'reference_id',
    ];



}
