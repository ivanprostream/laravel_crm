@extends('layout.app')
 
@section('title', ' | Сообщения | Просмотр сообщения')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Просмотр сообщения</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/mailbox') }}">Сообщения</a></li>
              <li class="breadcrumb-item active">Просмотр сообщения</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-3">
                <a href="{{ url('admin/mailbox') }}" class="btn btn-secondary btn-block margin-bottom">Назад </a>
                <br>
 
                @include('pages.mailbox.includes.folders_panel')
            </div>
 
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Просмотр сообщения</h3>
                    </div>
 
                    @include('includes.flash_message')
 
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-read-info">
                            <h3>{{ $mailbox->subject }}</h3>
                            <h5>От: {{ $mailbox->sender->email }}
                                <span class="mailbox-read-time pull-right">{{ !empty($mailbox->time_sent)?date("d M. Y h:i A", strtotime($mailbox->time_sent)):"not sent yet" }}</span></h5>
                        </div>
 
                        <!-- /.mailbox-controls -->
                        <div class="mailbox-read-message">
                            {!! $mailbox->body !!}
                        </div>
                        <!-- /.mailbox-read-message -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
 
                        @include('pages.mailbox.includes.attachments', ['mailbox' => $mailbox])
 
                    </div>
                </div>
                <!-- /. box -->
 
                @if($mailbox->replies->count() > 0)
                    <h3>Ответы</h3>
                    @foreach($mailbox->replies as $reply)
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h3 class="card-title"><strong>From: </strong>{{ $reply->sender->name }}</h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="mailbox-read-info">
                                    <h3>{{ $reply->subject }}</h3>
                                    <h5>From: {{ $reply->sender->email }}
                                        <span class="mailbox-read-time pull-right">{{ !empty($reply->time_sent)?date("d M. Y h:i A", strtotime($reply->time_sent)):"not sent yet" }}</span></h5>
                                </div>
                                <div class="mailbox-read-message">
                                    {!! $reply->body !!}
                                </div>
                            </div>
                            <div class="box-footer">
                                @include('pages.mailbox.includes.attachments', ['mailbox' => $reply])
                            </div>
                        </div>
                    @endforeach
                @endif
 
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>
    </section>
@endsection