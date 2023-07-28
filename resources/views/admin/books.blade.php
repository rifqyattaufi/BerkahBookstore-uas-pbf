@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            Manage Books
            <button class="btn btn-secondary" onclick="openModal()">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormTitle">Add Book</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="closeModal()"></button>
                </div>
                <form id="formModal" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id" value="">
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="text" id="title" name="title" class="form-control" />
                            <label class="form-label" for="form1Example2">Title</label>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="author" name="author" class="form-control" />
                                    <label class="form-label" for="form1Example1">Author</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="year" name="year" class="form-control" />
                                    <label class="form-label" for="form1Example1">Year</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-outline">
                                    <input type="text" id="publisher" name="publisher" class="form-control" />
                                    <label class="form-label" for="form1Example1">Publiher</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline">
                                    <input type="number" id="stock" name="stock" class="form-control" />
                                    <label class="form-label" for="form1Example1">Stock</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                            <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                            <label class="form-label" for="form4Example3">Description</label>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="customFile">Cover</label>
                            <input type="file" class="form-control" id="cover" name="cover"
                                accept="image/x-png,image/gif,image/jpeg" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button type="submit" class="btn btn-primary" id="inputButton">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title-delete">Modal title</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-delete">

                </div>
                <div class="modal-footer" id="modal-footer-delete">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
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

        openModal = (id) => {
            $('#formModal').trigger("reset");
            $('#id').val('');
            $('#modalForm').modal('show');
            if (!id) {
                $('#modalFormTitle').html('Add Book');
                $('#inputButton').html('Add');
            } else {
                $('#modalFormTitle').html('Edit Book');
                $('#inputButton').html('Edit');
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.getBook') }}",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(data) {
                        $('#id').val(data.id);
                        $('#title').val(data.title);
                        $('#author').val(data.author);
                        $('#year').val(data.year);
                        $('#publisher').val(data.publisher);
                        $('#stock').val(data.stock);
                        $('#description').val(data.description);
                    }
                });
            }
        }

        closeModal = () => {
            $('#modalForm').modal('hide');
            $('#modalDelete').modal('hide')
            $('#formModal').trigger("reset");
            $('#detailModal').modal('hide');
            $('#id').val('');
        }

        $('#formModal').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var id = $('#id').val();
            if (id == '') {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.addBook') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        closeModal();
                        $('#formModal').trigger("reset");
                        $('#id').val('');
                        $('#books-table').DataTable().ajax.reload()
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            } else {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.updateBook') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        closeModal();
                        $('#formModal').trigger("reset");
                        $('#id').val('');
                        $('#books-table').DataTable().ajax.reload();
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            }
        })

        function deleteModal(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.getBook') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    $('#modalDelete').modal('show');
                    $('#modal-title-delete').html('Delete Book');
                    $('#modal-body-delete').html('Are you sure want to delete ' + data.title + '?');
                    $('#modal-footer-delete').html(`
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button type="button" class="btn btn-danger" onclick="deleteBook(` + data.id + `)">Delete</button>
                    `);
                }
            });
        }

        function deleteBook(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.deleteBook') }}",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(data) {
                    closeModal();
                    $('#books-table').DataTable().ajax.reload();
                }
            });
        }

        function detailModal(id) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.getBook') }}",
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
