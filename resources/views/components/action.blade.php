@if (!Route::is('librarian.peminjaman') && !Route::is('librarian.pengembalian'))
    @if (!Route::is('librarian.books'))
        <button type="button" class="btn btn-success btn-floating fs-6 me-2" onClick="openModal({{ $model->id }})">
            <i class="fa-regular fa-pen-to-square"></i>
        </button>
    @endif

    @if (!Route::is('admin.users'))
        <button type="button" class="btn btn-warning btn-floating fs-6 me-2" onclick="detailModal({{ $model->id }})">
            <i class="fa-solid fa-info"></i>
        </button>
    @endif

    @if (!Route::is('librarian.books'))
        <button type="button" class="btn btn-danger btn-floating fs-6" onclick="deleteModal({{ $model->id }})"
            id="cart-{{ $model->id }}">
            <i class="bi bi-trash3"></i>
        </button>
    @endif
@endif
@if (Route::is('librarian.peminjaman'))
    <button type="button" class="btn btn-secondary btn-floating fs-6" onclick="addCart({{ $model->id }})">
        <i class="fa-solid fa-cart-plus"></i>
    </button>
@endif
@if (Route::is('librarian.pengembalian'))
    <button type="button" class="btn btn-success btn-floating fs-6"
        onclick="pengembalian({{ $model->id }}, {{ $model->book_id }})">
        <i class="fa-solid fa-check"></i>
    </button>
@endif
