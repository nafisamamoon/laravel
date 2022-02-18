<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
class Patient extends Model
{
    use HasFactory;
    public function person(){
        return $this->belongsTo('App\Models\Person');
    }
}
