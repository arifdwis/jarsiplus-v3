<?php

/* Author : Noviyanto Rahmadi 
 * E-mail : novay@btekno.id
 * Copyright 2020 Borneo Teknomedia. */
use Modules\Litbang\Entities\Perguruan;
if(!function_exists('title')) {
    function title() {
        return env('EP_INSTANSI') . ' ' . str_replace('Pemerintah ', '', env('EP_PEMERINTAH'));
    }
}

/**
 * Simpan Konfigurasi di file .env
 * @return String
 */
if(!function_exists('writeConfig')) {
     function writeConfig($key, $int) {
        $lines = parseEnv(base_path('.env'));
        $data = [prefixKey($key) => "'".$int."'",];

        $lines = array_merge($lines, $data);
        $fp = @fopen(base_path('.env'), 'w+');
        if(!$fp)
            throw new Exception('Error');
        foreach($lines as $key => $data):
            if(is_int($key)):
                fwrite($fp, implode('',["\n"]));
            else:
                fwrite($fp, implode('',[$key,'=',$data,"\n"]));
            endif;
        endforeach;
        fclose($fp);
        return true;
    }

    function parseEnv($path) {
        if(!file_exists($path) || !is_file($path))
            return [];
        $lines = array_map('trim', file($path));
        $result = [];
        foreach($lines as $row => $line):
            $parts = explode('=', $line, 2);
            $result[$parts[0] ? : $row] = isset($parts[1]) ? $parts[1] : '';
        endforeach;
        return $result;
    }

    function prefixKey($key) {
        return implode('_', ['EP', $key]);
    }
}

if(!function_exists('uuid')) {
    function uuid() {
        return \Ramsey\Uuid\Uuid::uuid1();
    }
}

if(!function_exists('viewImg')) {
    function viewImg($img, $type = null) {
        $type = $type !== null ? "_$type." : ".";
        if($img == 'default.jpg'):
            return 'data:image/jpeg;base64,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';
        endif;
        if($img == null):
            return 'data:image/jpeg;base64,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';
        endif;
        $explode = explode(".", $img);
        $ekstensi = $explode[1];
        $file = $explode[0];

        return asset($file . $type . $ekstensi);
    }
}

if(!function_exists('deleteImg')) {
    function deleteImg($img) {
        if(!is_null($img)):
            $ekstensi = pathinfo($img, PATHINFO_EXTENSION);
            $custom = str_replace(".$ekstensi", '', $img);
            
            if(\Storage::disk()->exists(str_replace('storage/', 'public/', $custom . '_m.' .$ekstensi))):
                \Storage::disk()->delete(str_replace('storage/', 'public/', $custom . '_m.' .$ekstensi));
            endif;
            
            if(\Storage::disk()->exists(str_replace('storage/', 'public/', $custom . '_s.' .$ekstensi))):
                \Storage::disk()->delete(str_replace('storage/', 'public/', $custom . '_s.' .$ekstensi));
            endif;
            
            \Storage::disk()->delete(str_replace('storage/', 'public/', $custom . '.' .$ekstensi));
        endif;
    }
}

if(!function_exists('deleteFile')) {
    function deleteFile($file) {
        if(!is_null($file)):
            \Storage::disk()->delete(str_replace('storage/', 'public/', $file));
        endif;
    }
}

if(!function_exists('checkFile')) {
    function checkFile($file) {
        if(!is_null($file)):
            \Storage::disk()->exists(str_replace('storage/', 'public/', $file));
        endif;
    }
}

/**
 * Make an image directory function
 * @param  $path: nama folder yang ingin dibuat
 * @return mixed
 */
if(!function_exists('makeImgDirectory')) {
    function makeImgDirectory($path) {
        # pastikan file atay folder yang dimaksud tidak ada
	    if (!file_exists(storage_path() .'/'. $path )):
	        # bila benar, buat direktori yang dimaksud dengan permission 0777
	        $oldmask = umask(0);
	        mkdir(storage_path() .'/'. $path , 0777, true);
	        umask($oldmask);
	    endif;
	    return;
    }
}

if(!function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2) {
        $units = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        
        return round($size, $precision).$units[$i];
    }
}

if(!function_exists('postUrl')) {
    function postUrl($temp) {
        return route('frontend.berita.detail', [optional($temp->kategori)->slug, $temp->slug]);
    }
}

/**
 * Tanggal Dalam Bahasa Indonesia
 * @return String
 */
if (!function_exists('tgl_indo')) {
    function tgl_indo($tanggal) {
        $fix = date('Y-m-d H:i:s', strtotime($tanggal));
        $bulan = array (
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode(' ', $fix);
        $tanggal = $split[0];
        $waktu = $split[1];
        $split_tanggal = explode('-', $tanggal);
        $split_waktu = explode(':', $waktu);

        $jam = $split_waktu[0];
        $menit = $split_waktu[1];
        $detik = $split_waktu[2];

        $ampm = $jam >= 12 ? 'PM' : 'AM';
        $jam12 = $jam % 12;
        $jam = ($jam12 == 0) ? 12 : $jam12;

        return $split_tanggal[2] . ' ' . $bulan[(int)$split_tanggal[1]] . ' ' . $split_tanggal[0] . ' ' . $jam . ':' . $menit . ':' . $detik . ' ' . $ampm;
    }
}

if (!function_exists('waktu_chat')) {
    function waktu_chat($tanggal) {
        $fix = date('Y-m-d H:i:s', strtotime($tanggal));
        $split = explode(' ', $fix);
        $waktu = $split[1];
        $split_waktu = explode(':', $waktu);

        $jam = $split_waktu[0];
        $menit = $split_waktu[1];
        $detik = $split_waktu[2];

        $ampm = $jam >= 12 ? 'PM' : 'AM';
        $jam12 = $jam % 12;
        $jam = ($jam12 == 0) ? 12 : $jam12;

        return $jam . ':' . $menit . ':' . $detik . ' ' . $ampm;
    }
}



if(!function_exists('template')) {
    function template($temp) {
        return 'https://samarindakota.go.id/template/'.$temp;
    }
}

if (!function_exists('pendaftaran_inovasi_deadline')) {
    function pendaftaran_inovasi_deadline()
    {
        $deadline = env('PENDAFTARAN_INOVASI_TUTUP', '2026-06-07 23:59:59');

        return \Carbon\Carbon::parse($deadline, 'Asia/Makassar');
    }
}

if (!function_exists('pendaftaran_inovasi_ditutup')) {
    function pendaftaran_inovasi_ditutup()
    {
        return false;
    }
}

if (!function_exists('pendaftaran_permohonan_ditutup')) {
    function pendaftaran_permohonan_ditutup()
    {
        return false;
    }
}

if (!function_exists('pendaftaran_inovasi_pesan_tutup')) {
    function pendaftaran_inovasi_pesan_tutup()
    {
        return 'Pendaftaran inovasi dan penambahan indikator telah ditutup pada ' .
            pendaftaran_inovasi_deadline()->format('d-m-Y H:i') . ' WITA.';
    }
}

