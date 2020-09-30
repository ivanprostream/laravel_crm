@extends('layout.app')
 
@section('title', ' | Сообщения')

@section('styles')
    <!-- fullCalendar -->

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ url('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
 
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

                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="messages_table" class="table table-bordered table-striped dataTable dtr-inline">
                            <thead>
                                <tr>
                                    <th>Поль</th>
                                    <th>Тема сообщения</th>
                                    <th>Дата</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            @foreach($messages as $message)
                                <tr>
                                    <td class="mailbox-name">
                                        @if(Request::segment(3) == 'Sent')
                                        <a href="{{ url('admin/mailbox-show/' . $message->id) }}">To:</a>
                                            @foreach($message->receivers as $item)
                                                {{ $item->user->name }}</br>
                                            @endforeach
                                        @endif
                                        @if(Request::segment(3) != 'Sent')
                                            <a href="{{ url('admin/mailbox-show/' . $message->id) }}">{{ $message->sender->name }}</a>
                                        @endif
                                    </td>
                                    <td class="mailbox-subject">
                                        @if($message->is_unread == 1)
                                            <b>{{ $message->subject }}</b>
                                        @else
                                            {{ $message->subject }}
                                        @endif
                                    </td>
                                    <td class="mailbox-date">@if($message->time_sent) {{ Carbon\Carbon::parse($message->time_sent)->diffForHumans()}} @else {{ "not sent yet" }}  @endif</td>
                                    <td class="mailbox-attachment">
                                        @if($message->attachments->count() > 0)
                                            <i class="fa fa-paperclip"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if(Request::segment(3) == 'Inbox')
                                        <a class="btn btn-info btn-sm" href="{{ url('/admin/mailbox-reply/'.$message->id) }}">Ответить</a>
                                        @endif
                                        @if(Request::segment(3) != 'Trash')
                                        <form action="{{ url('admin/mailbox-trash-one') }}" method="POST" class="d-inline-block">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <input type="hidden" name="mailbox_id" value="{{ $message->id }}">
                                            <input type="hidden" name="user_mailbox_id" value="{{  $message->mailbox_folder_id }}">
                                            <input type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Удалить?')" value="Удалить">
                                        </form>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                            </table>

                          <!-- /.mail-box-messages -->
                        </div>
                        <!-- /.card-body -->
                    </div>
    
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

<script type="text/javascript" src="{{ url('public/theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $('#messages_table').DataTable({
       "paging": false,
       "searching": true,
       "responsive": true,
       "autoWidth": false,
       "ordering": true,
       "info": true,
       "bSort": true,
       "language": {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
        },
    });
</script>

@endsection