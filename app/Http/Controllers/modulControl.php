<?php

namespace App\Http\Controllers;

use App\model\mdModul;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class modulControl extends Controller
{
    function index(Request $r){
        $type = $r->get("type");
        if($type == 'dataAll'){
           return self::DataAll($r);
        }
        elseif($type == 'dataChild'){
            return self::dataChild($r);
        }
        elseif($type == 'modulByname'){
            return self::modulByname($r);
        }
        elseif($type == 'insert'){
            return self::insert($r);
        }
        elseif($type == 'update'){
            return self::update($r);
        }
        elseif($type == 'delete'){
            return self::delete($r);
        }
    }

    function DataAll(Request $r){
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

    function dataChild(Request $r){
        return mdModul::where("type",'child')
                        ->orderby("nama",'ASC')
                        ->get();
    }

    function modulByname(Request $r){
        $nama  = $r->get('nama');

        $modul = mdModul::where("nama",$nama)
                        ->get();

        if(count($modul) > 0){
            return "false";
        }
        else{
            return "true";
        }

    }

    /*-----------------------------=== CRUD ===----------------------*/
    function insert(Request $r){
        $data = $r->get('data');
        $toDB = array(
                "nama"          => $data['nama'],
                "url"           => $data['url'],
                "is_active"     => $data['is_active'],
                "type"          => $data['type'],
                "parent_id"     => $data['parent_id'],
                "icon"          => $data['icon'],
        );
        mdModul::insert($toDB);

        return array(
            "title" => "Berhasil",
            "message" => "Data Form Modul Berhasil Di Input",
            "type" => "success",
            
        );
        
    }
    function update(Request $r){
        $data = $r->get('data');
        $toDB = array(
                "nama"          => $data['nama'],
                "url"           => $data['url'],
                "is_active"     => $data['is_active'],
                "type"          => $data['type'],
                "parent_id"     => $data['parent_id'],
                "icon"          => $data['icon'],
        );
        mdModul::where('modul_id', $data['modul_id'])->update($toDB);

        return array(
            "title" => "Berhasil",
            "message" => "Data Form Modul Berhasil Di Update",
            "type" => "success",
            
        );
        
    }
    function delete(Request $r){
        $data = $r->get('data');
        mdModul::where('modul_id', $data['modul_id'])->delete();
        return array(
            "title" => "Berhasil",
            "message" => "Data Form Modul Berhasil Di Hapus",
            "type" => "success",
            
        );

    }
    
  
}
