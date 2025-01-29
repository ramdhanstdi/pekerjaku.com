@extends('tamplate.app')

@section('content')
    <section class="prosedur py-5">
      <div class="container">
        <h2 class="text-center mb-4">Prosedur Pemesanan Pekerja</h2>
        
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="list-group">
              <div class="list-group-item">
                <h5 class="mb-1">1. Registrasi atau Login</h5>
                <p class="mb-1">Pengguna harus mendaftar atau masuk ke akun mereka di platform Pekerjaku.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">2. Pilih Jenis Pekerja</h5>
                <p class="mb-1">Pilih kategori pekerja rumah tangga sesuai kebutuhan, seperti babysitter, supir, asisten rumah tangga, tukang kebun, dan lain lain.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">3. Lihat Profil dan Ulasan</h5>
                <p class="mb-1">Tinjau profil pekerja, pengalaman kerja, dan ulasan dari pengguna lain sebelum memilih.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">4. Lakukan Pemesanan</h5>
                <p class="mb-1">Klik tombol "Pesan Sekarang" dan isi detail pekerjaan serta jadwal yang diinginkan.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">5. Konfirmasi dan Pembayaran</h5>
                <p class="mb-1">Selesaikan pembayaran melalui metode yang tersedia dan tunggu konfirmasi dari sistem.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">6. Pekerja Datang ke Lokasi</h5>
                <p class="mb-1">Setelah dikonfirmasi, pekerja akan datang ke lokasi sesuai dengan jadwal yang telah ditentukan.</p>
              </div>
              <div class="list-group-item">
                <h5 class="mb-1">7. Berikan Ulasan</h5>
                <p class="mb-1">Setelah layanan selesai, berikan ulasan untuk membantu pengguna lain dalam memilih pekerja.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection

@push('script')
<script>
// Tambahkan script jika diperlukan di sini
</script>
@endpush
