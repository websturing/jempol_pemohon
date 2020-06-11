<?php

namespace App\Http\Controllers;

use App\mdBerita;
use Illuminate\Http\Request;
use stdClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class beritaControl extends Controller
{

    function index(Request $r){
        $type = $r->get("type");
        if($type == 'HastagFull'){
           return self::HastagFull($r);
        }
        elseif($type =='uploadImageUtama'){
            return self::uploadImageUtama($r);
        }
        elseif($type =='AllBerita'){
            return self::AllBerita($r);
        }
        elseif($type =='insert'){
            return self::insert($r);
        }
        elseif($type =='beritaByDate'){
            return self::beritaByDate($r);
        }
        elseif($type =='beritaByDateRange'){
            return self::beritaByDateRange($r);
        }
        elseif($type =='GetBeritaById'){
            return self::GetBeritaById($r);
        }
        
    }

    function HastagFull(){
        $tag = mdBerita::where('tag','!=','')->pluck('tag')->all();

        $array = array();
        foreach($tag as $key =>$value){
            $ex = explode(',',$value);
            $array = array_merge($array, $ex);
        }
        return array_slice(array_unique($array), 0,600); 
    }   
    function imageUploaded(Request $request){
        $link = "http://localhost/paneladminInilahkepri/public/01.jpg";
         // Generate response.
    
        return stripslashes(response()->json(['link' => $link])->content());
    }

    function uploadImageUtama(Request $r){
        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");
        $folderDay = date("Ymd");

        $form = $r->get("form");
    
        $pos = strpos($form['gambar'], ';');
      
        $filetype = explode('/', substr($form['gambar'], 0, $pos))[1];
        Storage::makeDirectory("artikel/".$folderDay);
       
        $expoloded = explode(",",$form['gambar']);
        $decoded = base64_decode($expoloded[1]);
       
        $extension =  $filetype;
        $name = Str::slug($form["judul"], '_');
        $filename = $name.'.'.$extension;
        $path = storage_path('app/artikel/'.$folderDay).'/'.$filename;
        file_put_contents($path, $decoded);
        return $filename;
    }

    function GetBeritaById(Request $r){
        return mdBerita::where('id_berita', $r->get('id'))->get();
    }

    function AllBerita(Request $r){
        return mdBerita::where("judul",'!=','')->get();
    }

    function beritaByDate(Request $r){
        $date = date("Y-m-d", strtotime($r->get('date')));
        return mdBerita::where("tgl_publish",$date)->get();
        
    }
    function beritaByDateRange(Request $r){
        $start = date("Y-m-d", strtotime($r->get('date')[0]));
        $end = date("Y-m-d", strtotime($r->get('date')[1]));
        return mdBerita::whereBetween("tgl_publish",[$start, $end])->get();
        
    }
    
    /*-----====== CRUD =====------*/
    
    function insert(Request $r){
        $data = $r->get('form');
                
        date_default_timezone_set("Asia/Bangkok");
        $today = date("Y-m-d");
        $tglPublish = date("Y-m-d", strtotime($data['tgl_publish']));
        $jam = date("H:i");
        $gambar = self::uploadImageUtama($r);
        $tag = implode(',',$data['tag']);

        $toDataBase = array(
        "id_kategori" => $data['id_kategori'],
        "id_subkategori" => $data['id_subkategori'],
        "judul" => $data['judul'],
        "isi_berita" => $data['isi_berita'],
        "tgl_posting" => $today,
        "tgl_publish" => $tglPublish,
        "jam" => $jam,
        "gambar" => $gambar,
        "ket_gambar" => $data['ket_gambar'],
        "tag" => $tag,
        "headline" => $data['headline'],
        "publish" => $data['publish'],
        );
        
//        return $toDataBase;
        mdBerita::insert($toDataBase);

        return "berhasil";

    }

}
