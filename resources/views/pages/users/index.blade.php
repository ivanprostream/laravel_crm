@extends('layout.app')
 
@section('title', ' | Список пользователей')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Пользователи</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Пользователи</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ url('/admin/users') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                    <a href="{{ url('/admin/users/create') }}" class="btn btn-success pull-right float-r" title="Add New user">
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
     
                            @include('includes.flash_message')

                            <br/>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ф.И.О.</th>
                                        <th>Подразделение</th>
                                        <th>Специальность</th>
                                        @if(\Auth::user()->is_admin == 1)
                                        <th>Админ</th>
                                        <th>Активный / Заблокирован</th>
                                        <th>Роль</th>
                                        <th></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}<br><small>Тел: {{ $item->phone }}</small></td>
                                                <td>{{ $item->division['name'] }}</td>
                                                <td>{{ $item->position_title }}</td>
                                                @if(\Auth::user()->is_admin == 1)
                                                <td>{!! $item->is_admin == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>' !!}</td>
                                                <td>{!! $item->is_active == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-ban"></i>' !!}</td>
                                                <td>@if(isset($item->roles[0])) <span class="label label-success">{{ $item->roles[0]->name }}</span> @endif</td>
                                                @endif
                                                <td>
                                                    
                                                    @if(user_can('view_user'))
                                                    <a href="{{ url('/admin/users/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Задания</button></a>
                                                    @endif

                                                    @if(\Auth::user()->is_admin == 1)
                                                    <a href="{{ url('/admin/users/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
     
                                                    <a href="{{ url('/admin/users/role/' . $item->id) }}" title="Роль"><button class="btn bg-purple btn-sm"><i class="fa fa-user" aria-hidden="true"></i> Роль</button></a>
                                                    @if($item->is_admin != 1)
                                                        <form method="POST" action="{{ url('/admin/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                        </form>
                                                    @endif
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $users->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection