@extends('layout.app')
 
@section('title', ' | Календарь')
 
@section('styles')
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ url('theme/bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
    <style>
        .external-event {
            cursor: pointer !important;
        }
    </style>
@endsection
 
@section('content')
 
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Календарь</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Главная</a></li>
              <li class="breadcrumb-item active">Календарь</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    @if(\Auth::user()->is_admin == 1)
                     <div class="card">
                        <div class="card-body">
                            

                                <form method="POST" action="{{ url('/admin/calendar') }}" accept-charset="UTF-8" enctype="multipart/form-data">

                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="project_id" class="control-label">Поиск по пользователю</label>
                                        <select class="form-control" name="user_id" id="user_id">
                                            <option value="">Выберите пользователя</option>
                                            @foreach($users as $item)
                                                @if (Request::input('user_id') == $item->id)
                                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                                @else
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                     
                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="Показать">
                                    </div>

                                </form>

                           
                        </div>
                    </div>
                     @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h4 class="box-title">Задания</h4>
                                </div>
                                <div class="box-body">


                                    




                                    <!-- the events -->
                                    <div id="external-events">
                                        @if($countPending)
                                            <div class="external-event bg-light-blue">Незавершенные задачи ({{$countPending}})</div>
                                        @endif
             
                                        @if($countInProgress)
                                            <div class="external-event bg-yellow">Выполняемые задачи ({{$countInProgress}})</div>
                                        @endif
             
                                        @if($countFinished)
                                            <div class="external-event bg-green">Выполненные задачи ({{$countFinished}})</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
     
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-body p-0">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
 
    @include('pages.calendar.includes.event_modal')
@endsection
 
@section('scripts')
 
    <!-- fullCalendar -->
    <script src="{{ url('public/theme/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ url('public/theme/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
 
    <?php echo $events_js_script ?>
 
    <script type="text/javascript" src="{{ url('public/theme/views/calendar/fullcalendar.js') }}"></script>
 
@endsection