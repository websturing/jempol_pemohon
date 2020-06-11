<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model; 
use App\model\mdacl;
use Illuminate\Support\Facades\Session;

class mdModul extends Model
{
    protected $table        = "modul";
    protected $primaryKey   = "modul_id";

    protected $appends = [
        'crud'
    ];


    
    function getcrudAttribute($query) {
        $acl = $this->aclBySessionaclGroup_id()->count();
        if($acl == null){
            $crypt = array(
                "read" => false,
                "create" => false,
                "update" => false,
                "delete" => false,
            );
        }
        else{
            $crypt = array(
                "read"      => json_decode($this->aclBySessionaclGroup_id->read),
                "create"    => json_decode($this->aclBySessionaclGroup_id->create),
                "update"    => json_decode($this->aclBySessionaclGroup_id->update),
                "delete"    => json_decode($this->aclBySessionaclGroup_id->delete),
            );
        }
        return $crypt;
    }

    function aclBySessionaclGroup_id(){
        return $this->hasOne(mdacl::class,'modul_id')->where('aclGroup_id',Session::get('aclGroup_id'));
    }
}
