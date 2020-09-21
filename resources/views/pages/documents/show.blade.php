@extends('layout.app')
 
@section('title', ' | Просмотр')
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $document->name }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/documents') }}"> Документы</a></li>
              <li class="breadcrumb-item active">Просмотр</li>
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
 
                        <a href="{{ url('/admin/documents') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
 
                        @if(user_can('edit_document'))
                            <a href="{{ url('/admin/documents/' . $document->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>
                        @endif
 
                        @if(user_can('delete_document'))
                            <form method="POST" action="{{ url('admin/documents' . '/' . $document->id) }}" accept-charset="UTF-8" style="display:inline">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                            </form>
                        @endif
                        <br/>
                        <br/>
 
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    @if(\Auth::user()->is_admin == 1)
                                        <tr>
                                            <th>ID</th><td>{{ $document->id }}</td>
                                        </tr>
                                    @endif
                                    <tr><th> Название </th><td> {{ $document->name }} </td></tr>
                                    <tr><th> Файл </th><td> @if(!empty($document->file)) <a href="{{ url('public/uploads/documents/' . $document->file) }}"> <i class="fa fa-download"></i> {{$document->file}}</a> @endif </td></tr>
                                    
                                    @if(\Auth::user()->is_admin == 1)
                                        <tr><th> Документ создан </th><td>{{ $document->createdBy->name }}</td></tr>
                                        <tr><th> Документ обновлен </th><td>{{ isset($document->modifiedBy->name)?$document->modifiedBy->name:"" }}</td></tr>
                                    @endif
 
                                    
                                    <tr><th> Дата создания </th><td>{{ $document->created_at }}</td></tr>
                                    <tr><th> Дата изменения </th><td>{{ $document->updated_at }}</td></tr>
 
                                </tbody>
                            </table>
                        </div>
 
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection