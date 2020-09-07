<?php

namespace App\Http\Controllers;

use App\model\mdPermohonanPersyaratan;
use App\model\mdTrack;
use Illuminate\Http\Request;

class trackControl extends Controller
{
    function index(Request $r)
    {
        $type = $r->get("type");
        if ($type == 'trackById') {
            return self::trackById($r);
        }
    }

    function trackById(Request $r)
    {
        $permohonan_id = $r->get("permohonan_id");
        $track = mdTrack::with('user')->where("permohonan_id", $permohonan_id)->get();
        $permohonan_persyaratan = mdPermohonanPersyaratan::where("permohonan_id", $permohonan_id)->where('status', 'tolak')->get();
        return array("track" => $track, "persyaratan" => $permohonan_persyaratan);
    }
}
