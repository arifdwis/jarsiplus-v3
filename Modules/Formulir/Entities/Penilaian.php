<?php

namespace Modules\Formulir\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class Penilaian extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_penilaian';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'inovasi_id',
        'indikator_id',
        'label_indikator',
        'parameter_id',
        'label_parameter',
        'bobot'
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

    public function indikators(){
        return $this->belongsTo('Modules\Formulir\Entities\Indikator','indikator_id');
    }

    public function parameters(){
        return $this->belongsTo('Modules\Formulir\Entities\Parameter','parameter_id');
    }

    public function inovasis(){
        return $this->belongsTo('Modules\Formulir\Entities\Permohonan','inovasi_id');
    }

    public function files(){
        return $this->hasMany('Modules\Formulir\Entities\DataDukung','inovasi_penilaian_id');
    }
}