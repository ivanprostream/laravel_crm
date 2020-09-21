@extends('layout.app')
 
@section('title', ' | Сообщения')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Почтовый ящик</h1>
            @if($unreadMessages)
                <small>{{$unreadMessages}} новых сообщений</small>
            @endif
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Сообщения</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
 
                <div class="col-md-12">
                    @include('includes.flash_message')
                </div>
     
                <div class="col-md-3">

                    @if(user_can('compose_email'))
                        <a href="{{ url('admin/mailbox-create') }}" class="btn btn-success pull-right btn-block">
                            <i class="fa fa-plus" aria-hidden="true"></i>
                        Написать</a>
                    @endif
                    <br>
                    @include('pages.mailbox.includes.folders_panel')
                </div>
                <!-- /.col -->
                <div class="col-md-9">

                    @if(!$messages->isEmpty())

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">{{ getMailBoxTypeName(Request::segment(3)) }}</h3>
    
                            <div class="card-tools">
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" placeholder="Поиск">
                                        <div class="input-group-append">
                                            <div class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                          <!-- /.card-tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">

                          <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
 
                                    @foreach($messages as $message)
                                        <tr data-mailbox-id="{{ $message->id }}" data-mailbox-flag-id="{{ $message->mailbox_flag_id }}" data-user-folder-id="{{ $message->mailbox_folder_id }}">
                                            <td>
                                                @if(Request::segment(3) != 'Trash')
                                                    <input type="checkbox" value="1" data-mailbox-id="{{ $message->id }}" data-mailbox-flag-id="{{ $message->mailbox_flag_id }}" class="check-message">
                                                @endif
                                            </td>
                                            <td class="mailbox-name"><a href="{{ url('admin/mailbox-show/' . $message->id) }}">{{ $message->sender->name }}</a></td>
                                            <td class="mailbox-subject">
                                                @if($message->is_unread == 1)
                                                    <b>{{ $message->subject }}</b>
                                                @else
                                                    {{ $message->subject }}
                                                @endif
                                            </td>
                                            <td class="mailbox-attachment">
                                                @if($message->attachments->count() > 0)
                                                    <i class="fa fa-paperclip"></i>
                                                @endif
                                            </td>
                                            <td class="mailbox-date">@if($message->time_sent) {{ Carbon\Carbon::parse($message->time_sent)->diffForHumans()}} @else {{ "not sent yet" }}  @endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                            </table>
                            <!-- /.table -->
                          </div>
                          <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    @include('pages.mailbox.includes.mailbox_controls')

                    @else
                        <div class="box-body">
                            <p>Нет сообщений</p>
                        </div>
                    @endif

                    


                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection
 
@section('scripts')
 
    <script src="{{ asset('public/theme/views/mailbox/functions.js') }}" type="text/javascript"></script>
 
    <script src="{{ asset('public/theme/views/mailbox/index.js') }}" type="text/javascript"></script>
 
@endsection