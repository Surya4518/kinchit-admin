<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpressInterest extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'expressinterest';

    protected $fillable = [
        'eisender',
        'eireceiver',
        'eimsg',
        'eisentdt',
        'eisender_accept',
        'eirec_accept',
        'eisender_decline',
        'eirec_decline',
        'dec_msg',
        'readed'
    ];

    protected $dates = ['deleted_at'];

}
