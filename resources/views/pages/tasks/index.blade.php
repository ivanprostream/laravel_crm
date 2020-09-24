@extends('layout.app')
 
@section('title', ' | Задания')
 
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Задания</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                      <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
                      <li class="breadcrumb-item active">Задания</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                  <form method="GET" action="{{ url('/admin/tasks') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                    @if(user_can('create_task'))
                        <a href="{{ url('/admin/tasks/create') }}" class="btn btn-success pull-right float-r" title="Добавить">
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
     
                            @include('includes.flash_message')
     
                            <br/>
                            <div class="table-responsive">
                                @if(\Auth::user()->is_admin == 1)
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            @if(\Auth::user()->is_admin == 1)
                                                <th>#</th>
                                            @endif
                                            <th>Название</th>
                                            <th>Приоритет</th>
                                            <th>Статус</th>
                                            @if(\Auth::user()->is_admin == 1)
                                                <th>Создан</th>
                                            @endif
                                            <th>Исполнители</th>
                                            <th>Дата создания</th>
                                            <th>Начало / Конец</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $item)
                                            @if($status_type == $item->status)
                                            <tr>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->id }}</td>
                                                @endif
                                                <td>{{ $item->name }}</td>
                                                <td>{!! getStylePriority($item->priority) !!}</td>
                                                <td>{!! getStyleStatus($item->status) !!}</td>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->createdBy->name }}</td>
                                                @endif
                                                <td>
                                                    @foreach($item->assignedUsers as $user)
                                                        {{ $user['name'] }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>
                                                    @if( empty($item->start_date) && empty($item->end_date))
                                                        Бессрочно
                                                    @endif
                                                    {{ getNormalizeDate($item->start_date) }}<br>{{ getNormalizeDate($item->end_date) }}</td>
                                                <td>
                                                    @if(user_can('view_task'))
                                                        <a href="{{ url('/admin/tasks/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                                    @endif
     
                                                    @if(user_can('edit_task'))
                                                        <a href="{{ url('/admin/tasks/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                                    @endif
     
                                                    @if(user_can('update_task_status'))
                                                        <a href="{{ url('/admin/tasks/' . $item->id . '/update-status') }}" title="Обновить статус"><button class="btn btn-primary btn-sm"><i class="fa fa-star" aria-hidden="true"></i> Обновить статус</button></a>
                                                    @endif
     
                                                    @if(user_can('delete_task'))
                                                        <form method="POST" action="{{ url('/admin/tasks' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif  
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if(\Auth::user()->is_admin == 0)
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            @if(\Auth::user()->is_admin == 1)
                                                <th>#</th>
                                            @endif
                                            <th>Название</th>
                                            <th>Приоритет</th>
                                            <th>Статус</th>
                                            @if(\Auth::user()->is_admin == 1)
                                                <th>Создан</th>
                                            @endif
                                            <th>Исполнители</th>
                                            <th>Дата создания</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tasks as $item)
                                            @if($status_type == $item->task->status)
                                            <tr>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->task->id }}</td>
                                                @endif
                                                <td>{{ $item->task->name }}</td>
                                                <td>{{ $item->task->priority }}</td>
                                                <td>{{ $item->task->getStatus->name }}</td>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->task->createdBy->name }}</td>
                                                @endif
                                                <td>
                                                    @foreach($item->task->assignedUsers as $user)
                                                        {{ $user['name'] }}<br>
                                                    @endforeach
                                                </td>
                                                <td>{{ $item->task->created_at }}</td>
                                                <td>
                                                    @if(user_can('view_task'))
                                                        <a href="{{ url('/admin/tasks/' . $item->task->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                                    @endif

                                                    @if( $item->task->status != 2)
                                                    @if(user_can('edit_task'))
                                                        <a href="{{ url('/admin/tasks/' . $item->task->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                                    @endif
     
                                                    @if(user_can('assign_task'))
                                                        <a href="{{ url('/admin/tasks/' . $item->task->id . '/assign') }}" title="Assign task"><button class="btn btn-primary btn-sm"><i class="fa fa-envelope-o" aria-hidden="true"></i> Назначение</button></a>
                                                    @endif
     
                                                    @if(user_can('update_task_status'))
                                                        <a href="{{ url('/admin/tasks/' . $item->task->id . '/update-status') }}" title="Обновить статус"><button class="btn btn-primary btn-sm"><i class="fa fa-star" aria-hidden="true"></i> Обновить статус</button></a>
                                                    @endif
                                                    @endif
     
                                                    @if(user_can('delete_task'))
                                                        <form method="POST" action="{{ url('/admin/tasks' . '/' . $item->task->id) }}" accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                <div class="pagination-wrapper"> {!! $tasks->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection