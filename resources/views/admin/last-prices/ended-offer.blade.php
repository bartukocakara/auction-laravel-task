@extends('layouts.app')

@section('title', 'Offers')

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
          <div class="col-sm-2">
            <h1>Ended Offers</h1>
            {{-- <a href="{{ route('offers.create') }}" type="button" class="btn btn-success">Create New offer <span class="font-weight-bold">+</span></a> --}}
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
                    <th><button type="button" class="btn btn-success" disabled>Winner</button></th>
                    <th>Product Name</th>
                    <th>Image</th>
                    <th>Starter Price</th>
                    <th>Last Offer Time</th>
                    <th>Ending Date</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($offers as $offer)
                  <tr>
                        <td>{{ $offer->id }}</td>
                        <td>{{ $offer->userName }}</td>
                        <td>{{ $offer->name }}</td>
                        <td><img src="{{ asset('images/'.$offer->image) }}" width="50" alt=""></td>
                        <td>{{ $offer->starter_price }} ₺</td>
                        <td>{{ $offer->last_offer_time }}</td>
                        <td>{{ $offer->ending_date }}</td>
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
