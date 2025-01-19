@extends('tamplate.admin')

@section('content')
    <section class="dashboard">
        <div class="container">
            <h1>Lowongan</h1>

            <div class="p-2">
                <!-- Button to trigger modal -->
                <button class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#addLowonganModal">ADD KATEGORI LOWONGAN</button>

                <!-- Modal Structure -->
                <div class="modal fade" id="addLowonganModal" tabindex="-1" aria-labelledby="addLowonganModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addLowonganModalLabel">Add Kategori Lowongan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addLowonganForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="py-2 overflow-auto">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Nama Lengkap</th>
                                <th>No telepon</th>
                                <th>Alamat</th>
                                <th>Kecamatan</th>
                                <th>Kabupaten / Kota</th>
                                <th>Provinsi</th>
                                <th>Status</th>
                                <th>Umur</th>
                                <th>Pengalaman (Tahun)</th>
                                <th>Jumlah Anak</th>
                                <th>Gaji yang diharapkan</th>
                                <th>Gaji Minimal</th>
                                <th>Bersedia bekerja</th>
                                <th>Jam bisa dihubungi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lowongan as $item)
                                <tr>
                                    <td>{{ $item->kategori->name }}</td>
                                    <td>{{ $item->name_lengkap }}</td>
                                    <td>{{ $item->no_telepon }}</td>
                                    <td>{{ $item->address }}</td>
                                    <td>{{ $item->kecamatan }}</td>
                                    <td>{{ $item->kabupaten }}</td>
                                    <td>{{ $item->provinsi }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->umur }}</td>
                                    <td>{{ $item->pengalaman }}</td>
                                    <td>{{ $item->punya_anak }}</td>
                                    <td>Rp.{{ number_format($item->salary, 0, ',','.') }}</td>
                                    <td>Rp.{{ number_format($item->salary_min, 0, ',','.') }}</td>
                                    <td>{{ $item->bersedia_bekerja }}</td>
                                    <td>{{ $item->jam_berapa_bisa_dihubungi }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-info mb-1">Detail</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
    <script>
         $(document).ready(function () {
            // Handle form submission
            $('#addLowonganForm').on('submit', function (e) {
            e.preventDefault();
            const token = localStorage.getItem('auth_token');
            // Create a new FormData object
            const formData = new FormData(this); // Automatically gathers all form fields, including files

            $.ajax({
                url: '/api/admin/kategori/save',
                type: 'POST',
                data: formData, // Send FormData instead of serialized data
                contentType: false, // Let jQuery set the correct content type for FormData
                processData: false, // Prevent jQuery from processing the FormData
                headers:{
                            'Authorization': `Bearer ${token}`,
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
                        },
                success: function(response) {
                        if (response.status) {
                            if (xhr.status === 401) {
                            alert('Session expired. Please log in again.');
                            window.location.href = '/login';
                            window.location.reload()
                        }
                        } else {
                            console.log('error', response);
                            showAlert(response?.message, 'warning');
                        }
                    },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
                });
            });
        });
    </script>
@endsection
