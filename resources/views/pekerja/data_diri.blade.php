@extends('tamplate.pekerja')

@section('content')
    <section class="data diri">
      <div class="container">
        <h1>Data Diri</h1>
        <div class="row mb-5">
          <div class="col border">
            <img src="./../img/logo-pekerja.jpg" width="90" alt="">
          </div>
          <div class="col-9 border p-2">
            <form id="formDataDiri">
              <div class="row">
                <div class="col">
                  <label for="description" class="form-label">Deskripsi Diri</label>
                  <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="kategori_id" class="form-label">Pekerjaan yang diminati</label>
                  <div class="mb-3 d-flex-col">
                    <select id="kategori_id" name="kategori_id" required>
                      <option value="" disabled selected>Pilih Pekerjaan</option>
                      @foreach ($kategori as $item)
                      <option value={{$item->id}} data-filter={{$item->name}}>{{ $item->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <label class="form-label">&nbsp;</label>
                <div class="col">
                  <label for="experience">Pengalaman</label>
                  <input type="text" class="form-control" name="experience" id="experience">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="age">Umur</label>
                  <input type="text" class="form-control" name="age" id="age">
                </div>
                <div class="col">
                  <label for="education">Pendidikan Terakhir</label>
                  <input type="text" class="form-control" name="education" id="education">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="tall">Tinggi Badan(cm)</label>
                  <input type="text" class="form-control" name="tall" id="tall">
                </div>
                <div class="col">
                  <label for="heavy">Berat Badan(kg)</label>
                  <input type="text" class="form-control" name="heavy" id="heavy">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="tribe_of_origin">Suku</label>
                  <input type="text" class="form-control" name="tribe_of_origin" id="tribe_of_origin">
                </div>
                <div class="col">
                  <label for="religion">Agama</label>
                  <input type="text" class="form-control" name="religion" id="religion">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="police_letter">SKCK</label>
                  <input type="file" class="form-control" name="police_letter" id="police_letter">
                </div>
                <div class="col">
                  <label for="doctors_letter">Keterangan Sehat</label>
                  <input type="file" class="form-control" name="doctors_letter" id="doctors_letter">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="marital_status">Status Kawin</label>
                  <input type="text" class="form-control" name="marital_status" id="marital_status">
                </div>
                <div class="col">
                  <label for="have_children">Jumlah Anak</label>
                  <input type="text" class="form-control" name="have_children" id="have_children">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="stay_at">Bisa Menginap</label>
                  <input type="text" class="form-control" name="stay_at" id="stay_at">
                </div>
                <div class="col">
                  <label for="willing_to_work_in">Bersedia Berkerja di</label>
                  <input type="text" class="form-control" name="willing_to_work_in" id="willing_to_work_in">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="fear_of_dogs">Takut anjing</label>
                  <input type="text" class="form-control" name="fear_of_dogs" id="fear_of_dogs">
                </div>
                <div class="col">
                  <label for="current_location">Lokasi Saat ini</label>
                  <input type="text" class="form-control" name="current_location" id="current_location">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="english">Bahasa Inggris</label>
                  <input type="text" class="form-control" name="english" id="english">
                </div>
                <div class="col">
                  <label for="skills">Skill (Kemampuan)</label>
                  <input type="text" class="form-control" name="skills" id="skills">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="admin_fees">Biaya Admin</label>
                  <input type="text" class="form-control" name="admin_fees" id="admin_fees">
                </div>
                <div class="col">
                  <label for="salary">Gaji</label>
                  <input type="text" class="form-control" name="salary" id="salary">
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <label for="warranty_period">Siap Bekerja dalam (hari)</label>
                  <input type="text" class="form-control" name="warranty_period" id="warranty_period">
                </div>
                <div class="col">
                </div>
              </div>
              <div class="pt-2">
                <button type="submit" class="btn btn-primary btn-md">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#formDataDiri').on('submit', function (e) {
                e.preventDefault(); // Prevent default form submission

                const formData = new FormData(this); // Capture form data
                const token = $('meta[name="csrf-token"]').attr('content'); // CSRF token
                const userId = JSON.parse(localStorage.getItem('user'));                
                formData.append('user_id', userId.id);
                

                $.ajax({
                    url: '/api/admin/pekerja/save', // API endpoint to handle the form
                    method: 'POST',     // HTTP method
                    data: formData,     // Form data
                    processData: false, // Prevent jQuery from processing the data
                    contentType: false, // Prevent jQuery from setting content type
                    headers: {
                        'X-CSRF-TOKEN': token, // Include CSRF token in the headers
                    },
                    success: function (response) {
                        if (response.status) {
                            alert('Data diri berhasil disimpan!'); // Success message
                            $('#formDataDiri')[0].reset(); // Reset the form
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
