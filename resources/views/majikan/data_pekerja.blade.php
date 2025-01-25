@extends('tamplate.majikan')

@section('content')
<section class="dashboard">
  <div class="container">
    <h2>Data Pekerja</h2>

      <!-- Search Form -->
    <form method="GET" action="{{ route('majikan.data_pekerja') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari pekerja atau nomor telepon..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>
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
                        <td>{{ $item->status }}</td>
                        <td>{{ $item->note }}</td>
                        <td>
                          <a class="btn btn-success" href="http://wa.me/{{$item->telpPekerja}}">Hubungi Pekerja</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
          {{ $dataOrder->appends(['search' => request('search')])->links() }}
      </div>
    </div>
  </div>
</section>
@endsection