<?php

namespace Modules\Formulir\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class DataDukung extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_file';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_permohonan',
        'inovasi_penilaian_id',
        'uuid',
        'label',
        'url',
        'file',
        'slug',
        'deskripsi',
        'nomor_surat',
        'jenis',
        'created_at',
        'updated_at',
        'deleted_at'       
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

    public function histori(){
        return $this->hasOne('Modules\Core\Entities\Histori','id_file')->orderBy('created_at','desc');
    }

    public function historis(){
        return $this->hasMany('Modules\Core\Entities\Histori','id_file');
    }

    public function file_one(){
        return $this->hasMany('Modules\Core\Entities\Pembahasan','id_file');
    }

    public function validasi(){
        return $this->hasOne('Modules\Core\Entities\Validasi','id_file')->where('id_operator',me()->id);
    }

    public function permohonan(){
        return $this->belongsTo('Modules\Formulir\Entities\Permohonan','id_permohonan');
    }

    public function arsip(){
        return $this->belongsTo('Modules\Formulir\Entities\Arsip','id_permohonan');
    }

    public function beimbai(){
        return $this->belongsTo('Modules\Formulir\Entities\Beimbai\Permohonan','id_permohonan');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User','id_operator');
    }

    public function files(){
        return $this->belongsTo('Modules\Formulir\Entities\Penilaian','inovasi_penilaian_id');
    }

        public function dfile() 
    {
        return $this->hasMany('Modules\Core\Entities\Validasi', 'id_file');
    }
}