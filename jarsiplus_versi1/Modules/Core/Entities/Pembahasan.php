<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use nue;
use Ramsey\Uuid\Uuid;

class Pembahasan extends Model 
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_histori_pembahasan';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id_permohonan',
    	'id_operator',
    	'id_file',
    	'id_histori',
    	'uuid',
    	'komentar',
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
     * Scope a query for UUID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query, $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUuid($query, $uuid) 
    {
        return $query->whereUuid($uuid);
    }

    public function permohonans(){
        return $this->belongsTo('Modules\Formulir\Entities\Permohonan','id_permohonan');
    }


    public function histori(){
        return $this->hasOne('Modules\Core\Entities\Histori','id_file')->orderBy('created_at','desc');
    }

    public function historis(){
        return $this->hasMany('Modules\Core\Entities\Histori','id_file');
    }

    public function operator() 
    {
        return $this->belongsTo('App\Models\User', 'id_operator');
    }

}