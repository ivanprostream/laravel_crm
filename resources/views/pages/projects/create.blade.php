@extends('layout.app')

@section('title', ' | Создать роль')

@section('content')
    
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Создание</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item"><a href="{{ url('/admin/projects') }}">Проекты</a></li>
              <li class="breadcrumb-item active">Создание</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Основное</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i></button>
                </div>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ url('/admin/projects') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    @include ('pages.projects.form', ['formMode' => 'create'])

                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
      </div>
    </section>
@endsection

