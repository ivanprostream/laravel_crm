@extends('layout.app')
 
@section('title', ' | Edit document')
 
@section('content')
 
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Редактирование</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/tasks') }}">Задания</a></li>
              <li class="breadcrumb-item active">Редактирование</li>
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
                            <a href="{{ url('/admin/tasks') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            <br />
                            <br />

     
                            <form method="POST" action="{{ url('/admin/tasks/' . $document->id. '/' . $task->id .'/document' ) }}" accept-charset="UTF-8" enctype="multipart/form-data">
         
                                {{ csrf_field() }}
     
                                <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                          <label for="name" class="control-label">{{ 'Название' }}</label>
                                          <input class="form-control" name="name" type="text" id="name" value="{{ isset($document->name) ? $document->name : ''}}" placeholder="Название">
                                          {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      
                                      <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
                                          <label for="file" class="control-label">{{ 'Файл' }}</label>
                                          <input class="form-control" name="file" type="file" id="file">
                                          {!! $errors->first('file', '<p class="text-danger">:message</p>') !!}
                                      </div>
                                      @if(isset($document->file) && !empty($document->file))
                                          <a href="{{ url('uploads/documents/' . $document->file) }}"><i class="fa fa-download"></i> {{$document->file}}</a>
                                      @endif
                                  </div>
                              </div>
                               
                               
                              <div class="form-group">
                                  <input class="btn btn-primary" type="submit" value="Обновить">
                              </div>

     
                            </form>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
 