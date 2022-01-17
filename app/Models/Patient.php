<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    // protected $table = 'tbl_patient';
    protected $guarded = ['id'];

    public function gender (){
        return $this->belongsTo(Gender::class);
    }

    public function service (){
        return $this->belongsTo(Service::class);
    }
}
