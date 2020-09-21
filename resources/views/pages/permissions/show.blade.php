@extends('layout.app')
 
@section('title', ' | Показ прав')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $permission->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/permissions') }}">Права</a></li>
              <li class="breadcrumb-item active">Просмотр</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
     
                            <a href="{{ url('/admin/permissions') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
     
                            <br/>
                            <br/>
     
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr><th> Название </th><td> {{ $permission->guard_name }} </td></tr>
                                    </tbody>
                                </table>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection