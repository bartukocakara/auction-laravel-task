@extends('front-layouts.app')

@section('title', 'Home Page')


@section('navbar')
    @parent
@endsection


@section('content')

@include('front-layouts._products')


@endsection


@section('footer')
    @parent
@show
