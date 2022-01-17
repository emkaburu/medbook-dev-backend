<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    // protected $table = 'tbl_service';
    protected $guarded = ['id'];

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }
}
