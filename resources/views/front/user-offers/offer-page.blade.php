@extends('front-layouts.app')

@section('title', 'Offer Page')


@section('navbar')
    @parent
@endsection


@section('content')

@include('front-layouts._product-detail')


@endsection


@section('footer')
    @parent
@show
