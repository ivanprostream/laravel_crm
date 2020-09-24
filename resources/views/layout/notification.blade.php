
@if(count(getTasksByLastDay()) > 0)
<section class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-danger">
          <div class="card-header">
            <h3 class="card-title">Горящие задания</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
            </div>
            <!-- /.card-tools -->
          </div>
          <!-- /.card-header -->
          <div class="card-body" style="display: block;">
            <table class="table">
              <thead>
              <tr>
                  <th>Название</th>
                  <th>Приоритет</th>
                  <th>Статус</th>
                  <th>Тип</th>
                  <th>Создано</th>
                  <th>Начало задания</th>
                  <th>Конец задания</th>
                  <th></th>
              </tr>
              </thead>
              <tbody>
                  @foreach(getTasksByLastDay() as $item)
                  <tr>
                      <td>{{ $item->name }}</td>
                      <td>{!! getStylePriority($item->priority) !!}</td>
                      <td>{!! getStyleStatus($item->status) !!}</td>
                      <td>{{ $item->type_name }}</td>
                      <td>{{ $item->user_name }}</td>
                      <td>{{ getNormalizeDate($item->start_date) }}</td>
                      <td>{{ getNormalizeDate($item->end_date) }}</td>
                      <td>
                        @if(user_can('view_task'))
                          <a href="{{ url('/admin/tasks/' . $item->id) }}" title="Просмотр"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> Просмотр</button></a>
                        @endif
                      </td>
                  </tr>
                  @endforeach
              </tbody>
          </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>
@endif