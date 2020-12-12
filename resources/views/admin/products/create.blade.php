@extends('layouts.app')

@section('title', 'Product Create')

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
                <h3 class="card-title">Product / Create</h3>
            </div>
            <br>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                  </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('products.index') }}" method="post" role="form">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="İsim giriniz...">
                    </div>
                    <div class="form-group">
                        <label for="name">Product Image</label>
                        <input type="file" class="form-control" name="image" value="{{ old('image') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Starter Price</label>
                        <input type="number" class="form-control" name="starter_price" value="{{ old('starter_price') }}">
                    </div>
                    <div class="form-group">
                        <label for="name">Ending Date</label>
                        <input type="datetime-local" class="form-control" name="ending_date" value="{{ old('ending_date') }}">
                    </div>
                <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save</button>
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
