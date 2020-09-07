<?php

namespace App\Http\Controllers;

use App\mdUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\model\mdPerusahaan;




class perusahaanControl extends Controller
{
    function index(Request $r)
    {
        $type = $r->get("type");
        if ($type == 'dataAll') {
            return self::dataall($r);
        } elseif ($type == 'dataBynpwp') {
            return self::dataBynpwp($r);
        } elseif ($type == 'UpdateById') {
            return self::UpdateById($r);
        } elseif ($type == 'perusahaanById') {
            return self::perusahaanById($r);
        }
    }

    function perusahaanById(Request $r)
    {
        return mdPerusahaan::where("perusahaan_id", Session::get('perusahaan_id'))->get();
    }
    function dataall(Request $r)
    {
        return mdperusahaan::all();
    }

    function dataBynpwp(Request $r)
    {
        $npwp = $r->get('npwp');
        return mdperusahaan::with(['permohonan' => function ($p) {
            $p->with(['opd', 'persyaratan', 'izin', 'perusahaan']);
        }])
            ->where('npwp', $npwp)->get();
    }

    function UpdateById(Request $r)
    {
        $data = $r->get('data');
        $toDB = array(
            "npwp"      => $data['npwp'],
            "kategori"    => $data['kategori'],
            "nama"      => $data['nama'],
            "alamat"    => $data['alamat'],
            "email"     => $data['email'],
            "contact"   => $data['contact'],
        );

        mdperusahaan::where('perusahaan_id', $data['perusahaan_id'])->update($toDB);

        return array(
            "title"     => "Info",
            "type"      => "success",
            "message"   => "Data Berhasil Di Rubah",
            "code"      => "200"
        );
    }

    public static function Insertperusahaan(Request $r)
    {
        $data = $r->get('perusahaan');
        $toDB = array(
            "npwp"  => $data["npwp"],
            "kategori"  => $data["kategori"],
            "nama"  => $data["nama"],
            "alamat"  => $data["alamat"],
            "email"  => $data["email"],
            "contact"  => $data["contact"],
            "create_on"  => $data['create_on'],
            "aktif"  => $data['aktif'],
        );

        mdperusahaan::insert($toDB);
        $id = DB::getPdo()->lastInsertId();

        return $id;
    }

    public static function konfirmasiViaEmail(Request $r)
    {
        $id = $r->get('q');
        $perusahaan = mdPerusahaan::where("perusahaan_id", $id)->get();


        $ToDBPerusahaan = array(
            "aktif" => true,
        );

        mdPerusahaan::where('perusahaan_id', $id)->update($ToDBPerusahaan);

        $ToDBUsers = array(
            "username" => $perusahaan[0]->email,
            "password" => md5('admin'),
            "perusahaan_id" => $id,
            "is_active" => "true"
        );
        mdUser::insert($ToDBUsers);
        $user_id = DB::getPdo()->lastInsertId();

        Session::put("aclGroupId", "0");
        Session::put("username",  $perusahaan[0]->email);
        Session::put("opd_id", "0");
        Session::put("user_id", $user_id);
        Session::put("perusahaan_id", $perusahaan[0]->perusahaan_id);

        return redirect('/dashboard');
    }
}
