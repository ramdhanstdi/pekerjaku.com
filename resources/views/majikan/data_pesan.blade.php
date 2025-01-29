@extends('tamplate.majikan')

@section('content')
<section class="dashboard">
  <div class="container">
    <h2 class="my-2">Data Order</h2>

    <div class="p-2">
        {{-- <button class="btn btn-md btn-primary">ADD PEKERJA</button> --}}
        <div class="py-2">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Pekerja</th>
                        <th>No Telp Pekerja</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($dataOrder as $item)
                    <tr>
                        <td>{{ $item->fullNamePekerja }}</td>
                        <td>{{ $item->telpPekerja }}</td>
                        <td>
                          <span class="badge 
                              @if ($item->status == 'selesai') bg-success
                              @elseif ($item->status == 'bekerja') bg-warning
                              @endif text-white text-capitalize p-2"> 
                              {{ $item->status }}
                          </span>
                        </td>
                        <td>{{ $item->note }}</td><td>
                          <a class="btn btn-success" href="https://wa.me/{{ env('WHATSAPP_CONTACT') }}">Hubungi Admin</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</section>
@endsection

@push('script')
<script>
    new DataTable('#example');
</script>
@endpush