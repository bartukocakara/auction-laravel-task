@extends('layouts.app')

@section('title', 'Sosyal Link')

@section('navbar')
    @parent
@endsection


@section('sidebar')
    @parent
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
        <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">{{ $social->name }} / Düzenle</h3>
            </div>
            <br>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                  </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('socials.update', $social->id) }}" method="post" role="form">
                @csrf
                <div class="card-body">
                <div class="form-group">
                    <label for="name">Sosyal Link İsmi</label>
                    <input type="text" class="form-control" value="{{ $social->name }}" placeholder="İsim giriniz..." name="name">
                </div>
                <div class="form-group">
                    <label for="name">Sosyal Link</label>
                    <input type="text" class="form-control" value="{{ $social->link }}" placeholder="Link giriniz..." name="link">
                </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Kaydet</button>
                </div>
            </form>
            </div>
        </div>
        </div>
      </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
