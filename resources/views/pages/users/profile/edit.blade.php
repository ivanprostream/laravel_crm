@extends('layout.app')
 
@section('title', ' | Редактирование')
 
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
              <li class="breadcrumb-item"><a href="{{ url('/admin/my-profile') }}">Мой профайл</a></li>
              <li class="breadcrumb-item active">Редактирование</li>
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
 
                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
 
                        <form method="POST" action="{{ url('/admin/my-profile/edit/') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}
 
                            <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                                <label for="name" class="control-label">{{ 'Name' }}</label>
                                <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" >
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                <label for="email" class="control-label">{{ 'Email' }}</label>
                                <input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" >
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                <label for="password" class="control-label">{{ 'Password' }}</label>
                                <input class="form-control" name="password" type="password" id="password" value="" >
                                {!! $errors->first('password', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('position_title') ? 'has-error' : ''}}">
                                <label for="position_title" class="control-label">{{ 'Position Title' }}</label>
                                <input class="form-control" name="position_title" type="text" id="position_title" value="{{ isset($user->position_title) ? $user->position_title : ''}}" >
                                {!! $errors->first('position_title', '<p class="help-block">:message</p>') !!}
                            </div>
                            <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                                <label for="phone" class="control-label">{{ 'Phone' }}</label>
                                <input class="form-control" name="phone" type="text" id="phone" value="{{ isset($user->phone) ? $user->phone : ''}}" >
                                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                            </div>
 
                            @if(!empty($user->image))
                                <img src="{{ url('public/uploads/users/' . $user->image) }}" width="200" height="180"/>
                            @endif
 
                            <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
                                <label for="image" class="control-label">{{ 'Image' }}</label>
                                <input class="form-control" name="image" type="file" id="image" >
                                {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                            </div>

                            @if(\Auth::user()->is_admin == 1)
                                <div class="form-group">
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="email_notice-1" name="email_notice" value="1" {{ (isset($user->email_notice) && $user->email_notice == 1)  ? 'checked' : ''}}>
                                      <label for="email_notice-1" class="custom-control-label">Отправлять уведомления на email</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                      <input class="custom-control-input" type="radio" id="email_notice-2" name="email_notice" value="0" {{ (isset($user->email_notice) && $user->email_notice == 0)  ? 'checked' : ''}}>
                                      <label for="email_notice-2" class="custom-control-label">Не отправлять уведомления на email</label>
                                    </div>
                                </div>
                            @endif
 
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" value="Обновить">
                            </div>
 
                        </form>
 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection