@extends('layout.app')
 
@section('title', ' | Mailbox | Reply message')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Почтовый ящик</h1>
            @if($unreadMessages)
                <small>{{$unreadMessages}} новых сообщения</small>
            @endif
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/mailbox') }}"> Mailbox</a></li>
              <li class="breadcrumb-item active">Написать ответ</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <a href="{{ url('admin/mailbox') }}" class="btn btn-secondary btn-block margin-bottom">Назад </a>
                <br>
 
                @include('pages.mailbox.includes.folders_panel')
            </div>
            <div class="col-md-9">
                <form method="post" action="{{ url('admin/mailbox-reply/' . $mailbox->id) }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h3 class="card-title">Ответить {{ $mailbox->sender->name }}</h3>
                      </div>
                      <!-- /.card-header -->
                    <div class="card-body">
   
 
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
 
                    <!-- /.box-header -->
                        <div class="box-body">
                            <div class="form-group">
                                <textarea id="compose-textarea" class="form-control" name="body" style="height: 300px">
                                    {{ old("body")!=null?old("body"):"" }}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <div class="btn btn-default btn-file">
                                    <i class="fa fa-paperclip"></i> Прикрепить
                                    <input type="file" name="attachments[]" multiple>
                                </div>
                                <p class="help-block">Max. {{ (int)(ini_get('upload_max_filesize')) }}M</p>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-reply"></i> Ответить</button>
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /. box -->
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection
 
@section('scripts')
 
    <script>
        $(function () {
            //Add text editor
            $('#compose-textarea').summernote({
              height: 200,
            })
 
        });
    </script>
 
@endsection