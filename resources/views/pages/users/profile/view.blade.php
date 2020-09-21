@extends('layout.app')
 
@section('title', ' | Мой профайл')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Мой профайл</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Мой профайл</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
 
                        @include('includes.flash_message')
 
                        @if(user_can('edit_profile'))
                            <a href="{{ url('/admin/my-profile/edit') }}" title="Edit profile"><button class="btn btn-primary float-r"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
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
 
                                <tr><th> Ф.И.О. </th><td> {{ $user->name }} </td>
                                </tr><tr><th> Email </th><td> {{ $user->email }} </td></tr>
                                <tr><th> Должность </th><td> {{ $user->position_title }} </td></tr>
                                <tr><th> Контактный телефон </th><td> {{ $user->phone }} </td></tr>
 
                                </tbody>
                            </table>
 
                            <hr/>
 
                            <h4>Задания в работе</h4>
                            @if($tasks->count() > 0)
                                <table class="table">
                                    <tr>
                                        <th>Название</th>
                                        <th>Просмотр</th>
                                    </tr>
                                    <tbody>
                                    @foreach($tasks as $item)
                                        @if($item->task->status == 1)
                                        <tr>
                                            <td>{{ $item->task->name }}</td>
                                            <td>
                                                @if(user_can("view_task"))
                                                    <a class="btn btn-info btn-sm" href="{{ url('/admin/tasks/' . $item->task->id) }}"><i class="fa fa-camera"></i> Просмотр</a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endif
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
    </section>
@endsection