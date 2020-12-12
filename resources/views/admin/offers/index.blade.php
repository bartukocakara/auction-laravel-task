@extends('layouts.app')

@section('title', 'Sosyal Linkler')

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
            <h1>Sosyal Linkler</h1>
            <a href="{{ route('socials.create') }}" type="button" class="btn btn-success">Yeni Sosyal Link Oluştur <span class="font-weight-bold">+</span></a>
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
                    <th>İsim</th>
                    <th>Link</th>
                    <th>İşlemler</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($socials as $social)
                  <tr>
                        <td>{{ $social->id }}</td>
                        <td>{{ $social->name }}</td>
                        <td>{{ $social->link }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ URL::to('socials/' . $social->id) .'/edit' }}" type="button" class="btn btn-info">Düzenle</a>
                                <a href="{{ URL::to('socials/' . $social->id) }}" type="button" class="btn btn-warning">Göster</a>
                                <form action="{{ route('socials.delete', $social->id) }}" id="delete" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-danger form-delete">Sil</button>
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
