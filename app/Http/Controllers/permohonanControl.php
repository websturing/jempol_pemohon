<?php

namespace App\Http\Controllers;

use App\mdPermohonan;
use App\model\mdPermohonanPersyaratan;
use App\Http\Controllers\perusahaanControl;
use App\Http\Controllers\perusahaanPemohonControl;
use App\model\mdTrack;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class permohonanControl extends Controller
{
    function index(Request $r)
    {
        $type = $r->get("type");
        if ($type == 'dataByDate') {
            return self::dataByDate($r);
        } else if ($type == 'dataById') {
            return self::dataById($r);
        } else if ($type == 'insert') {
            return self::insertPermohonan($r);
        } else if ($type == 'uploadSingle') {
            return self::uploadSingle($r);
        } else if ($type == 'dataByRange') {
            return self::dataByRange($r);
        } else if ($type == 'prosesPemohonanData') {
            return self::prosesPemohonanData($r);
        } else if ($type == 'permohnanTertunda') {
            return self::permohnanTertunda($r);
        } else if ($type == 'kirimtoptsp') {
            return self::kirimtoptsp($r);
        } else if ($type == 'permohonanTrack') {
            return self::permohonanTrack($r);
        }
    }

    /*----------------------=== GET DATA BY ===-----------------------*/

    function dataByDate(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->get('date')));;

        $dataByDate = mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->where('status', 'pending')
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $dataByDate;
    }

    function prosesPemohonanData(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->get('date')));;

        $dataByDate = mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->where('status', 'proses')
            ->where('perusahaan_id', session::get("perusahaan_id"))
            ->get();

        return $dataByDate;
    }

    function permohonanTrack(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->get('date')));;

        $dataByDate = mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->where('perusahaan_id', session::get("perusahaan_id"))
            ->get();

        return $dataByDate;
    }

    function permohnanTertunda(Request $r)
    {
        $date = date("Y-m-d", strtotime($r->get('date')));;

        $dataByDate = mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->where('status', 'pending')
            ->where('perusahaan_id', session::get("perusahaan_id"))
            ->get();

        return $dataByDate;
    }

    function dataByRange(Request $r)
    {
        $start = date("Y-m-d", strtotime($r->get('date')[0]));
        $end = date("Y-m-d", strtotime($r->get('date')[1]));
        return mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->whereBetween("created_at", [$start, $end])
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    function dataById(Request $r)
    {
        $id = $r->get('id');

        $dataById = mdPermohonan::with(['izin', 'perusahaan', 'opd', 'persyaratan'])
            ->where('permohonan_id', $id)
            ->get();

        return $dataById;
    }

    function uploadSingle(Request $r)
    {
        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $persyaratan = $r->get("persyaratan");
        $permohonanCode = $r->get("permohonanCode");
        Storage::makeDirectory("permohonan/" . $permohonanCode);
        Storage::makeDirectory("permohonan/" . $permohonanCode . '/persyaratan');

        $expoloded = explode(",", $persyaratan["file"]);
        $decoded = base64_decode($expoloded[1]);
        $extension =  "pdf";
        $name = Str::slug($persyaratan["persyaratan"], '_');
        $filename = $name . '.' . $extension;
        $path = storage_path('app/permohonan/' . $permohonanCode . '/persyaratan') . '/' . $filename;
        file_put_contents($path, $decoded);

        $arPers = array(
            "status" => "uploaded",
            "file" => $filename,
            "updated_at" => $timestamp,
            "user_uploaded_file" => Session::get("user_id"),
        );


        mdPermohonanPersyaratan::where("permohonan_persyaratanId", $persyaratan["permohonan_persyaratanId"])
            ->update($arPers);
        // $todbpermohonan = array("status" => "proses");
        // mdPermohonan::where("permohonan_id", $r->get("permohonan_id"))->update($todbpermohonan);

        // $totrack = array(
        //     "permohonan_id" => $r->get("permohonan_id"),
        //     "perusahaan_id" => Session::get("perusahaan_id"),
        //     "pesan" => "upload File Persyaratan " . $filename
        // );
        // mdTrack::insert($totrack);

        return array("file" => $filename, "status" => "uploaded");
    }
    function UploadSuratTelaah(Request $r)
    {
        date_default_timezone_set("Asia/Bangkok");
        $timestamp = date("Y-m-d H:i:s");

        $persyaratan = $r->get("persyaratan");
        $permohonanCode = $r->get("permohonanCode");
        Storage::makeDirectory("permohonan/" . $permohonanCode);
        Storage::makeDirectory("permohonan/" . $permohonanCode . '/rekomendasi');

        $expoloded = explode(",", $persyaratan["file"]);
        $decoded = base64_decode($expoloded[1]);
        $extension =  "jpg";
        $name = Str::slug($persyaratan["nomor"], '_');
        $filename = $name . '.' . $extension;
        $path = storage_path('app/permohonan/' . $permohonanCode . '/rekomendasi') . '/' . $filename;
        file_put_contents($path, $decoded);

        // $arPers = array(
        //     "file" => $filename,
        //     "updated_at" => $timestamp,
        //     "user_uploaded_file" => Session::get("user_id"),
        // );
        // mdPermohonanPersyaratan::where("permohonan_persyaratanId", $persyaratan["permohonan_persyaratanId"])
        //     ->update($arPers);

        return $filename;
    }

    /*----------------------=== CRUD ===-----------------------*/

    function insertPermohonan(Request $r)
    {
        $data = $r->get("form");

        $perusahaan_id = Session::get('perusahaan_id');

        $data['pemohon']['perusahaan_id'] =  $perusahaan_id;

        $perusahaan_pemohon = new Request();

        $perusahaan_pemohon->replace(['pemohon' => $data['pemohon']]);

        $perusahaan_pemohon_id = perusahaanPemohonControl::perusahaanpemohonInsert($perusahaan_pemohon);



        $code = 'PRMN';
        $pegawaiCode = DB::table('permohonan')->where('permohonan_code', 'like', '%' . $code . '%')->max('permohonan_code');
        $idmax1 = $pegawaiCode;
        $nourut1 = (int) substr($idmax1, 4, 5);
        $nourut1++;
        $permohonan_code = $code . sprintf("%05s", $nourut1);

        $toDBpermohonan = array(
            "permohonan_code"   => $permohonan_code,
            "perusahaan_id"     => $perusahaan_id,
            "perusahaanp_id"    => $perusahaan_pemohon_id,
            "opd_id"            => $data["izin"]["opd_id"],
            "opdi_id"           => $data["izin"]["opdi_id"],
            "status"            => "pending",
            "create_on"         => "online"
        );
        mdPermohonan::insert($toDBpermohonan);
        $permohonanId = DB::getPdo()->lastInsertId();

        foreach ($data["persyaratan"] as $index => $p) {
            $toDbPersyaratan = array(
                "permohonan_id" => $permohonanId,
                "persyaratan" => $p["persyaratan"],
                "status" => "waiting-upload",
                "catatan" => $p["catatan"]
            );
            mdPermohonanPersyaratan::insert($toDbPersyaratan);
        }

        $totrack = array(
            "permohonan_id" => $permohonanId,
            "perusahaan_id" => Session::get("perusahaan_id"),
            "pesan" => "Pengisian Form Perizinan",
            "step" => "1",
            "user_id" => Session::get("user_id"),
        );
        mdTrack::insert($totrack);



        return array(
            "title"     => "Info",
            "type"      => "success",
            "message"   => "Data Berhasil Di Simpan",
            "code"      => "200",
            "dataId"        => $permohonanId
        );
    }

    function kirimtoptsp(Request $r)
    {

        $date = \Carbon\Carbon::now();
        $todbpermohonan = array("status" => "proses", "created_at" => $date);
        mdPermohonan::where("permohonan_id", $r->get("permohonan_id"))->update($todbpermohonan);

        $totrack = array(
            "permohonan_id" => $r->get("permohonan_id"),
            "perusahaan_id" => Session::get("perusahaan_id"),
            "pesan" => "Pengajuan Permohonan online",
            "step" => "2",
            "user_id" => Session::get("user_id")
        );
        mdTrack::insert($totrack);
    }
}
