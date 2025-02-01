@extends('tamplate.majikan')

@section('content')
<section class="dashboard">
  <div class="container">
    <h2>Data Pekerja</h2>
    <a href="/pekerja" class="btn btn-success my-4">Cari Pekerja Baru</a>
      <!-- Search Form -->
    {{-- <form method="GET" action="{{ route('majikan.data_pekerja') }}" class="mb-3">
        <input type="text" name="search" class="form-control" placeholder="Cari pekerja atau nomor telepon..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form> --}}
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
                                @if ($item->status == 'tersedia') bg-success
                                @elseif ($item->status == 'bekerja') bg-warning
                                @endif text-white text-capitalize p-2"> 
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>{{ $item->note }}</td>
                        <td>
                          @if($item->status === 'pending')
                              <a class="btn btn-warning" href="https://wa.me/{{ env('WHATSAPP_CONTACT') }}">Hubungi Admin</a>
                              @elseif($item->status === 'bekerja')
                              <a class="btn btn-success" href="http://wa.me/{{$item->telpPekerja}}">Hubungi Pekerja</a>
                              
                              <!-- Button to trigger the modal -->
                              <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmStopModal{{$item->id}}">
                                  Berhentikan Pekerja
                              </button>
                          
                              <!-- Confirmation Modal -->
                              <div class="modal fade" id="confirmStopModal{{$item->id}}" tabindex="-1" aria-labelledby="confirmStopLabel{{$item->id}}" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="confirmStopLabel{{$item->id}}">Konfirmasi Berhentikan Pekerja</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                              Apakah Anda yakin ingin memberhentikan pekerja ini?
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                              <form action="{{ route('majikan.berhenti', $item->id) }}" method="POST">
                                                  @csrf
                                                  @method('PUT')
                                                  <button type="submit" class="btn btn-danger">Ya, Berhentikan</button>
                                              </form>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @endif
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('./js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function() {
      $('#example').DataTable();
  });
</script>

@endsection
