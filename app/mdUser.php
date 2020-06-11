<?php

namespace App;

use App\model\mdaclGroup;
use App\model\mdOpd;
use App\model\mdPerusahaan;
use Illuminate\Database\Eloquent\Model;

class mdUser extends Model
{
    protected $table        = "users";
    protected $primaryKey   = "user_id";

    function GroupAcl(){
        return $this->belongsTo(mdaclGroup::class,"aclGroup_id");
    }
    function opd(){
        return $this->belongsTo(mdOpd::class,"opd_id");
    }
    function perusahaan(){
        return $this->hasOne(mdPerusahaan::class,"perusahaan_id");
    }
    
}
