@extends('layout.app')
 
@section('title', ' | Список прав')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Права</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Права</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ url('/admin/permissions') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>
{{-- 
                    <a href="{{ url('/admin/permissions/create') }}" class="btn btn-success pull-right float-r" title="Add New user">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a> --}}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
 
                        @include('includes.flash_message')
 
                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th><th>Название</th><th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($permissions as $count => $item)
                                        <tr>
                                            <td>{{ $count+1 }}</td>
                                            <td>{{ $item->title }}</td>
{{--                                             <td>
                                                <a href="{{ url('/admin/permissions/' . $item->id) }}" title="Просмотр права"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                               
                                            </td> --}}
                                            <td>{{ $item->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $permissions->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection