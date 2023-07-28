@extends('layouts.app')

@section('content')
    <div class="row text-center">
        {{-- <div class="col"> --}}
        <h2 class="text-dark mb-3">Book List</h2>
        {{-- </div> --}}
    </div>
    <div class="row row-cols-5">
        @foreach ($books as $book)
            <div class="col d-flex justify-content-center mb-4">
                <div class="card hover-zoom" style="width: 11.7rem">
                    <img src="{{ url('uploads/books/' . $book->cover) }}" class="card-img" alt="Stony Beach" />
                    <div class="card-body">
                        <p class="card-text lh-1" style="font-size: 0.9rem">{{ $book->title }}</p>
                    </div>
                    <a href="{{ route('detail', $book->id) }}" class="stretched-link"></a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
