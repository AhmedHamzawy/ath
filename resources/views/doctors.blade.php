@extends('layouts.app')

@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="card">
               <h5 class="card-header">
                    <div class="col-md-10 float-left text-left title">الأطباء</div>
                    <button type="button" class="btn btn-primary col-md-2" data-toggle="modal" data-target="#addDoctor">
                        <i class="fas fa-plus"></i>
                    </button>
                </h5>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="app">
                                    <doctors :auth_user="{{Auth::user()->id }}" :hospitals="{{ $hospitals }}" :services="{{ $services }}" :statuses="{{ $statuses }}"></doctors>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
