<?php

namespace App\Http\Controllers;

use App\DataTables\BooksDataTable;
use App\DataTables\TransactionListDataTable;
use App\DataTables\UsersDataTable;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
  function dashboard()
  {
    $member = User::where('role', 0)->count();
    $book = Book::count();
    $user = User::count();
    $transaction = Transaction::count();

    return view('admin.dashboard', compact('user', 'book', 'member', 'transaction'));
  }


  //users
  function users(UsersDataTable $dataTable)
  {
    return $dataTable->render('admin.users');
  }

  function get_user(Request $request)
  {
    $user = User::where('id', $request->id)->first();

    return response()->json($user);
  }

  function update_user(Request $request)
  {
    $user = User::where('id', $request->id)->first();

    $user->name = $request->name;
    $user->email = $request->email;
    $user->role = $request->role;

    $user->save();

    return response()->json($user);
  }

  function delete_user(Request $request)
  {
    $user = User::where('id', $request->id)->first();

    $user->delete();

    return response()->json($user);
  }


  //books
  function books(BooksDataTable $dataTable)
  {
    return $dataTable->render('admin.books');
  }

  function get_Book(Request $request)
  {
    $book = Book::where('id', $request->id)->first();

    return response()->json($book);
  }

  function add_book(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'author' => 'required',
      'year' => 'required',
      'publisher' => 'required',
      'cover' => 'required',
      'description' => 'required',
      'stock' => 'required',
    ]);

    $book = new Book();

    $book->title = $request->title;
    $book->author = $request->author;
    $book->year = $request->year;
    $book->publisher = $request->publisher;
    $book->description = $request->description;
    $book->stock = $request->stock;

    $file = $request->file('cover');
    $extension = $file->getClientOriginalExtension();
    $filename = time() . '.' . $extension;
    $file->move('uploads/books/', $filename);
    $book->cover = $filename;

    $book->save();

    return response()->json($book);
  }

  function update_book(Request $request)
  {
    $request->validate([
      'title' => 'required',
      'author' => 'required',
      'year' => 'required',
      'publisher' => 'required',
      'description' => 'required',
      'stock' => 'required',
    ]);

    $book = Book::where('id', $request->id)->first();

    $book->title = $request->title;
    $book->author = $request->author;
    $book->year = $request->year;
    $book->publisher = $request->publisher;
    $book->description = $request->description;
    $book->stock = $request->stock;

    if ($request->file('cover')) {
      File::delete('uploads/books/' . $book->cover);
      $file = $request->file('cover');
      $extension = $file->getClientOriginalExtension();
      $filename = time() . '.' . $extension;
      $file->move('uploads/books/', $filename);
      $book->cover = $filename;
    }

    $book->save();

    return response()->json($book);
  }
  function delete_book(Request $request)
  {
    $book = Book::where('id', $request->id)->first();

    File::delete('uploads/books/' . $book->cover);
    $book->delete();

    return response()->json($book);
  }

  function transaction(TransactionListDataTable $dataTable)
  {
    return $dataTable->render('admin.transaction');
  }
}
