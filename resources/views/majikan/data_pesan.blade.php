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
                              @elseif ($item->status == 'pending') bg-secondary
                              @elseif ($item->status == 'bekerja') bg-warning
                              @endif text-white text-capitalize p-2">
                              {{ $item->status }}
                          </span>
                        </td>
                        <td>{{ $item->note }}</td>
                        <td>
                          @if ($item->status === 'selesai' && strpos($item->note, 'review') === false)
                              <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#reviewModal{{ $item->id }}">
                                  Nilai Pekerja
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
                                  <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Review Pekerja - {{ $item->fullNamePekerja }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                  <form action="{{ route('majikan.review', $item->reviews_id) }}" method="POST">
                                      @csrf
                                      <label for="rating{{ $item->id }}" class="form-label">Rating</label>
                                      <div class="mb-3">
                                          <select class="form-select" id="rating{{ $item->id }}" name="rating" required>
                                              <option value="5">⭐️⭐️⭐️⭐️⭐️ - Excellent</option>
                                              <option value="4">⭐️⭐️⭐️⭐️ - Good</option>
                                              <option value="3">⭐️⭐️⭐️ - Average</option>
                                              <option value="2">⭐️⭐️ - Poor</option>
                                              <option value="1">⭐️ - Very Bad</option>
                                          </select>
                                      </div>
                                      <label for=""></label>
                                      <div class="mb-3 mt-3">
                                          <label for="review{{ $item->id }}" class="form-label">Review</label>
                                          <textarea class="form-control" id="review{{ $item->id }}" name="review" rows="3" required></textarea>
                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-primary">Submit Review</button>
                                      </div>
                                  </form>
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