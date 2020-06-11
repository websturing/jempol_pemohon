<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model; 
use App\model\mdModulSub;

class mdModul extends Model
{
    protected $table        = "modul";
    protected $primaryKey   = "modul_id";

    protected $appends = [
        'Child'
    ];

    function scopechild($query){
        return $query->where('type', 'child');
    }
    function getChildAttribute($query) {
        $crypt = $query->where('type', 'child');
        // return $this->opdi_id." - afriandi";
        return $crypt;
    }

}
