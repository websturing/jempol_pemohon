<?php

namespace App\Http\Controllers;

use App\model\mdacl;
use App\model\mdModul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\aclGroupControl;
use App\model\mdaclGroup;

class aclControl extends Controller
{
   

    function index(Request $r){
        $type = $r->get("type");
        if($type == 'navbar'){
           return self::navbar($r);
        }
        elseif($type == 'insert'){
            return self::insert($r);
        }
        
        elseif($type == 'AclData'){
            return self::AclData($r);
        }
        
    }
    function aclGet(){
        return mdacl::with(['modul'])
            ->get();
    }

    function insert(Request $r){
        $data = $r->get('data');
        $aclGroupControlsdasd = new aclGroupControl;
        $aclGroup_id = $aclGroupControlsdasd->insertdata($r);
        
        // return $data;
        for($i = 0; $i < count($data); $i++){
            $toDB = array(
                    "modul_id"   => $data[$i]['modul_id'],
                    "read"       => json_encode($data[$i]['crud']['read']),
                    "create"     => json_encode($data[$i]['crud']['create']),
                    "update"     => json_encode($data[$i]['crud']['update']),
                    "delete"     => json_encode($data[$i]['crud']['delete']),
                    "is_active"  => json_encode($data[$i]['crud']['read']),
                    "aclGroup_id"  => $aclGroup_id
            );
            
            $cek1 = mdacl::where("modul_id",$data[$i]["modul_id"])
                            ->where("aclGroup_id",$aclGroup_id)
                            ->get();
            $countC1 = count($cek1);
            
            if($countC1 > 0){
                mdacl::where("modul_id", $data[$i]["modul_id"])
                    ->where("aclGroup_id",$aclGroup_id)
                    ->update($toDB);
            }
            else{
                mdacl::insert($toDB);
            }

            for($a = 0; $a < count($data[$i]['children']); $a++){
                if(count($data[$i]['children']) > 0){
                    $toDB2 = array(
                        "modul_id"   => $data[$i]["children"][$a]['modul_id'],
                        "read"       => json_encode($data[$i]["children"][$a]['crud']['read']),
                        "create"     => json_encode($data[$i]["children"][$a]['crud']['create']),
                        "update"     => json_encode($data[$i]["children"][$a]['crud']['update']),
                        "delete"     => json_encode($data[$i]["children"][$a]['crud']['delete']),
                        "is_active"  => json_encode($data[$i]["children"][$a]['crud']['read']),
                        "aclGroup_id"  => $aclGroup_id
                    );
        
                    $cek2 = mdacl::where("modul_id",$data[$i]["children"][$a]["modul_id"])
                                    ->where("aclGroup_id",$aclGroup_id)
                                    ->get();
                    $countC2 = count($cek2);
        
                    if($countC2 > 0){
                        mdacl::where("modul_id", $data[$i]["children"][$a]["modul_id"])
                                ->where("aclGroup_id",$aclGroup_id)   
                                ->update($toDB2);
                    }
                    else{
                        mdacl::insert($toDB2);
                    }
                }
            }
            
        }
        Session::forget("aclGroup_id");
    }
    

    function navbar(Request $r){
       
        $acl = mdacl::with(['modul'])
            ->where('is_active',"true")
            ->where('aclGroup_id', Session::get('aclGroupId'))
            ->get();

        return array(
            "account" => Session::get('username'),
            "menu" => $acl,
        );

    }

    function AclData(Request $r){
        $aclGroup = $r->get('aclGroup');

        $modul =  mdModul::where("type",'main')
                        ->orWhere("type",'parent')
                        ->orderby("nama",'ASC')
                        ->get();

        foreach($modul as $index => $m){
            $child = mdModul::where("type",'child')
                            ->where("parent_id", $m->modul_id)
                            ->orderby("nama",'ASC')
                            ->get();

           $newData = array(
               "modul_id" => $m->modul_id,
               "nama" => $m->nama,
               "url" => $m->url,
               "created_at" => $m->created_at,
               "updated_at" => $m->updated_at,
               "is_active" => $m->is_active,
               "type" => $m->type,
               "parent_id" => $m->parent_id,
               "icon" => $m->icon,
               "crud" => $m->crud,
               "children" => $child,
           );
           $data[] = $newData;
           
        }
        
       

        return $data;
    }
}
