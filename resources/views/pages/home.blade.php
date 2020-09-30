@extends('layout.app')

@section('title', ' | Главная')

@section('content')
  
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Главная</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Главная</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-12">
            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Текущие задания</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->

              @if($tasks)
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>#</th>
                      <th>Название</th>
                      <th>Тип</th>
                      <th>Статус</th>
                      <th>Исполнители</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($tasks as $count=>$item)  
                      @if(1 == $item->task->status)
                      <tr>
                        <td>{{ $count }}</td>
                        <td>{{ $item->task->name }}</td>
                        <td><span class="badge badge-warning">{{ $item->task->type->name }}</span></td>
                        <td><span class="badge badge-success">{{ $item->task->getStatus->name }}</span></td>
                        <td>
                          @foreach($item->task->assignedUsers as $user)
                            {{ $user['name'] }}<br>
                          @endforeach
                        </td>
                        <td>
                          @if(user_can('view_task'))
                            <a href="{{ url('/admin/tasks/' . $item->task->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                          @endif

                          @if(user_can('update_task_status'))
                            <a href="{{ url('/admin/tasks/' . $item->task->id . '/update-status') }}" title="Обновить статус"><button class="btn btn-primary btn-sm"><i class="fa fa-star" aria-hidden="true"></i> Обновить статус</button></a>
                          @endif
                        </td>
                      </tr>
                      @endif
                      @endforeach
                    

                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              @endif
              <!-- /.card-body -->
              @if(user_can('list_tasks'))
                <div class="card-footer clearfix">
                  <a href="{{ url('admin/tasks') }}" class="btn btn-sm btn-secondary float-right">Все задания</a>
                </div>
              @endif
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>  
        </div>
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection