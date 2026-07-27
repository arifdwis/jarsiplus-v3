<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MapsKelurahan extends Model
{
	protected $connection = 'mysql_iks';
    use HasFactory;
	protected $table = 'mapskelurahans';
    protected $fillable = ['id','uuid','kecamatan_id','kelurahan_id','nama','location','area','properties','option','judul','deskripsi','publish','user_id'];

    public function kelurahan(){
        return $this->belongsTo('Modules\Template\Entities\MonoKelurahan','kelurahan_id','kelurahan_id');
    }

    public function kecamatan(){
        return $this->belongsTo('Modules\Template\Entities\MonoKecamatan','kecamatan_id','kecamatan_id');
    }
}
