@extends('template::layouts.master')

@section('css')
<style type="text/css">
    .appHeader.scrolled.bg-primary
    {
        background: #333 !important;
    }
    .svg-header
    {
        background: #333 !important;
    }
</style>
@endsection

@section('content')

<section class="page-header" style="background:#333 !important;">    
    <div class="header-light text-center pb-2">
        <h1 class="title">Single sign-on</h1>
        <h4 class="subtitle px-4 mb-4">Untuk melanjutkan ketahap selanjutnya didalam aplikasi kami anda diharuskan memiliki akun SSO terlebih dahulu, jika anda belum memiliki akun anda dapat registrasi terlebih dahulu.</h4>
        <div class="btn-group">
            <button onclick="redirectSSO()" class="btn btn-primary">
              <ion-icon name="finger-print-outline"></ion-icon> Registrasi SSO
          </button>

          <script>
            function redirectSSO() {
              alert('Anda akan dialihkan ke halaman registrasi SSO...');
              setTimeout(() => {
                window.open('https://sso.samarindakota.go.id', '_blank');
            }, 1000);
          }
      </script>

      <a href="{{ route('sso.authorize') }}" class="btn btn-secondary"><ion-icon name="finger-print-outline"></ion-icon> Login SSO</a>
  </div>
  
</div>
</section>
<svg width="100%" height="40px" viewBox="0 0 100 100" version="1.1" preserveAspectRatio="none" class="svg-header">
    <path d="M0,0 C16.6666667,66 33.3333333,99 50,99 C66.6666667,99 83.3333333,66 100,0 L100,100 L0,100 L0,0 Z" fill="#f9f9f9"></path>
</svg>

<div class="section pt-4 pb-5">
    <div class="mb-3 text-center" >
        <img src="https://sso.samarindakota.go.id/img/logo.png" style="width: 200px;"/>
    </div>
    <div class="mx-lg-auto">
        <h3>Tentang SSO</h3>
        <p style="text-align: justify;">
            Teknologi Single-sign-on (sering disingkat menjadi SSO) adalah teknologi yang mengizinkan pengguna jaringan agar dapat mengakses aplikasi dalam jaringan hanya dengan menggunakan satu akun pengguna saja. Teknologi ini sangat
            diminati, khususnya dalam jaringan yang sangat besar dan bersifat heterogen (di saat sistem operasi serta aplikasi yang digunakan oleh komputer adalah berasal dari banyak vendor, dan pengguna dimintai untuk mengisi informasi
            dirinya ke dalam setiap platform yang berbeda tersebut yang hendak diakses oleh pengguna). Dengan menggunakan SSO, seorang pengguna hanya cukup melakukan proses autentikasi sekali saja untuk mendapatkan izin akses terhadap semua
            layanan yang terdapat di dalam jaringan.
        </p>
    </div>
    <img src="https://sso.samarindakota.go.id/img/flow.jpg" class="img-fluid imaged mb-3" />
    <div class="mx-lg-auto">
        <h3>Cara Kerja SSO</h3>
        <p>
            Bagaimana cara kerja SSO? Autentikasi dengan SSO bergantung pada hubungan kepercayaan antar domain (situs web). Dengan sistem masuk tunggal, berikut ini yang terjadi saat Anda mencoba masuk ke aplikasi atau situs web:
        </p>
        <ul>
            <li>Situs web tersebut pertama kali memeriksa untuk melihat apakah Anda sudah diautentikasi oleh SSO.</li>
            <li>Jika belum, Anda akan diarahkan ke login SSO untuk masuk.</li>
            <li>Anda memasukkan satu nama pengguna / sandi yang Anda gunakan untuk akses.</li>
            <li>SSO meminta otentikasi dari penyedia identitas atau sistem otentikasi yang digunakan.</li>
            <li>SSO meneruskan data otentikasi ke situs web dan mengembalikan Anda ke situs itu.</li>
            <li>Di SSO, data verifikasi otentikasi berbentuk token.</li>
        </ul>
        <h3 class="mt-7">Contoh SSO</h3>
        <p>
            Contoh SSO yang paling sering digunakan saat ini adalah google. Bagaimana seseorang yang login ke Gmail, secara otomatis juga login ke youtube dan aplikasi-aplikasi google lainnya. Begitu juga sebaliknya, saat sebuah aplikasi
            google di logout, maka mengakibatkan aplikasi lainnya juga ikut terlogout.
        </p>
        <p>Selain google, twitter, facebook dan banyak teknologi lainnya sudah menerapkan SSO.</p>
        <h3 class="mt-7">SSO Pemerintah Samarinda</h3>
        <p>
            Seperti halnya SSO google, Pemerintah Samarinda juga mengembangkan sistem Sigle Sign On dengan menggunakan akun berupa NIK dan email yang sudah terdaftar. Akun ini berada di server khusus terpisah dengan server-server lainnya
            untuk menjaganya dari aktifitas luar.
        </p>
    </div>
</div>



@endsection


@section('js')
@endsection