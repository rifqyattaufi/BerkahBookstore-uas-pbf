@extends('layouts.librarian')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            Peminjaman
            <button class="btn btn-secondary position-relative" onclick="openCart()">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge-success"
                    id="item-count">

                </span>
            </button>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <form id="formModal">
                    <div class="modal-body">
                        <div class="container-fluid">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="row me-5">
                            <div class="col-10">
                                <div class="input-group flex-nowrap">
                                    <span class="input-group-text" id="addon-wrapping">User Email</span>
                                    <input type="email" name="user_email" class="form-control" />
                                </div>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-secondary" onclick="">Submit</button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}

    <script>
        var bookData = [];
        var item = 0;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#item-count').html(item);
        })

        function openCart() {
            $('#cartModal').modal('show');
        }

        function closeModal() {
            $('#cartModal').modal('hide');
        }

        function addCart(id) {
            if (bookData.includes(id)) {
                alert('Book already in cart');
                return;
            }
            $.ajax({
                url: "{{ route('librarian.getBook') }}",
                method: "POST",
                data: {
                    id: id
                },
                success: function(data) {
                    bookData.push(id);
                    var bookDataHtml =
                        '<div class="card" id="card-' + data.id + '">' +
                        '<input type="hidden" name="book_id[]" value="' + data.id + '">' +
                        '<div class="card-body">' +
                        '<div class="row">' +
                        '<div class="col">' +
                        '<h4>' + data.title + '</h4>' +
                        '<p>Author: ' + data.author + '</p>' +
                        '</div>' +
                        '<div class="col text-end">' +
                        '<button type="button" class="btn btn-danger btn-floating fs-6" onclick="deleteCart(' +
                        data.id + ')">' +
                        '<i class="bi bi-trash3"></i>' +
                        '</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                    item++;
                    $('#item-count').html(item);
                    $('.modal-body .container-fluid').append(bookDataHtml);
                }
            })
        }

        function deleteCart(id) {
            $('#card-' + id).remove();
            item--;
            $('#item-count').html(item);
            bookData = bookData.filter(function(value, index, arr) {
                return value != id;
            });
        }

        $('#formModal').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "{{ route('librarian.addPeminjaman') }}",
                method: "POST",
                data: formData,
                success: function(data) {
                    console.log(data);
                    $('#cartModal').modal('hide');
                    item = 0;
                    $('#item-count').html(item);
                    $('.modal-body .container-fluid').html('');
                    $('#books-table').DataTable().ajax.reload();
                }
            })
        });
    </script>
@endpush
