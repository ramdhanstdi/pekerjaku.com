@extends('tamplate.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Pembayaran</h4>
                </div>
                <div class="card-body">
                    <p class="text-center">Lakukan Pembayaran untuk menyelesaikan pendaftaran.</p>

                    <h5 class="mt-3">Rekening Tujuan:</h5>
                    <ul class="list-group mb-3">
                        <li class="list-group-item">
                            <strong>Bank:</strong> Bank Mega <br>
                            <strong>Nomor:</strong> 011840011000573 <br>
                            <strong>Nama:</strong> PT Nasco International
                        </li>
                        <li class="list-group-item">
                            <strong>Bank:</strong> BCA <br>
                            <strong>Nomor:</strong> 6870731378 <br>
                            <strong>Nama:</strong> Julia (Komisaris)
                        </li>
                    </ul>

                    <p class="text-muted">
                        Tambahkan tiga angka terakhir nomor telepon Anda pada jumlah yang dibayar untuk memudahkan kami mengenalinya.
                        Misalnya, nomor telepon Anda 0812-131-5100 dan Anda ingin membayar Rp 199.000, maka transferlah Rp 199.100.
                    </p>

                    <form id="payment-form" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="buktibayar">Upload Bukti Pembayaran</label>
                            <input type="file" id="buktibayar" name="buktibayar" class="form-control-file" required>
                        </div>

                        <button type="submit" class="btn btn-success btn-block">Bayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#payment-form').submit(function(e) {
            e.preventDefault();

            let userId = window.location.pathname.split('/').pop(); // Get ID from URL
            let formData = new FormData(this); // Create FormData object

            $.ajax({
                url: `/api/pembayaran/${userId}`,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        window.location.href = '/';
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan, coba lagi.');
                }
            });
        });
    });
</script>
@endsection

