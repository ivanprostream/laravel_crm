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
              <li class="breadcrumb-item"><a href="{{ url('/admin/roles') }}">Роли</a></li>
              <li class="breadcrumb-item active">Роли</li>
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
                            <a href="{{ url('/admin/roles') }}" title="Назад"><button class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Назад</button></a>
                            <br />
                            <br />
     
                            @if ($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
     
                            <form method="POST" action="{{ url('/admin/roles') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                {{ csrf_field() }}
     
                                @include ('pages.roles.form', ['formMode' => 'create'])
     
                            </form>
     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
 
    <script src="{{ url('public/theme/views/roles/form.js') }}" type="text/javascript"></script>
 
@endsection
