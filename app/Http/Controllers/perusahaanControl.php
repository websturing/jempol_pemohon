<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\model\mdPerusahaan;


class perusahaanControl extends Controller
{
    function index(Request $r)
    {
        $type = $r->get("type");
        if ($type == 'perusahaanById') {
            return self::perusahaanById($r);
        }
    }

    function perusahaanById(Request $r)
    {
        $id = $r->get("id");

        // return mdPerusahaan::where("perusahaan_id", Session::get('perusahaan_id'))->get();
        return mdPerusahaan::where("perusahaan_id", '899')->get();
    }
}
