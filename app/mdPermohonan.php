<?php

namespace App;

use App\model\mdOpd;
use App\model\mdopdIzin;
use App\model\mdPermohonanPersyaratan;
use App\model\mdperusahaan;
use App\model\mdperusahaanPemohon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class mdPermohonan extends Model
{
    protected $table        = "permohonan";
    protected $primaryKey   = "permohonan_id";

    protected $casts = [
        'created_at'  => 'date:d/m/Y',
    ];

    protected $appends = [
        'jam'
    ];

    function getjamAttribute() {
        return date("h:i", strtotime($this->created_at));
    }

    function opd(){
        return $this->belongsTo(mdOpd::class,'opd_id');
    }
    function persyaratan(){
        return $this->hasMany(mdPermohonanPersyaratan::class,'permohonan_id');
    }
    function izin(){
        return $this->belongsTo(mdopdIzin::class,'opdi_id');
    }
    function perusahaan(){
        return $this->belongsTo(mdperusahaan::class,'perusahaan_id');
    }
    function pemohon(){
        return $this->belongsTo(mdperusahaanPemohon::class,'perusahaanp_id');
    }

}
