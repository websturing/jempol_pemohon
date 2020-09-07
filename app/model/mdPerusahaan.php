<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class mdPerusahaan extends Model
{
    protected $table        = "perusahaan";
    protected $primaryKey   = "perusahaan_id";

    protected $appends = [
        'fullname',
    ];

    function getfullnameAttribute()
    {
        return $this->kategori . ". " . $this->nama;
    }
}
