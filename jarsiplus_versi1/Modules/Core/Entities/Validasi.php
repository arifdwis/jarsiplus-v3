<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use nue;
use Ramsey\Uuid\Uuid;

class Validasi extends Model 
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permohonan_histori_pembahasan_validasi';
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
    	'status',
    	'uuid'
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


    public function file(){
        return $this->belongsTo('Modules\Core\Entities\File','id_file');
    }

    public function operator() 
    {
        return $this->belongsTo('App\Models\User', 'id_operator');
    }

    public function validate() 
    {
        return $this->belongsTo('Modules\Core\Entities\File', 'id_file');
    }

}