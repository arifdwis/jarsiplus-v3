<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MapsKecamatan extends Model
{
	protected $connection = 'mysql_iks';
    use HasFactory;
	protected $table = 'mapskecamatans';
    protected $fillable = ['uuid','kota_id','kecamatan_id','nama','location','area','properties','option','judul','deskripsi','publish','user_id'];

    public function kelurahans(){
        return $this->hasMany('Modules\Template\Entities\MonoKelurahan','kecamatan_id','kecamatan_id');
    }

    public function kecamatan(){
        return $this->belongsTo('Modules\Template\Entities\MonoKecamatan','kecamatan_id','kecamatan_id');
    }
}
