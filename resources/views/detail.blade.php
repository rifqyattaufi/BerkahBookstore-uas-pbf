@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-auto">
            <img src="{{ url('uploads/books/' . $book->cover) }}" class="img-fluid img-detail rounded" alt="Wild Landscape" />
        </div>
        <div class="col">
            <div class="col text-center">
                <h3 class="text-dark">{{ $book->title }}</h3>
            </div>
            <div class="col">
                <ul class="list-group list-group-light list-group-small">
                    <li class="list-group-item">Author: {{ $book->author }}</li>
                    <li class="list-group-item">Publisher: {{ $book->publisher }}</li>
                    <li class="list-group-item">Released: {{ $book->year }}</li>
                    <li class="list-group-item">Description: </li>
                </ul>
                <div class="col">
                    {{ $book->description }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col text-center mt-3">
            <h2>More Books</h2>
        </div>
        <div class="row row-cols-5 mt-4">
            @foreach ($books as $more)
                <div class="col d-flex justify-content-center">
                    <div class="card hover-zoom" style="width: 11.7rem">
                        <img src="{{ url('uploads/books/' . $more->cover) }}" class="card-img hover-shadow"
                            alt="Stony Beach" />
                        <a href="{{ route('detail', $more->id) }}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
