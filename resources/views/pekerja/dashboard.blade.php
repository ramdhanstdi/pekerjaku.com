@extends('tamplate.pekerja')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h3>Selamat Datang</h1>
        <div class="d-flex justify-content-center mt-3 p-2 ">
          <a href="{{ url('/') }}" class="btn btn-secondary">Kembali Ke Halaman Utama</a>
        </div>
      </div>
    </section>
@endsection