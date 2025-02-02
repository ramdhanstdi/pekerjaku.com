@extends('tamplate.pekerja')

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
                        <th>Majikan</th>
                        <th>No Telp Pekerja</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($dataOrder as $item)
                    <tr>
                        <td>{{ $item->fullNameMajikan }}</td>
                        <td>{{ $item->telpMajikan }}</td>
                        <td>
                          <span class="badge 
                              @if ($item->status == 'selesai') bg-success
                              @elseif ($item->status == 'pending') bg-secondary
                              @elseif ($item->status == 'bekerja') bg-warning
                              @endif text-white text-capitalize p-2">
                              {{ $item->status }}
                          </span>
                        </td>
                        <td>{{ $item->note }}</td>
                        <td>
                          @if ($item->status === 'selesai' && strpos($item->note, 'review') == true)
                              <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                  Lihat review
                              </button>
                          @else
                            <a class="btn btn-success" href="https://wa.me/{{ env('WHATSAPP_CONTACT') }}">Hubungi Admin</a>
                          @endif
                        </td>
                    </tr>
                  
                    <!-- Move Modal Here -->
                    <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Detail Review - {{ $item->fullNamePekerja }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body product__details__text">
                              <div class="mb-3 product__details__rating">
                                <label class="form-label">Rating</label>
                                <div>
                                  @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $item->review->star)
                                      <i class="fa fa-star"></i>
                                    @else
                                      <i class="fa fa-star-o "></i>
                                    @endif
                                  @endfor
                                </div>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Review</label>
                                <p class="form-control-plaintext">{{ $item->review->comment ?? 'Belum ada review.' }}</p>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                          </div>
                        </div>
                      </div>                      
                  @endforeach                  
                </tbody>
            </table>
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