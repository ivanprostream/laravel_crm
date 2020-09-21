@extends('layout.app')
 
@section('title', ' | Show user')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $user->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}"> Пользователи</a></li>
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
     
                            @include('includes.flash_message')
     
                            <a href="{{ url('/admin/users') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            
                            @if(\Auth::user()->is_admin == 1)
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                <form method="POST" action="{{ url('admin/users' . '/' . $user->id) }}" accept-charset="UTF-8" style="display:inline">
                                    {{ method_field('DELETE') }}
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Confirm delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                </form>
                            @endif
                            <br/>
                            <br/>
     
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
     
                                        @if(!empty($user->image))
                                            <tr>
                                                <td>
                                                    <img src="{{ url('public/uploads/users/' . $user->image) }}" class="pull-right" width="200" height="200" />
                                                </td>
                                            </tr>
                                        @endif
     
                                        <tr>
                                            <th>ID</th><td>{{ $user->id }}</td>
                                        </tr>
                                        <tr><th> Ф.И.О. </th><td> {{ $user->name }} </td>
                                        </tr><tr><th> Email </th><td> {{ $user->email }} </td></tr>
                                        <tr><th> Должность </th><td> {{ $user->position_title }} </td></tr>
                                        <tr><th> Контактный телефон </th><td> {{ $user->phone }} </td></tr>
                                        {{-- <tr><th> Is Admin </th><td> {!! $user->is_admin == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>' !!} </td></tr> --}}
                                        <tr><th> Активирован </th><td> {!! $user->is_active == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-ban"></i>' !!} </td></tr>
                                    </tbody>
                                </table>

                                @if($tasks->count() > 0)
                                    <h4>Задания в работе</h4>
                                    <table class="table">
                                        <tr>
                                            <th>Название</th>
                                            <th>Просмотр</th>
                                        </tr>
                                        <tbody>
                                        @foreach($tasks as $item)
                                    
                                            <tr>
                                                <td>{{ $item->task->name }}</td>
                                                <td>
                                                    @if(user_can("view_task"))
                                                        <a class="btn btn-info btn-sm" href="{{ url('/admin/tasks/' . $item->task->id) }}"><i class="fa fa-camera"></i> Просмотр</a>
                                                    @endif
                                                </td>
                                            </tr>
                                       
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>Нет заданий</p>
                                @endif
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection