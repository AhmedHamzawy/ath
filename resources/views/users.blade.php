@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <h5 class="card-header">
                <div class="col-md-10 float-left text-left title">المستخدمين</div>
                <button type="button" class="btn btn-primary col-md-2" data-toggle="modal" data-target="#addUser">
                    <i class="fas fa-plus"></i>
                </button>
            </h5>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="app">
                                <users></users>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
