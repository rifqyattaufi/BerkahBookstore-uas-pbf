@extends('layouts.admin')

@section('content')
    <!--Section: Minimal statistics cards-->
    <section>
        <div class="row">
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-success">{{ $member }}</h3>
                                <p class="mb-0">Total Member</p>
                            </div>
                            <div class="align-self-center">
                                <i class="far fa-user text-success fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fas fa-book-open text-info fa-3x"></i>
                            </div>
                            <div class="text-end">
                                <h3 class="text-info">{{ $book }}</h3>
                                <p class="mb-0">Total Books</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div>
                                <h3 class="text-warning">{{ $transaction }}</h3>
                                <p class="mb-0">Total Transaction</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-chart-pie text-warning fa-3x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between px-md-1">
                            <div class="align-self-center">
                                <i class="fa-solid fa-users text-success fa-3x"></i>
                            </div>
                            <div class="text-end">
                                <h3 class=" text-success">{{ $user }}</h3>
                                <p class="mb-0">Total User</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Section: Statistics with subtitles-->
@endsection
