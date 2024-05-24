<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gnanakaithaa extends Model
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $table = 'gnanakaithaa';

    protected $fillable = [
        'name_of_student',
        'contact_no',
        'email',
        'age',
        'dob',
        'door_no',
        'state',
        'city',
        'pincode',
        'door_no1',
        'state1',
        'city1',
        'pincode1',
        'name_of_parent',
        'email1',
        'aadhaar_no',
        'no_of_siblings',
        'family_annual_Income',
        'parent_work',
        'from_education',
        'from_school',
        'from_mark_sheet',
        'to_education',
        'to_school',
        'to_mark_sheet',
        'bagavathar_name',
        'volunteer_contact_number',
        'declaration',
        'payment_type',
        'is_approved'
    ];

    protected $dates = ['deleted_at'];

}
