@extends('tamplate.app')

@section('content')
<div class="container">
  <div class="text-center mb-4">
    <h2>Hubungi Kami</h2>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-8 text-center mb-4">
      <p>
        Jika Anda memiliki pertanyaan atau membutuhkan bantuan, jangan ragu untuk menghubungi kami melalui WhatsApp.
      </p>
      <a href="https://wa.me/{{ env('WHATSAPP_CONTACT') }}" class="btn btn-success">
        Hubungi Admin via WhatsApp
      </a>
    </div>
  </div>
</div>
@endsection


@push('script')
<script>

</script>
@endpush
