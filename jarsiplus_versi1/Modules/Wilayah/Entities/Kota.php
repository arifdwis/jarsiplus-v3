<?php

namespace Modules\Wilayah\Entities;

use Illuminate\Database\Eloquent\Model;
use nue;

class Kota extends Model 
{
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'city_id', 
        'province_id', 
        'name'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */

    public function provinsi(){
        return $this->belongsTo('Modules\Wilayah\Entities\Provinsi','province_id');
    }
}