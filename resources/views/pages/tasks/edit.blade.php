@extends('layout.app')
 
@section('title', ' | Edit task')
 
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
     
                            <form method="POST" action="{{ url('/admin/tasks/' . $task->id) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
     
                                @include ('pages.tasks.form', ['formMode' => 'edit'])
     
                            </form>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

  <script type="text/javascript" src="{{ url('public/theme/views/tasks/form.js') }}"></script>

@endsection