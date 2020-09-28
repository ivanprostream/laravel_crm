@extends('layout.app')
 
@section('title', ' | Просмотр')
 
@section('content')
    
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>{{ $task->name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
                  <li class="breadcrumb-item"><a href="{{ url('/admin/tasks') }}">Задания</a></li>
                  <li class="breadcrumb-item active">Просмотр</li>
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
 
                        <a href="{{ url('/admin/tasks') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
 
                        @if(user_can('edit_task'))
                            <a href="{{ url('/admin/tasks/' . $task->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                        @endif

                        @if(user_can('update_task_status'))
                            <a href="{{ url('/admin/tasks/' . $task->id . '/update-status') }}" title="Обновить статус"><button class="btn btn-primary btn-sm"><i class="fa fa-star" aria-hidden="true"></i> Обновить статус</button></a>
                        @endif
 
                        @if(user_can('delete_task'))
                            <form method="POST" action="{{ url('admin/tasks' . '/' . $task->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                            </form>
                        @endif
 
                    </div>
                </div>
            </div>

            <div class="col-md-6">

                <!-- DIRECT CHAT -->
                <div class="card direct-chat direct-chat-primary">
                  <div class="card-header">
                    <h3 class="card-title">Чат задания</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div id="chat-body" class="direct-chat-messages">


                      @foreach($task->messages as $item)
                        
                        @if(\Auth::user()->id == $item->user_id)
                            <!-- Message. Default to the left -->
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-left">{{ $item->user->name }}</span>
                                  <span class="direct-chat-timestamp float-right">{{ $item->created_at }}</span>
                                </div>
                                <!-- /.direct-chat-infos -->
                                @if(\Auth::user()->image != null)
                                    <img class="direct-chat-img" src="{{ url('public/uploads/users/' . \Auth::user()->image) }}" alt="User Image">
                                @else
                                    <img class="direct-chat-img" src="{{ url('public/theme/dist/img/default-150x150.png') }}" alt="User Image">
                                @endif
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                 {{ $item->description }}
                                 
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->
                        @else
                            <!-- Message to the right -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                  <span class="direct-chat-name float-right">{{ $item->user->name }}</span>
                                  <span class="direct-chat-timestamp float-left">{{ $item->created_at }}</span>
                                </div>
                                <!-- /.direct-chat-infos -->
                                @if($item->user->image != null)
                                    <img class="direct-chat-img" src="{{ url('public/uploads/users/' . $item->user->image) }}" alt="User Image">
                                @else
                                    <img class="direct-chat-img" src="{{ url('public/theme/dist/img/image_placeholder.png') }}" alt="User Image">
                                @endif
                                <!-- /.direct-chat-img -->
                                <div class="direct-chat-text">
                                  {{ $item->description }}
                                </div>
                                <!-- /.direct-chat-text -->
                            </div>
                            <!-- /.direct-chat-msg -->
                        @endif
                        

                      @endforeach

                      

                      

                    </div>
                    <!--/.direct-chat-messages-->


                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <form method="POST" action="{{ url('/admin/tasks/'. $task->id. '/chat') }}" accept-charset="UTF-8">
                      {{ csrf_field() }}
                      <div class="input-group">
                        <input type="text" name="message" placeholder=" Сообщение ..." class="form-control">
                        <span class="input-group-append">
                            <input type="submit" name="add" class="btn btn-primary" value="Отправить">
                            <input type="submit" name="read" class="btn btn-secondary" value="Прочитано">
                        </span>
                      </div>
                      {!! $errors->first('message', '<p class="text-danger">:message</p>') !!}
                    </form>
                  </div>
                  <!-- /.card-footer-->
                </div>
                <!--/.direct-chat -->
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Описание задания</h4>
                            <table class="table">
                                <tbody>
                                    @if(\Auth::user()->is_admin == 1)
                                        <tr>
                                            <th>ID</th><td>{{ $task->id }}</td>
                                        </tr>
                                    @endif
                                    <tr><th> Название </th><td> {{ $task->name }} </td></tr>
                                    <tr><th> Приоритет </th><td> {{ $task->priority }} </td></tr>
                                    <tr><th> Статус </th><td> {{ $task->getStatus->name }} </td></tr>
                                    <tr>
                                        <th>Тип</th><td> {{ $task->type->name }}</td>
                                    </tr>
                                    <tr><th>Начало задания</th> <td>{{ $task->start_date }}</td></tr>
                                    <tr><th>Конец задания</th> <td>{{ $task->end_date }}</td></tr>
                                    <tr>
                                        <th>Описание</th> <td>{!! $task->description !!}</td>
                                    </tr>
                                    <tr><th> Создан </th><td>{{ $task->createdBy->name }}</td></tr>
                                    @if(isset($task->modifiedBy->name))
                                    <tr><th> Изменен </th><td>{{ isset($task->modifiedBy->name)?$task->modifiedBy->name:"" }}</td></tr>
                                    @endif
                                    <tr><th> Исполнители </th>
                
                                    <td>@foreach($selected_assigned_users as $user)
                                        <p>{{ $user }}</p>
                                    @endforeach</td>
                                    </tr>
                                    <tr><th> Дата создания </th><td>{{ $task->created_at }}</td></tr>
                                    <tr><th> Дата изменения </th><td>{{ $task->updated_at }}</td></tr>
                                    @if($task->documents->count() > 0)
                                        <tr>
                                            <th>Документы </th> 
                                            <td>
                                                <ul>
                                                @foreach($task->documents as $document) 
                      
                                                    <li>
                                                        <a href="{{ url('public/uploads/documents/' . $document->file) }}">{{ $document->name }}</a>
                                                        @if(user_can('edit_document_task'))
                                                        <a href="{{ url('/admin/tasks/' . $document->id . '/' . $task->id . '/document') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                                        @endif
                                                    </li>

                                                @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

  <script type="text/javascript" src="{{ url('public/theme/views/tasks/chat.js') }}"></script>

@endsection
