@extends('tamplate.admin')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h1>Data User</h1>

        <div class="p-2">
            <button class="btn btn-md btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">ADD USER</button>

             <!-- Modal Structure -->
             <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div  class="modal-body">
                            <!-- Modal Form -->
                            <form id="addUserForm" >
                                @csrf
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                  </div>
                                  <div class="mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="district" class="form-label">Kecamatan</label>
                                    <input type="text" class="form-control" id="district" name="district" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="regency_city" class="form-label">Kota / Kabupaten</label>
                                    <input type="text" class="form-control" id="regency_city" name="regency_city" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="province" class="form-label">Provinsi</label>
                                    <input type="text" class="form-control" id="province" name="province" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="phone_number" class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="number_whatsapp" class="form-label">Nomer Whatsapp</label>
                                    <input type="text" class="form-control" id="number_whatsapp" name="number_whatsapp" required>
                                  </div>
                                  <div class="mb-3">
                                    <label for="level_user" class="form-label">Pekerja / Majikan</label>
                                    <select id="level_user" name="level_user" required>
                                      <option value="" disabled selected>Pilih Role</option>
                                      <option value="3">Pekerja</option>
                                      <option value="2">Majikan</option>
                                    </select>
                                  </div>
                                  <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
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

               <!-- Detail Modal -->
            <div class="modal fade" id="detailUserModal" tabindex="-1" aria-labelledby="detailUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailUserModalLabel">User Details</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="userDetails">
                                <!-- User details will be dynamically loaded here -->
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

            {{-- <form method="GET" action="{{ route('admin.user') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama, email, alamat..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form> --}}
        
            <div class="py-2">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten/Kota</th>
                            <th>Province</th>
                            <th>No Telepon</th>
                            <th>Bayar Pembayaran</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->level_user == 3 ? 'Pekerja' : 'Majikan' }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->district }}</td>
                            <td>{{ $item->regency_city }}</td>
                            <td>{{ $item->province }}</td>
                            <td>{{ $item->phone_number }}</td>
                            <td>{{ $item->buktibayar ? 'Sudah Bayar' : 'Belum Bayar' }}</td>
                            <td>
                                <button class="btn btn-sm btn-info w-100" onclick="viewDetail({{ $item->id }})">Detail</button>
                                <button class="btn btn-sm btn-danger my-1 w-100" onclick="deleteUser({{ $item->id }})">Delete</button>
                                @if(!$item->pay)
                                    <button  class="btn btn-sm btn-success w-100" onclick="activationUser({{ $item->id }})">Aktifkan</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>        
        </div>
        </div>
      </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Handle form submission
            $('#addUserForm').on('submit', function (e) {
                e.preventDefault(); // Prevent the form from submitting normally
    
                let formData = new FormData(this); // Capture the form data
                let token = localStorage.getItem('auth_token');
    
                // Send AJAX request
                $.ajax({
                    url: '/api/registrasi', // API endpoint
                    method: 'POST',        // HTTP method
                    data: formData,        // Form data
                    processData: false,    // Prevent jQuery from automatically processing data
                    contentType: false,    // Prevent jQuery from setting content type
                    headers: {
                        'Authorization': `Bearer ${token}`, // Include the Bearer Token here
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF Token
                    },
                    success: function (response) {
                        if (response.status) {
                            alert(response.message); // Success message
                            location.reload();       // Reload the page
                        } else {
                            alert('Error: ' + response.message); // Error message from server
                        }
                    },
                    error: function (xhr, status, error) {
                        if (xhr.status === 401) {
                            alert('Session expired. Please log in again.');
                            window.location.href = '/login'; // Redirect to login page
                        }
                        console.error(xhr.responseText); // Log error for debugging
                        alert('An error occurred. Please try again.');
                    },
                });
            });
        });

        function viewDetail(userId) {
            let token = localStorage.getItem('auth_token'); // Retrieve the stored token
                $.ajax({
                    url: `/api/admin/user/getOne?id=${userId}`, // API endpoint to fetch user details
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`, // Include token
                    },
                    success: function (response) {
                        if (response.status) {
                            let user = response.data;

                            // Populate modal content with user details
                            $('#userDetails').html(`
                                <div class='d-flex justify-content-center mb-3'>
                                    <img src="${user.image ? '/storage/' + user.image : '/default-avatar.png'}" style="object-fit: cover" alt="User Image" width="250">
                                </div>
                                <table class='table'>
                                    <tbody>
                                        <tr>
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td>${user.first_name} ${user.last_name}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>:</td>
                                            <td>${user.email}</td>
                                        </tr>
                                        <tr>
                                            <td>Alamat</td>
                                            <td>:</td>
                                            <td>${user.address}</td>
                                        </tr>
                                        <tr>
                                            <td>Kecamatan</td>
                                            <td>:</td>
                                            <td>${user.district}</td>
                                        </tr>
                                        <tr>
                                            <td>Kabupaten/Kota</td>
                                            <td>:</td>
                                            <td>${user.regency_city}</td>
                                        </tr>
                                        <tr>
                                            <td>Provinsi</td>
                                            <td>:</td>
                                            <td>${user.province}</td>
                                        </tr>
                                        <tr>
                                            <td>No Telepon</td>
                                            <td>:</td>
                                            <td>${user.phone_number}</td>
                                        </tr>
                                        <tr>
                                            <td>No Whatsapp</td>
                                            <td>:</td>
                                            <td>${user.number_whatsapp}</td>
                                        </tr>
                                        <tr>
                                            <td>Role</td>
                                            <td>:</td>
                                            <td>${user.level_user === 3 ? 'Pekerja' : 'Majikan'}</td>
                                        </tr>
                                        <tr>
                                            <td>Bukti Bayar</td>
                                            <td>:</td>
                                            <td class="d-flex justify-content-center mb-3">
                                                <img src="${user.buktibayar ? '/storage/' + user.buktibayar : '/storage/belum_bayar.png'}" alt="Bukti Bayar" width="250">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>KTP</td>
                                            <td>:</td>
                                            <td class="d-flex justify-content-center mb-3">
                                                <img src="${user.ktp ? '/storage/' + user.ktp : ''}" alt="Foto KTP" width="250">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Selfie KTP</td>
                                            <td>:</td>
                                            <td class="d-flex justify-content-center mb-3">
                                                <img src="${user.selfiektp ? '/storage/' + user.selfiektp : ''}" alt="Foto Selfie KTP" width="250">
                                            </td>
                                        </tr>
                                        ${user.level_user == 3 ? `
                                            <tr>
                                                <td>SKCK</td>
                                                <td>:</td>
                                                <td class="d-flex justify-content-center mb-3">
                                                    <img src="${user.skck ? '/storage/' + user.skck : ''}" alt="Foto SKCK" width="250">
                                                </td>
                                            </tr>
                                        ` : ''}
                                        ${user.level_user == 3 ? `
                                            <tr>
                                                <td>Ijazah</td>
                                                <td>:</td>
                                                <td class="d-flex justify-content-center mb-3">
                                                    <img src="${user.ijazah ? '/storage/' + user.ijazah : ''}" alt="Foto Ijazah" width="250">
                                                </td>
                                            </tr>
                                        ` : ''}
                                    </tbody>
                                </table>
                            `);

                            // Show the modal
                            $('#detailUserModal').modal('show');
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                let token = localStorage.getItem('auth_token'); // Retrieve the stored token

                $.ajax({
                    url: `/api/admin/user/delete`,
                    type: 'POST',
                    data: {
                        id: userId // Pass userId in the request body
                    },
                    headers: {
                        'Authorization': `Bearer ${token}`, // Include token
                    },
                    success: function (response) {
                        if (response.status) {
                            alert(response.message);
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        }

        function activationUser(userId) {
            if (confirm('Aktifkan akun ini?')) {
                let token = localStorage.getItem('auth_token'); // Retrieve the stored token

                $.ajax({
                    url: `/api/admin/user/activation`, // Updated URL
                    type: 'POST',
                    data: {
                        id: userId // Pass userId in the request body
                    },
                    headers: {
                        'Authorization': `Bearer ${token}`, // Include token in headers
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token to headers (if needed)
                    },
                    success: function (response) {
                        if (response.status) {
                            alert(response.message);
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error: ' + response.message); // Show error message if response status is false
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            }
        }


    </script>
    
@endsection


@push('script')
<script>
    new DataTable('#example');
</script>
@endpush


