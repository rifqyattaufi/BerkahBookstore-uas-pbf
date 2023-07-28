@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            Transaction List
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
