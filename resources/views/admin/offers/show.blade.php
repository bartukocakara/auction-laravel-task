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
                <h3 class="card-title">{{ $social->name }} / Göster</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Sosyal Link İsmi</label>
                    <input type="text" class="form-control" value="{{ $social->name }}" disabled>
                </div>
                <div class="form-group">
                    <label for="name">Sosyal Link</label>
                    <input type="text" class="form-control" value="{{ $social->link }}" disabled>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
@endsection

@section('footer')
    @parent
@endsection
