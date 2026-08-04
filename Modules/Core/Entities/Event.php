<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'uuid',
        'id_operator',
        'title',
        'subtitle',
        'banner',
        'file_edaran',
        'file_panduan',
        'url_daftar',
        'description',
        'status',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = uuid();
            }
        });
    }

    public function operator()
    {
        return $this->belongsTo(\App\Models\User::class, 'id_operator');
    }
}
