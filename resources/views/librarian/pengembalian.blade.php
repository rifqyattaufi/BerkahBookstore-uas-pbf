@extends('layouts.librarian')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            Pengembalian
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="kembaliModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Return Book</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <form id="kembaliForm">
                        <input type="hidden" name="id" id="id">
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </form>
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
        });

        closeModal = () => {
            $('#kembaliModal').modal('hide');
            $('#kembaliForm').trigger('reset');
        };

        pengembalian = (id, book_id) => {
            $.ajax({
                url: "{{ route('librarian.getBook') }}",
                type: "POST",
                data: {
                    id: book_id
                },
                datatype: "JSON",
                success: function(data) {
                    $('#kembaliModal').modal('show');
                    $('.modal-body').html('Are you sure you want to return "' + data.title + '"');
                    $('#id').val(id);
                }
            });
        };

        $('#kembaliForm').submit(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            $.ajax({
                url: "{{ route('librarian.pengembalianPost') }}",
                type: "POST",
                data: {
                    id: id
                },
                datatype: "JSON",
                success: function(data) {
                    $('#kembaliModal').modal('hide');
                    $('#kembaliForm').trigger('reset');
                    $('#transaction-table').DataTable().ajax.reload();
                }
            });
        });
    </script>
@endpush
