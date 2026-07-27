<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonoKelurahan extends Model
{
	protected $connection = 'mysql_iks';
    use HasFactory;
	protected $table = 'monokelurahans';
    protected $fillable = ['uuid','nama', 'kecamatan_id', 'kelurahan_id', 'website','telepon','fax','email','alamat','longitude','latitude','lurah','foto_lurah','cover'];
}
