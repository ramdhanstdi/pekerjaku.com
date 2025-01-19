@extends('tamplate.pekerja')

@section('content')
    <section class="lowongan">
      <div class="container">
        <h2>Lowongan kerja rumah tangga</h2>
        <p>Persyaratan umum:</p>
        <ul class="ml-5">
          <li>Niat bekerja</li>
          <li>Pria/wanita usia 18-48 tahun</li>
          <li>Sehat jasmani dan rohani</li>
          <li>Memiliki e-KTP asli</li>
          <li>Izin orangtua/suami</li>
          <li>Pengalaman kerja minimal satu tahun</li>
        </ul>

        <p>Lowongan kerja rumah tangga ini aman karena semua majikan diverifikasi identitasnya. Selain itu, Anda tidak perlu kemana-mana. Untuk melamar, bisa langsung dari sini atau via WA. Setelah itu, profil Anda akan tayang di situs ini untuk dipilih majikan. Tidak ada biaya untuk melamar.</p>
        <p>Tahapan melamar:</p>
        <ol class="ml-5">
          <li>Mengisi formulir lamaran</li>
          <li>Menunggu di rumah</li>
          <li>Mendapat majikan </li>
          <li>Wawancara via telepon</li>
          <li>Masuk kerja</li>
        </ol>

        <!-- Modal Structure -->
        <div class="modal fade" id="formulirLamaranModal" tabindex="-1" aria-labelledby="formulirLamaranModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formulirLamaranModalLabel">Formulir Lamaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formLamaran">
                            @csrf
                            <div class="mb-3">
                                <label for="name_lengkap" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="name_lengkap" name="name_lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_telepon_saudara" class="form-label">Nomor Telepon Saudara</label>
                                <input type="text" class="form-control" id="no_telepon_saudara" name="no_telepon_saudara" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <input type="text" class="form-control" id="kecamatan" name="kecamatan" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="kabupaten" class="form-label">Kota / Kabupaten</label>
                                <input type="text" class="form-control" id="kabupaten" name="kabupaten" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" id="provinsi" name="provinsi" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="umur" class="form-label">Umur (Dalam Tahun)</label>
                                <input type="text" class="form-control" id="umur" name="umur" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="punya_anak" class="form-label">Punya Anak</label>
                                <input type="text" class="form-control" id="punya_anak" name="punya_anak" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="pengalaman" class="form-label">Pengalaman (Dalam Tahun)</label>
                                <input type="text" class="form-control" id="pengalaman" name="pengalaman" rows="3" required></input>
                            </div>
                            <label for="kategori_id" class="form-label">Pekerjaan yang diminati</label>
                            <div class="mb-3 d-flex-col">
                              <select id="kategori_id" name="kategori_id" required>
                                <option value="" disabled selected>Pilih Pekerjaan</option>
                                @foreach ($kategori as $item)
                                  <option value={{$item->id}} data-filter={{$item->name}}>{{ $item->name }}</option>
                                @endforeach
                              </select>
                            </div>
                            <label class="form-label">&nbsp;</label>
                            <div class="mb-3">
                                <label for="salary" class="form-label">Gaji yang diharapkan</label>
                                <input type="text" class="form-control" id="salary" name="salary" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="salary_min" class="form-label">Gaji Minimum yang diinginkan</label>
                                <input type="text" class="form-control" id="salary_min" name="salary_min" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="bersedia_bekerja" class="form-label">Bersedia Bekerja dikota (sebut kota)</label>
                                <input type="text" class="form-control" id="bersedia_bekerja" name="bersedia_bekerja" rows="3" required></input>
                            </div>
                            <div class="mb-3">
                                <label for="jam_berapa_bisa_dihubungi" class="form-label">Jam berapa bisa dihubungi</label>
                                <input type="text" class="form-control" id="jam_berapa_bisa_dihubungi" name="jam_berapa_bisa_dihubungi" rows="3" required></input>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <button class="btn btn-sm btn-info my-3" data-bs-toggle="modal" data-bs-target="#formulirLamaranModal">Formulir Lamaran</button>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#formLamaran').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(this); // Capture form data
                const token = $('meta[name="csrf-token"]').attr('content'); // CSRF token
                const userId = JSON.parse(localStorage.getItem('user'));
                formData.append('user_id', userId.id);
                

                $.ajax({
                    url: '/lowongan/save', // API endpoint to handle the form
                    method: 'POST',     // HTTP method
                    data: formData,     // Form data
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    headers: {
                        'X-CSRF-TOKEN': token, // Include CSRF token in the headers
                    },
                    success: function (response) {
                        if (response.status) {
                            alert('Lamaran berhasil dikirim!'); // Success message
                            $('#formulirLamaranModal').modal('hide'); // Hide the modal
                            $('#formLamaran')[0].reset(); // Reset the form
                        } else {
                            alert('Error: ' + response.message); // Error message from server
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText); // Log error for debugging
                        alert('An error occurred. Please try again.');
                    },
                });
            });
        });
    </script>

@endsection