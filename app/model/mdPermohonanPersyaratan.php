<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class mdPermohonanPersyaratan extends Model
{
    protected $table        = "permohonan_persyaratan";
    protected $primaryKey   = "permohonan_persyaratanId";

    protected $appends = [
        'statusUpload'
    ];

    function getstatusUploadAttribute()
    {
        if ($this->file == null) {
            $btnUpload = true;
            $download = false;
            $progress = false;
        } else {
            $btnUpload = false;
            $download = true;
            $progress = true;
        }
        $data = array(
            "upload" => $btnUpload,
            "progress"  => $progress,
            "download"  => $download
        );
        return $data;
    }
}
