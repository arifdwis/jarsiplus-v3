<?php

namespace Modules\Pemohon\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use nue;
use Ramsey\Uuid\Uuid;

class Corporate extends Model 
{
    use Sluggable;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pemohon_corporate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'uuid',
    	'id_operator',
    	'name',
    	'kota',
    	'kota_id',
    	'address',
    	'postal_code',
    	'slug',
    	'email',
    	'phone',
    	'website',
    	'status',	
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
        return $this->hasMany('Modules\Pemohon\Entities\Pemohon','id_pemohon_0');
    }

    public function pemohon2(){
        return $this->hasMany('Modules\Pemohon\Entities\Pemohon','id_pemohon_1');
    }

}