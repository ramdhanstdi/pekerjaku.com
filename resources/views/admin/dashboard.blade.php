@extends('tamplate.admin')

@section('content')
    <section class="dashboard">
        <div class="container">
            <h3>Dashboard</h3>
            <p>Pilih Menu yang akan dipilih</p>
            
            <div class="container">
              <div class="row gap-3">
                <a href="{{ url('admin/order') }}" class="col-sm m-1 card bg-light p-3">
                  <h5>Order</h5>
                  <p>Halaman untuk memeriksa order</p>
                </a>
                <a href="{{ url('admin/lowongan') }}" class="col-sm m-1 card bg-light p-3">
                  <h5>
                    Lowongan
                  </h5>
                  <p>
                    Halaman untuk mengontrol lowongan
                  </p>
                </a>
                <a href="{{ url('admin/pekerja') }}" class="col-sm m-1 card bg-light p-3">
                  <h5>Pekerja</h5>
                  <p>Halaman Untuk mengontrol Pekerja</p>
                </a>
                <a href="{{ url('admin/user') }}" class="col-sm m-1 card bg-light p-3">
                  <h5>User</h5>
                  <p>Halaman Untuk mengontrol User</p>
                </a>
              </div>
              <div class="d-flex justify-content-center mt-3 p-2 ">
                <a href="{{ url('/') }}" class="btn btn-secondary" >Kembali Ke Halaman Utama</a>
              </div>
            </div>
        </div>
    </section>
@endsection
