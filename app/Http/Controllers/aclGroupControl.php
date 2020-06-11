<?php

namespace App\Http\Controllers;

use App\model\mdacl;
use App\model\mdaclGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class aclGroupControl extends Controller
{

    function index(Request $r){
        $type = $r->get("type");
        if($type == 'dataAll'){
            return self::dataByAll($r);
        }
        elseif($type == 'putsession'){
            return self::putSession($r);
        }
        elseif($type == 'hapus'){
            return self::hapus($r);
        }
        
    }
    
    function dataByAll(Request $r){
        return mdaclGroup::all();
    }

    function putSession(Request $r){ 
        $aclGroup_id = $r->get('aclGroup_id');
        Session::forget("aclGroup_id");
        Session::put("aclGroup_id",$aclGroup_id);
    }

    public function insertdata(Request $r){
        $data = $r->get("aclGroup");
       
        $toDB = array(
            "nama"   => $data['nama'],
            "is_active"   => $data['is_active'],
        );
       
        $cek1 = mdaclGroup::where("aclGroup_id",$data["aclGroup_id"])->get();
        $countC1 = count($cek1);

        if($countC1 > 0){
            mdaclGroup::where("aclGroup_id", $data["aclGroup_id"])->update($toDB);
            $aclGroup_id = $data['aclGroup_id'];
        }
        else{
            mdaclGroup::insert($toDB);
            $aclGroup_id = DB::getPdo()->lastInsertId();
        }
        return $aclGroup_id;

    }

    function hapus(Request $r){
        mdaclGroup::where('aclGroup_id', $r->get('aclId'))->delete();
        mdacl::where('aclGroup_id', $r->get('aclId'))->delete();
    }
}
