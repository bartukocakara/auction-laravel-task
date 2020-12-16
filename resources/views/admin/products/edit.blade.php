@extends('layouts.app')

@section('title', 'Edit')

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
                <h3 class="card-title">{{ $product->name }} / Düzenle</h3>
            </div>
            <br>
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                  </div>
            @endif
            <!-- /.card-header -->
            <!-- form start -->
            <form action="{{ route('products.update', $product->id) }}" method="post" role="form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="İsim giriniz..." required>
                    </div>
                    <div class="form-group">
                        <label for="name">Product Image</label>
                        <input type="file" class="form-control" name="image" value="{{ $product->image }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Starter Price</label>
                        <input type="number" class="form-control" name="starter_price" value="{{ $product->starter_price }}" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Ending Date</label>
                        <input type="datetime-local" class="form-control" name="ending_date" value="{{ $product->ending_date }}" required>
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
