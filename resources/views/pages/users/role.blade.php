@extends('layout.app')
 
@section('title', ' | Выбор роли')
 
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>{{ $user->name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
                  <li class="breadcrumb-item"><a href="{{ url('/admin/users') }}"> Пользователи</a></li>
                  <li class="breadcrumb-item active">Выбор роли</li>
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
                            <a href="{{ url('/admin/users') }}" title="Back"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            <br />
                            <br />
                            <form method="POST" action="{{ url('/admin/users/role/' . $user->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
     
                                <div class="form-group {{ $errors->has('role_id') ? 'has-error' : ''}}">
                                    <label for="role_id" class="control-label">{{ 'Роль' }}</label>
     
                                    <select name="role_id" id="role_id" class="form-control">
                                        <option value="">Выберите роль</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" {{ isset($user->roles[0]) && $role->id == $user->roles[0]->id?"selected":"" }}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
     
                                    {!! $errors->first('role_id', '<p class="help-block">:message</p>') !!}
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