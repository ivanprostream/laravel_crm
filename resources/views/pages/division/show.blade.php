@extends('layout.app')
 
@section('title', ' | Просмотр')
 
@section('content')
    
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1>{{ $division->name }}</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
                  <li class="breadcrumb-item"><a href="{{ url('/admin/divisions') }}">Подразделения</a></li>
                  <li class="breadcrumb-item active">Просмотр</li>
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
     
                            <a href="{{ url('/admin/divisions') }}" title="Back"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            <a href="{{ url('/admin/divisions/' . $division->id . '/edit') }}" title="Edit role"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактирование</button></a>
     
                            <form method="POST" action="{{ url('admin/divisions' . '/' . $division->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete role" onclick="return confirm('Confirm delete?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удаление</button>
                            </form>
                            <br/>
                            <br/>
     
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>ID</th><td>{{ $division->id }}</td>
                                        </tr>
                                        <tr><th> Название </th><td> {{ $division->name }} </td></tr>
                                        <tr>
                                            <th>Руководитель подразделения</th>
                                            <td> {{ $division->person_name }} </td>
                                        </tr>
                                        <tr>
                                            <th>Контактный телефон руководителя</th>
                                            <td> {{ $division->person_phone }} </td>
                                        </tr>
                                        <tr>
                                            <th>Дополнительная информация</th>
                                            <td> {{ $division->description }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection