<?php

namespace Modules\Wilayah\Entities;

use Illuminate\Database\Eloquent\Model;
use nue;

class Provinsi extends Model 
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_provinces';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

    public function citys(){
        return $this->hasMany('Modules\Wilayah\Entities\Kota','province_id');
    }
}