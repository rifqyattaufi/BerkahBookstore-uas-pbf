@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Manage Users</div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>

    <!-- Modal Form -->
    <div class="modal fade" id="modalForm" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFormTitle">Edit User</h5>
                    <button type="button" class="btn-close" aria-label="Close" onclick="closeModal()"></button>
                </div>
                <form id="formModal">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-body">
                        <div class="form-outline mb-4">
                            <input type="text" id="name" class="form-control" value="asdasda" disabled />
                            <label class="form-label" for="form1Example2">Name</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" id="email" class="form-control" value="asdasdasd" disabled />
                            <label class="form-label" for="form1Example1">Email address</label>
                        </div>
                        <div class="mb-4">
                            <label for="" class="form-label">Role</label>
                            <select class="form-select" aria-label="Default select example" id="role">
                                <option value="0">User</option>
                                <option value="1">Librarian</option>
                                <option value="2">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
                    <h5 class="modal-title" id="modalDeleteTitle">Modal title</h5>
                    <button type="button" class="btn-close" onclick="closeModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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

        function openModal(id) {
            $.ajax({
                url: "{{ route('admin.getUser') }}",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    $('#modalForm').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#email').val(res.email);
                    $('#role').val(res.role);
                },
                error: function(err) {
                    console.log(err);
                }
            });
            // console.log(id);
        }

        function closeModal() {
            $('#modalForm').modal('hide');
            $('#modalDelete').modal('hide');
        }

        $('#formModal').submit(function(e) {
            e.preventDefault();
            var id = $('#id').val();
            var name = $('#name').val();
            var email = $('#email').val();
            var role = $('#role').val();
            $.ajax({
                url: "{{ route('admin.updateUser') }}",
                type: "PUT",
                data: {
                    id: id,
                    name: name,
                    email: email,
                    role: role
                },
                dataType: "JSON",
                success: function(res) {
                    $('#modalForm').modal('hide');
                    $('#users-table').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        })

        function deleteModal(id) {
            $.ajax({
                url: "{{ route('admin.getUser') }}",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    $('#modalDelete').modal('show');
                    $('#modalDeleteTitle').text('Delete User');
                    $('.modal-body').text('Are you sure want to delete ' + res.name + '?');
                    $('.modal-footer').html(`
                        <button type="button" class="btn btn-secondary" onClick="closeModal()">Close</button>
                        <button type="button" class="btn btn-danger" onclick="deleteUser(` + res.id + `)">Delete</button>
                    `);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }

        function deleteUser(id) {
            $.ajax({
                url: "{{ route('admin.deleteUser') }}",
                type: "DELETE",
                data: {
                    id: id
                },
                dataType: "JSON",
                success: function(res) {
                    $('#modalDelete').modal('hide');
                    $('#users-table').DataTable().ajax.reload();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        }
    </script>
@endpush
