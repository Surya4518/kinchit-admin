<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Approvalrequest extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'approval_requests';

    protected $fillable = [
        'from_id',
        'to_id',
        'request_type',
        'request_reason',
        'request_from',
        'is_approved',
        'rejected_reason',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
