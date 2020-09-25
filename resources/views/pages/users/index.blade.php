@extends('layout.app')
 
@section('title', ' | Список пользователей')

@section('styles')
    <!-- fullCalendar -->

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ url('theme/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ url('theme/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
 
@section('content')

    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Пользователи</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Пользователи</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <a href="{{ url('/admin/users/create') }}" class="btn btn-success pull-right float-r" title="Add New user">
                            <i class="fa fa-plus" aria-hidden="true"></i> Добавить
                        </a>
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

                            <table id="user_table" class="table table-bordered table-striped dataTable dtr-inline">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ф.И.О.</th>
                                        <th>Подразделение</th>
                                        <th>Специальность</th>
                                        @if(\Auth::user()->is_admin == 1)
                                        <th>Админ</th>
                                        <th>Активный / Заблокирован</th>
                                        <th>Роль</th>
                                        <th></th>
                                        @endif
                                    </tr>
                                </thead>
                              <tbody>

                              @foreach($users as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}<br><small>Тел: {{ $item->phone }}</small></td>
                                        <td>{{ $item->division['name'] }}</td>
                                        <td>{{ $item->position_title }}</td>
                                        @if(\Auth::user()->is_admin == 1)
                                        <td>{!! $item->is_admin == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-times"></i>' !!}</td>
                                        <td>{!! $item->is_active == 1? '<i class="fa fa-check"></i>':'<i class="fa fa-ban"></i>' !!}</td>
                                        <td>@if(isset($item->roles[0])) <span class="label label-success">{{ $item->roles[0]->name }}</span> @endif</td>
                                        @endif
                                        <td>
                                            
                                            @if(user_can('view_user'))
                                            <a href="{{ url('/admin/users/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Задания</button></a>
                                            @endif

                                            @if(\Auth::user()->is_admin == 1)
                                            <a href="{{ url('/admin/users/' . $item->id . '/edit') }}" title="Редактировать"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Редактировать</button></a>

                                            <a href="{{ url('/admin/users/role/' . $item->id) }}" title="Роль"><button class="btn bg-purple btn-sm"><i class="fa fa-user" aria-hidden="true"></i> Роль</button></a>
                                            @if($item->is_admin != 1)
                                                <form method="POST" action="{{ url('/admin/users' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                    {{ method_field('DELETE') }}
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Удалить" onclick="return confirm('Удалить?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Удалить</button>
                                                </form>
                                            @endif
                                            @endif
                                        </td>
                                        
                                    </tr>
                                @endforeach
     
                              </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')


<script type="text/javascript" src="{{ url('public/theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script type="text/javascript">
    $('#user_table').DataTable({
       "paging": false,
       "searching": true,
       "responsive": true,
       "autoWidth": false,
       "ordering": true,
       "info": true,
       "bSort": true,
       "language": {
        "url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Russian.json"
        },
    });
</script>



@endsection




