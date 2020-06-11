<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;
use App\model\mdModul;

class mdacl extends Model
{
    protected $table        = "acl";
    protected $primaryKey   = "acl_id";

    function modul(){
        return $this->belongsTo(mdModul::class, 'modul_id');
    }

}
