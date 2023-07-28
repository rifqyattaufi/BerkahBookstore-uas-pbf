@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="col">
                <h1 class="title">
                    <span class="text-primary">Berkah</span> Library
                </h1>
            </div>
            <div class="col">
                <p>
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Asperiores commodi maiores necessitatibus.
                    Quam nulla amet quod, excepturi reprehenderit deleniti quos eveniet impedit animi distinctio ducimus
                    veritatis modi fugiat architecto dignissimos!
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Carousel wrapper -->
            <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>

                <!-- Inner -->
                <div class="carousel-inner rounded-5 shadow-4-strong">
                    @foreach ($carousells as $carousell)
                        <div class="carousel-item active">
                            <img src="{{ url('uploads/books/' . $carousell->cover) }}" class="d-block w-100"
                                style="height: 278px;width: 722px;oject-fit: object-fit: cover;" />
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $carousell->title }}</h5>
                            </div>
                        </div>
                    @endforeach

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample"
                        data-mdb-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample"
                        data-mdb-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <!-- Carousel wrapper -->
            </div>
        </div>
        <div class="row row-cols-5 mt-4">
            @foreach ($books as $book)
                <div class="col d-flex justify-content-center">
                    <div class="card hover-zoom" style="width: 11.7rem">
                        <img src="{{ url('uploads/books/' . $book->cover) }}" class="card-img" alt="Stony Beach" />
                        <a href="{{ route('detail', $book->id) }}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex flex-row justify-content-center mt-4">
            <a href="{{ route('list') }}" class="btn btn-secondary">See More</a>
        </div>
    @endsection
