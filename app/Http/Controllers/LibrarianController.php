<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use App\DataTables\TransactionDataTable;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LibrarianController extends Controller
{
    function dashboard()
    {
        return view('librarian.dashboard');
    }

    function books(BooksDataTable $dataTable)
    {
        return $dataTable->render('librarian.book');
    }

    function get_book(Request $request)
    {
        $book = Book::where('id', $request->id)->first();

        return response()->json($book);
    }

    function peminjaman(BooksDataTable $dataTable)
    {
        return $dataTable->render('librarian.peminjaman');
    }

    function add_peminjaman(Request $request)
    {
        $request->validate([
            'user_email' => 'required',
        ]);

        //loop book_id
        foreach ($request->book_id as $book_id) {
            $user = User::where('email', $request->user_email)->get('id')->first();


            Transaction::create(
                [
                    'user_id' => $user->id,
                    'tanggal_pinjam' => Carbon::now(),
                    'book_id' => $book_id
                ]
            );
        }
    }

    function pengembalian(TransactionDataTable $dataTable)
    {
        return $dataTable->render('librarian.pengembalian');
    }

    function pengembalianPost(Request $request)
    {
        $transaction = Transaction::where('id', $request->id)->first();

        $transaction->update([
            'tanggal_kembali' => Carbon::now()
        ]);

        return response()->json($transaction);
    }

    function get_stock(Request $request) {
        $book = Book::where('id', $request->id)->first();

        $stock = Transaction::where('book_id', $book->id)->count();

        $availlable = $book->stock - $stock;

        return response()->json($availlable);
    }
}
