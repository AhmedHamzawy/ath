@extends('layouts.app')

@section('content')

<div class="row">
        <div class="col-md-12">
            <div class="card">
               <h5 class="card-header">
                    <div class="col-md-12 float-left text-center title">السجل</div>
                </h5>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="app">
                                    <ul class="timeline">
                                        @foreach($activity as $a)
                                            <li>
                                                <a target="_blank" href="https://www.totoprayogo.com/#">User</a>
                                                <a href="#" style="padding-left: 23px;" class="float-right">{{ $a->created_at }}</a>
                                                <p>{{ $a->description }}</p>
                                            </li>
                                        @endforeach    
                                    </ul>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

@endsection
