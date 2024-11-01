@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-sm mb-2">
        <div class="card-header">
            Data Diri
        </div>
        <div class="card-body">
            <ul class="list-group ps-3">
                <li type="none" class="mb-1">
                <span class="fw-bold d-block">nama :</span>
                <span>{{$name}}</span>
                </li>
                <li type="none" class="mb-1">
                    <span class="fw-bold d-block">username :</span>
                    <span>{{$username}}</span>
                </li>
                <li type="none" class="mb-1">
                    <span class="fw-bold d-block">Role :</span>
                    <span>{{$role}}</span>
                </li>
                <div>
                    <a href="{{route('change.password.form')}}">
                        <button class="btn btn-info mt-2">Ubah sandi</button>
                    </a>
                </div>
            </ul>
        </div>
    </div>
</div>
@endsection