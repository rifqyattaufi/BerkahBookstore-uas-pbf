<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LibrarianController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('redirectLogin', [Controller::class, 'redirectLogin'])->name('redirectLogin');

Route::get('/', function () {

    $books = Book::inRandomOrder()->limit('5')->get();
    $carousells = Book::inRandomOrder()->limit('3')->get();

    return view('welcome', compact(['books', 'carousells']));
})->name('home');

Route::get('/home', function () {
    return redirect()->route('redirectLogin');
});

Auth::routes();

Route::middleware('auth')->group(function () {

    Route::middleware('role:0')->group(function () {
        Route::get('/list', function () {
            $books = Book::all();

            return view('list', compact(['books']));
        })->name('list');

        Route::get('/detail/{id}', function ($id) {
            $book = Book::where('id', $id)->first();
            $books = Book::inRandomOrder()->whereNot('id', $id)->limit('5')->get();

            return view('detail', compact(['book', 'books']));
        })->name('detail');
    });


    Route::prefix('admin')->name('admin.')->middleware('role:2')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [AdminController::class, 'dashboard']);

        Route::get('users', [AdminController::class, 'users'])->name('users');
        Route::post('users', [AdminController::class, 'get_user'])->name('getUser');
        Route::put('users', [AdminController::class, 'update_user'])->name('updateUser');
        Route::delete('users', [AdminController::class, 'delete_user'])->name('deleteUser');

        Route::get('books', [AdminController::class, 'books'])->name('books');
        Route::post('books', [AdminController::class, 'get_book'])->name('getBook');
        Route::post('books/add', [AdminController::class, 'add_book'])->name('addBook');
        Route::post('books/update', [AdminController::class, 'update_book'])->name('updateBook');
        Route::post('books/delete', [AdminController::class, 'delete_book'])->name('deleteBook');

        Route::get('transaction', [AdminController::class, 'transaction'])->name('transaction');
    });

    Route::prefix('librarian')->name('librarian.')->middleware('role:1')->group(function () {
        Route::get('dashboard', [LibrarianController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [LibrarianController::class, 'dashboard']);

        Route::get('books', [LibrarianController::class, 'books'])->name('books');
        Route::post('books', [LibrarianController::class, 'get_book'])->name('getBook');

        Route::get('peminjaman', [LibrarianController::class, 'peminjaman'])->name('peminjaman');
        Route::post('peminjaman/add', [LibrarianController::class, 'add_peminjaman'])->name('addPeminjaman');

        Route::get('pengembalian', [LibrarianController::class, 'pengembalian'])->name('pengembalian');
        Route::post('pengembalian', [LibrarianController::class, 'pengembalianPost'])->name('pengembalianPost');
    });
});
