<?php

namespace Modules\Formulir\Entities\Beimbai;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class Indikator extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_beimbai_indikator';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'label',
        'deskripsi',
        'informasi_data_dukung',
        'slug',
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

    public function parameter(){
        return $this->hasMany('Modules\Formulir\Entities\Beimbai\Parameter','indikator_id');
    }

    public function inovasi(){
        return $this->belongsTo('Modules\Formulir\Entites\Permohonan','id_inovasi');
    }

    public function datadukung(){
        return $this->hasMany('Modules\Formulir\Entities\DataDukung','id_indikator');
    }

    public function indikators(){
        return $this->belongsTo('Modules\Formulir\Entities\Penilaian','indikator_id');
    }
}