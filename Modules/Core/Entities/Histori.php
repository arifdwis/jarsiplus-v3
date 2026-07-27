<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class Histori extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_histori';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'id_permohonan',
        'id_operator',
        'id_file',
        'deskripsi',
        'deskripsi_perbaikan',
        'komentar',
        'slug',
        'file'
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

    public function pembahasans(){
        return $this->hasMany('Modules\Core\Entities\Pembahasan','id_histori');
    }

    public function penjadwalans(){
        return $this->hasMany('Modules\Core\Entities\Penjadwalan','id_histori');
    }

    public function dukungs(){
        return $this->belongsTo('Modules\Core\Entities\File','id_file');
    }

    public function operator() 
    {
        return $this->belongsTo('App\Models\User', 'id_operator');
    }

}