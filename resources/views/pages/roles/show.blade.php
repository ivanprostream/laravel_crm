@extends('layout.app')
 
@section('title', ' | Показать роль')
 
@section('content')
    
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>{{ $role->name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
                  <li class="breadcrumb-item"><a href="{{ url('/admin/roles') }}">Роли</a></li>
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
     
                            <a href="{{ url('/admin/roles') }}" title="Back"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            <a href="{{ url('/admin/roles/' . $role->id . '/edit') }}" title="Edit role"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактирование</button></a>
     
                            <form method="POST" action="{{ url('admin/roles' . '/' . $role->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete role" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удаление</button>
                            </form>
                            <br/>
                            <br/>
     
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th><td>{{ $role->id }}</td>
                                        </tr>
                                        <tr><th> Название </th><td> {{ $role->name }} </td></tr>
                                        <tr>
                                            <th>Права</th>
                                            <td>
                                                @foreach($role->permissions as $permission)
                                                    <i class="btn btn-info btn-flat" style="margin: 2px">{{ $permission->title }}</i>
                                                @endforeach
                                            </td>
                                        </tr>
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