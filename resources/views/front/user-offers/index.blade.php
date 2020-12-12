@extends('front-layouts.app')

@section('title', 'Teklif Sayfası')


@section('navbar')
    @parent
@endsection


@section('content')

@include('front-layouts._products')


@endsection


@section('footer')
    @parent
@show
