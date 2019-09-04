<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>window.laravel = { csrfToken: '{{ csrf_token() }}' }</script>
<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Styles -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link 
  rel="stylesheet"
  href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
  integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If"
  crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link href="{{ asset('css/gen.css') }}" rel="stylesheet">


</head>
<body>

        {{--@unless(View::exists('auth.login'))--}}
@if(Request::url() != "http://localhost/athomecare/public/invoice/94" && Request::url() != "http://localhost/athomecare/public/login")

@include('layouts.header') 

@endif
{{--@endunless--}}

<div class="main">
    
    @if(Request::url() != "http://localhost/athomecare/public/invoice/94" && Request::url() != "http://localhost/athomecare/public/login")
        @include('layouts.aside')
    @endif

    @yield('content')
    {{--@unless(View::exists('auth.login'))--}}


    {{--@endunless--}}
</div>


@include('layouts.footer')