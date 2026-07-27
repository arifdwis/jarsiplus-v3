<?php

namespace Modules\Template\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonoKecamatan extends Model
{
	protected $connection = 'mysql_iks';
    use HasFactory;
	protected $table = 'monokecamatans';
    protected $fillable = ['uuid','nama','provinsi_id','kecamatan_id', 'website','telepon','fax','email','alamat','longitude','latitude','camat','foto_camat','cover'];
}
