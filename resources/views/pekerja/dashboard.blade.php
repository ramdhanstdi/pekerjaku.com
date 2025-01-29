@extends('tamplate.pekerja')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h2 class="my-2">Selamat Datang</h2>
        <div class="container">
          <div class="row gap-3">
            <a href="{{ url('pekerja/data-diri') }}" class="col-sm m-1 card bg-light p-3">
              <h5>Data Diri</h5>
              <p>Halaman Untuk info data diri agar terdaftar menjadi pekerja</p>
            </a>
            <a href="{{ url('pekerja/data-order') }}" class="col-sm m-1 card bg-light p-3">
              <h5>Lowongan</h5>
              <p>Halaman untuk melihat daftar lowongan yang tersedia</p>
            </a>
          </div>
        </div>
        <div class="d-flex justify-content-center mt-3 p-2 ">
          <a href="{{ url('/') }}" class="btn btn-secondary">Kembali Ke Halaman Utama</a>
        </div>
      </div>
    </section>
@endsection