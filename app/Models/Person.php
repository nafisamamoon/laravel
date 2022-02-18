<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use App\Models\Patient;
class Person extends Authenticatable
{
    public $table='persons';
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    //public function mypats(){
       // return $this->hasMany('App\Models\Mypat');
   // }
   public function patients(){
       return $this->hasMany('App\Models\Patient');
   }
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'age',
        'address',
        'qualifications',
        'phone_number',
        'path'
    ];
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
