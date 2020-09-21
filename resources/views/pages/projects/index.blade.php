@extends('layout.app')
 
@section('title', ' | Список подразделений')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Проекты</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Проекты</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ url('/admin/projects') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                    @if(user_can('create_project'))
                    <a href="{{ url('/admin/projects/create/'.Request::segment(3) ) }}" class="btn btn-success pull-right float-r" title="Добавить">
                        <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                    </a>
                    @endif
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
                                        <th>#</th>
                                        <th>Название</th>
                                        <th>Подразделение</th>
                                        <th>Руководитель проекта</th>
                                        <th>Статус</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $key=>$item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->division['name'] }}</td>
                                                <td>{{ $item->person }}</td>
                                                <td>{{ getProjectStatus($item->status) }}</td>
                                                <td>
                                                    @if(user_can('view_project'))
                                                    <a href="{{ url('/admin/projects/' . $item->id) }}" title="Задачи"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>  Задания</button></a>
                                                    @endif
                                                    @if(user_can('edit_project'))
                                                    <a href="{{ route('projects.edit', $item->id) }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                                    @endif
                                                    @if(user_can('delete_project'))
                                                    <form method="POST" action="{{ url('/admin/projects' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                        {{ method_field('DELETE') }}
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $projects->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection