@extends('layouts.librarian')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            Book List
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book Detail</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-auto">
                                <img src="" class="img-fluid img-detail rounded" alt="Wild Landscape"
                                    id="detail-cover" />
                            </div>
                            <div class="col">
                                <div class="col text-center">
                                    <h3 class="text-dark" id="detail-title"></h3>
                                </div>
                                <div class="col">
                                    <ul class="list-group list-group-light list-group-small">
                                        <li class="list-group-item">
                                            <span class="fw-bold">Author: </span>
                                            <span id="detail-author"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">Year: </span>
                                            <span id="detail-year"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">Publisher: </span>
                                            <span id="detail-publisher"></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">Stock: </span>
                                            <span id="detail-stock"></span>
                                        </li>
                                    </ul>
                                    <div class="col" id="detail-desc">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })

        closeModal = () => {
            $('#detailModal').modal('hide');
        }

        function detailModal(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('librarian.getBook') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#detail-title').html(data.title);
                    $('#detail-author').html(data.author);
                    $('#detail-year').html(data.year);
                    $('#detail-publisher').html(data.publisher);
                    $('#detail-stock').html(data.stock);
                    $('#detail-desc').html(data.description);
                    $('#detail-cover').attr('src', "{{ url('uploads/books') }}/" + data.cover);
                }
            });
            $('#detailModal').modal('show');
        }
    </script>
@endpush
