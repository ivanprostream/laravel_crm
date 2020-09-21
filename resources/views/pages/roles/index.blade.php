@extends('layout.app')
 
@section('title', ' | Список ролей')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Роли</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Роли</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ url('/admin/roles') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                    <a href="{{ url('/admin/roles/create') }}" class="btn btn-success pull-right float-r" title="Add New user">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a>
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
                                        @foreach($roles as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    <a href="{{ url('/admin/roles/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                                    <a href="{{ url('/admin/roles/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
     
                                                    <form method="POST" action="{{ url('/admin/roles' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $roles->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection