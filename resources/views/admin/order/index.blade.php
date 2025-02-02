@extends('tamplate.admin')

@section('content')
    <section class="dashboard">
      <div class="container">
        <h1>Data Order</h1>

        <div class="p-2">
            {{-- <button class="btn btn-md btn-primary">ADD PEKERJA</button> --}}

            <div class="py-2">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID Order</th>
                            <th>ID Pekerja</th>
                            <th>Pekerja</th>
                            <th>ID Majikan</th>
                            <th>Majikan</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->pekerjaId }}</td>
                            <td class="text-center">
                                {{ $item->fullNamePekerja }}
                                @if(!$item->paymentPekerja)
                                <span class="badge bg-danger text-white" style="padding: 13px">Belum bayar</span>
                                @endif
                                <a class="ms-2 btn btn-success" href="https://wa.me/{{ $item->telpPekerja }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fa fa-phone"></i> Hubungi
                                </a>
                            </td>
                            <td>{{ $item->majikanId }}</td>
                            <td class="text-center">
                                {{ $item->fullNameMajikan }}
                                @if(!$item->paymentMajikan)
                                <span class="badge bg-danger text-white" style="padding: 13px">Belum bayar</span>
                                @endif
                                <a class="ms-2 btn btn-success" href="https://wa.me/{{ $item->telpMajikan }}" target="_blank" class="btn btn-success btn-sm">
                                    <i class="fa fa-phone"></i> Hubungi
                                </a>
                            </td>
                            <td>
                                <span class="badge 
                                    @if ($item->status == 'pending') bg-secondary
                                    @elseif ($item->status == 'rejected') bg-danger
                                    @elseif ($item->status == 'selesai') bg-success
                                    @elseif ($item->status == 'bekerja') bg-warning
                                    @endif text-white text-capitalize p-2"> 
                                    {{ $item->status }}
                                </span>
                            </td>
                        
                            <td>
                                @if ($item->status === 'pending')
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#phoneModal{{ $item->id }}">
                                        <i class="fa fa-check"></i> Konfirmasi
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @foreach ($orders as $item)
                <div class="modal fade" id="phoneModal{{ $item->id }}" tabindex="-1" aria-labelledby="phoneModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="phoneModalLabel{{ $item->id }}">Order Action</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Apakah anda yakin untuk melanjutkan order dengan ID <strong>{{ $item->id }}</strong> ke tahap bekerja?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <form method="POST" action="{{ route('reject.order', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Tolak</button>
                                </form>
                                
                                <form method="POST" action="{{ route('confirm.order', $item->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Setuju</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        
            
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
@endsection
    
@push('script')
<script>
    new DataTable('#example');
</script>
@endpush