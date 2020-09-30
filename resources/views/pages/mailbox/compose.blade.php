@extends('layout.app')
 
@section('title', ' | Почтовый ящик | Написать сообщение')
 
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
              <li class="breadcrumb-item"><a href="{{ url('/admin/mailbox') }}"> Почтовый ящик</a></li>
              <li class="breadcrumb-item active">Сообщения</li>
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
                <form method="POST" action="{{ url('admin/mailbox-create') }}" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="card card-primary card-outline">
                      <div class="card-header">
                        <h3 class="card-title">Написать сообщение</h3>
                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <div class="form-group">
                            <?php $selected_receivers = old('receiver_id') ?>
                            <select name="receiver_id[]" id="receiver_id" multiple class="form-control">
                              <option value="all">Всем сотрудникам</option>
                              @foreach($users as $user)
                                  <option value="{{ $user->id }}" {{ $selected_receivers!=null && in_array($user->id, $selected_receivers)?"selected":"" }}>{{ $user->name }}</option>
                              @endforeach
                            </select>
                            {!! $errors->first('receiver_id', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                          <input class="form-control" name="subject" placeholder="Тема сообщения:" value="{{ old("subject")!=null?old("subject"):"" }}">
                          {!! $errors->first('subject', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                            <textarea id="compose-textarea" name="body" class="form-control" style="height: 300px">
                                {{ old("body")!=null?old("body"):"" }}
                            </textarea>
                            {!! $errors->first('body', '<p class="text-danger">:message</p>') !!}
                        </div>
                        <div class="form-group">
                          <div class="btn btn-default btn-file">
                            <i class="fas fa-paperclip"></i> Прикрепить
                            <input type="file" name="attachments[]" multiple>
                          </div>
                          <p class="help-block">Max. {{ (int)(ini_get('upload_max_filesize')) }}M</p>
                        </div>
                      </div>
                      <!-- /.card-body -->
                      <div class="card-footer">
                        <div class="float-right">
                          <button type="submit" name="submit" value="2" class="btn btn-default"><i class="fas fa-pencil-alt"></i> Черновик</button>
                          <button type="submit" name="submit" value="1" class="btn btn-primary"><i class="far fa-envelope"></i> Отправить</button>
                        </div>
                      </div>
                      <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </div>  
    </section>
@endsection
 
@section('scripts')
 
    <script>
        $(function () {
            //Add text editor
            $('#compose-textarea').summernote({
              height: 200,
            })
 
            $("#receiver_id").select2({placeholder: "To:"});
        });
    </script>
 
@endsection