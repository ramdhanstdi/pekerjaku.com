@extends('tamplate.majikan')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h2 class="my-2">Dashboard</h2>
        <div class="container">
          <div class="row gap-3">
            <a href="{{ url('majikan/data-diri') }}" class="col-sm m-1 card bg-light p-3">
              <h5>Data Diri</h5>
              <p>Halaman Untuk info data diri</p>
            </a>
            <a href="{{ url('majikan/data-pekerja') }}" class="col-sm m-1 card bg-light p-3">
              <h5>Pekerja</h5>
              <p>Halaman untuk memeriksa pekerja</p>
            </a>
            <a href="{{ url('majikan/data-order') }}" class="col-sm m-1 card bg-light p-3">
              <h5>
                Data Order
              </h5>
              <p>
                Halaman untuk riwayat order
              </p>
            </a>
          </div>
          <div class="d-flex justify-content-center mt-3 p-2 ">
            <a href="{{ url('/') }}" class="btn btn-secondary" >Kembali Ke Halaman Utama</a>
          </div>
        </div>
      </div>
    </section>
@endsection