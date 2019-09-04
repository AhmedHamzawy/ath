@extends('layouts.app')

@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="card">
               <h5 class="card-header">
                    <div class="col-md-12 float-left text-center title">التعليقات</div>
                </h5>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="app">
                                    <comments auth_user_id="{{Auth::user()->id }}"></comments>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
