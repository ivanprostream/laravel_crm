@extends('layout.app')
 
@section('title', ' | Назначение')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Назначение</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/tasks') }}">Задания</a></li>
              <li class="breadcrumb-item active">Назначение</li>
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
     
     
                            <form method="POST" action="{{ url('/admin/tasks/' . $task->id . '/assign') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
     
                                {{ method_field("put") }}
     
                                <div class="form-group {{ $errors->has('assigned_user_id') ? 'has-error' : ''}}">
                                    <label for="assigned_user_id" class="control-label">{{ 'Назначен' }}</label>
                                    <select name="assigned_user_id" id="assigned_user_id" class="form-control">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
     
                                    {!! $errors->first('assigned_user_id', '<p class="help-block">:message</p>') !!}
                                </div>
     
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Назначить">
                                </div>
     
                            </form>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection