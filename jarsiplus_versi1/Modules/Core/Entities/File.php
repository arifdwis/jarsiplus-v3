<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use nue;
use Ramsey\Uuid\Uuid;

class File extends Model 
{
    use Sluggable;
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_file';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 
        'id_permohonan', 
        'label',
        'file',
        'deskripsi',
        'slug',
        'status'
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

    public function users()
    {
        return $this->hasMany('App\Models\User','id_operator');
    }

    public function dfile() 
    {
        return $this->hasMany('Modules\Core\Entities\Validasi', 'id_file');
    }
}