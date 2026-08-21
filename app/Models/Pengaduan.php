<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pengaduan extends Model { protected $fillable = ['nama','email','telepon','kategori','judul','isi','lampiran','status']; }
