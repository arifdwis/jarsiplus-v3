<?php

namespace Modules\Formulir\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class Arsip extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_2024';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'id_pemohon_0',
        'id_pemohon_1',
        'id_provinsi',
        'id_kota',
        'id_kategori',
        'urusan_utama',
        'urusan_lainnya',
        'kode',
        'slug',
        'label',
        'tahapan',
        'tematik',
        'inisiator',
        'jenis',
        'file_final',
        'waktu_uji_coba',
        'waktu_pelaksanaan',
        'rancang_bangun',
        'tujuan_inovasi',
        'manfaat_inovasi',
        'hasil_inovasi',
        'anggaran',
        'profil_bisnis',
        'status',
        'alasan_tolak',
        'nilai_akhir'          
    ];

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Uuid::uuid1();
        });
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'label'
            ]
        ];
    }

    /**
     * Scope a query for UUID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid) 
    {
        return $query->whereUuid($uuid);
    }

    /**
     * Scope a query for SLUG.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $slug
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSlug($query, $slug) 
    {
        return $query->whereSlug($slug);
    }

    public function pemohon1(){
        return $this->belongsTo('Modules\Pemohon\Entities\Pemohon','id_pemohon_0','id_operator');
    }

    public function pemohon2(){
        return $this->belongsTo('Modules\Pemohon\Entities\Pemohon','id_pemohon_1','id');
    }

    public function provinsi(){
        return $this->belongsTo('Modules\Wilayah\Entities\Provinsi','id_provinsi');
    }

    public function kota(){
        return $this->belongsTo('Modules\Wilayah\Entities\Kota','id_kota');
    }

    public function kategori(){
        return $this->belongsTo('Modules\Formulir\Entities\Kategori','id_kategori');
    }
    
    public function historis(){
        return $this->hasMany('Modules\Formulir\Entities\Permohonan','id_permohonan');
    }

    public function histori(){
        return $this->hasMany('Modules\Core\Entities\Penjadwalan','id_histori');
    }

    public function permohonan() 
    {
        return $this->hasMany('Modules\Core\Entities\File', 'id_permohonan');
    }

    public function riwayat() 
    {
        return $this->hasMany('Modules\Core\Entities\Histori', 'id_permohonan');
    }

    public function permohonans() 
    {
        return $this->hasOne('Modules\Core\Entities\File', 'id_permohonan');
    }

    public function penjadwalan() 
    {
        return $this->hasMany('Modules\Core\Entities\Penjadwalan', 'id_permohonan');
    }

    public function inovasi(){
        return $this->hasMany('Modules\Formulir\Entities\Indikator','id_inovasi');
    }

    public function inovasis(){
        return $this->hasMany('Modules\Formulir\Entities\Penilaian','inovasi_id');
    }
}