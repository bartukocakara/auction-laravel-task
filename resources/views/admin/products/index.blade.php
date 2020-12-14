@extends('layouts.app')

@section('title', 'Products')

@section('navbar')
    @parent
@endsection


@section('sidebar')
    @parent
@endsection

@section('content')
@include('layouts._modal')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Products</h1>
            <a href="{{ route('products.create') }}" type="button" class="btn btn-success">Create New Product <span class="font-weight-bold">+</span></a>
          </div>
          @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status')}}
                  </div>
          @endif
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <table id="formTable" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Starter Price</th>
                    <th>Starting Date</th>
                    <th>Ending Date</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $product)
                  <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td><img src="{{ asset('images/'.$product->image) }}" alt="" width="100"></td>
                        <td>{{ $product->starter_price }}</td>
                        <td>{{ $product->starting_date }}</td>
                        <td>{{ $product->ending_date }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ URL::to('products/' . $product->id) .'/edit' }}" type="button" class="btn btn-info">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" id="delete" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger form-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('footer')
    @parent
@show
