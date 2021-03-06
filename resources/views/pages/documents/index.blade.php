@extends('layout.app')
 
@section('title', ' | Список документов')
 
@section('content')
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Документы</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Документы</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                  <form method="GET" action="{{ url('/admin/documents') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 d-inline-block float-l" role="search">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Поиск по разделу..." value="{{ request('search') }}">
                            <span class="input-group-btn">
                                <button class="btn btn-secondary" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>

                    </form>

                    @if(user_can("create_document"))
                        <a href="{{ url('/admin/documents/create') }}" class="btn btn-success pull-right float-r" title="Добавить">
                            <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                        </a>
                    @endif

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </section>
 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
     
                            @include('includes.flash_message')
    
                            <br/>
                            <br/>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        @if(\Auth::user()->is_admin == 1)
                                            <th>#</th>
                                        @endif
                                        <th>Название</th>
                                        <th>Файл</th>
                                        <th>Дата создания</th>
                                        @if(\Auth::user()->is_admin == 1)
                                            <th>Создан</th>
                                        @endif
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $item)
                                            <tr>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->id }}</td>
                                                @endif
                                                <td>{{ $item->name }}</td>
                                                <td>
                                                    @if(user_can('view_document'))
                                                        @if(!empty($item->file)) <a href="{{ url('public/uploads/documents/' . $item->file) }}"> <i class="fa fa-download"></i> {{$item->file}}</a> 
                                                        @endif
                                                    @endif
                                                </td>
                                                <td>{{ $item->created_at }}</td>
                                                @if(\Auth::user()->is_admin == 1)
                                                    <td>{{ $item->createdBy->name }}</td>
                                                @endif
                                                <td>
     
                                                    @if(user_can('view_document'))
                                                        <a href="{{ url('/admin/documents/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                                                    @endif
     
                                                    @if(user_can('edit_document'))
                                                        <a href="{{ url('/admin/documents/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                                                    @endif
     
                                                    @if(user_can('delete_document'))
                                                        <form method="POST" action="{{ url('/admin/documents' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                            {{ method_field('DELETE') }}
                                                            {{ csrf_field() }}
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination-wrapper"> {!! $documents->appends(['search' => Request::get('search')])->render() !!} </div>
                            </div>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection