@extends('layout.app')
 
@section('title', ' | Update task status')
 
@section('content')
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Обновление статуса</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/tasks') }}">Задания</a></li>
              <li class="breadcrumb-item active">Обновление статуса</li>
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
     
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
     
                            <form method="POST" action="{{ url('/admin/tasks/' . $task->id . '/update-status') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
     
                                {{ method_field("put") }}
     
                                <div class="form-group {{ $errors->has('assigned_user_id') ? 'has-error' : ''}}">
                                    <label for="status" class="control-label">{{ 'Статус' }}</label>
                                    <select name="status" id="status" class="form-control">
                                        @foreach($statuses as $status)
                                            @if($status->id != $task->status)
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
     
                                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
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