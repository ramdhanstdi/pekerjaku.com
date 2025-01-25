@extends('tamplate.admin')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h1>Data Pekerja</h1>

        <div class="p-2">
            {{-- <button class="btn btn-md btn-primary">ADD PEKERJA</button> --}}

            <div class="py-2 overflow-auto">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Pengalaman</th>
                            <th>Skills</th>
                            <th>Pendidikan</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>Kecamatan</th>
                            <th>Kabupaten/Kota</th>
                            <th>Province</th>
                            <th>No Whatsapp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pekerja as $item)
                        <tr>
                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                            <td>{{ $item->kategori_name }}</td>
                            <td>{{ $item->experience }}</td>
                            <td>{{ $item->skills }}</td>
                            <td>{{ $item->education }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->address }}</td>
                            <td>{{ $item->district }}</td>
                            <td>{{ $item->regency_city }}</td>
                            <td>{{ $item->province }}</td>
                            <td>{{ $item->number_whatsapp }}</td>
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
