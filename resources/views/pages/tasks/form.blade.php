<div class="row">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            <label for="name" class="control-label">{{ 'Название задания' }}</label>
                            <input class="form-control" name="name" type="text" id="name" value="{{ isset($task->name) ? $task->name : ''}}" placeholder="Название задания">
                            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group {{ $errors->has('project_id') ? 'has-error' : ''}}">
                            <label for="project_id" class="control-label">{{ 'Проект' }}</label>
                            <select class="form-control" name="project_id" id="project_id">
                                <option value="">Выберите проект</option>
                                @foreach(getDivisions() as $item)
                                    <optgroup label="{{ $item->name }}">
                                        @foreach(getProjectsByDivision($item->id) as $project)
                                            <option value="{{ $project->id }}" {{ isset($task->project_id) && $task->project_id == $project->id ? 'selected' : ''}}>{{ $project->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            {!! $errors->first('project_id', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('type_id') ? 'has-error' : ''}}">
                            <label for="type_id" class="control-label">{{ 'Тип задания' }}</label>
                            <select name="type_id" id="type_id" class="form-control">
                                @foreach($task_types as $type)
                                    <option value="{{ $type->id }}" {{ isset($task->type_id) && $task->type_id == $type->id ? 'selected' : ''}}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('type_id', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                            <label for="status" class="control-label">{{ 'Статус задания' }}</label>
                            <select name="status" id="status" class="form-control">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ isset($task->status) && $task->status == $status->id ? 'selected' : ''}}>{{ $status->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->has('priority') ? 'has-error' : ''}}">
                            <label for="priority" class="control-label">{{ 'Приоритет' }}</label>
                            <select class="form-control" name="priority" id="priority">
                                @foreach(array('Низкий', 'Нормальный', 'Высокий') as $value)
                                    <option value="{{ $value }}" {{ isset($task->priority) && $task->priority == $value ? 'selected' : ''}}>{{ $value }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('priority', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            <label for="description" class="control-label">{{ 'Описание' }}</label>
                            <textarea class="form-control textarea" name="description" type="text" id="description">{{ isset($task->description) ? $task->description : ''}}</textarea>
                            {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
                        </div>
                         
                    </div>
                  
                    <div class="col-md-12"><label for="assigned_users" class="control-label">{{ 'Исполнители' }}</label>
                    <div class="card card-primary card-outline card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-assigned" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="assigned_users-tab" data-toggle="pill" href="#custom-tabs-assigned_users" role="tab" aria-controls="custom-tabs-assigned_users" aria-selected="true">По пользователям</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="assigned_divisions-tab" data-toggle="pill" href="#custom-tabs-assigned_divisions" role="tab" aria-controls="custom-tabs-assigned_divisions" aria-selected="false">По подразделениям</a>
                              </li>
                            </ul>
                          </div>
                          <div class="card-body">
                            <div class="tab-content" id="custom-tabs-assignedContent">
                              <div class="tab-pane fade active show" id="custom-tabs-assigned_users" role="tabpanel" aria-labelledby="assigned_users-tab">
                                <div class="form-group {{ $errors->has('assigned_users') ? 'has-error' : ''}}">
                    
                                    <select name="assigned_users[]" id="assigned_users" class="form-control" multiple="multiple" data-placeholder="Выберите сотрудника(ов)" data-dropdown-css-class="select2-purple">
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ isset($selected_assigned_users) && in_array($user->id, $selected_assigned_users)?"selected":"" }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                              </div>
                              <div class="tab-pane fade" id="custom-tabs-assigned_divisions" role="tabpanel" aria-labelledby="assigned_divisions-tab">
                                <div class="form-group {{ $errors->has('assigned_users') ? 'has-error' : ''}}">
                                
                                <select name="assigned_divisions[]" id="assigned_divisions" class="form-control" multiple="multiple" data-placeholder="Выберите подразделения" data-dropdown-css-class="select2-purple">
                                    @foreach(getDivisions() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                              </div>
                            </div>
                          </div>
                          <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('start_date') ? 'has-error' : ''}}">
                            <label for="start_date" class="control-label">{{ 'Дата начала' }}</label>
                            <input class="form-control" name="start_date" type="text" id="start_date" value="{{ isset($task->start_date) ? $task->start_date : ''}}" >
                            {!! $errors->first('start_date', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group {{ $errors->has('end_date') ? 'has-error' : ''}}">
                            <label for="end_date" class="control-label">{{ 'Дата конца' }}</label>
                            <input class="form-control" name="end_date" type="text" id="end_date" value="{{ isset($task->end_date) ? $task->end_date : ''}}" >
                            {!! $errors->first('end_date', '<p class="text-danger">:message</p>') !!}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="documents" class="control-label">{{ 'Документы' }} <i class="fa fa-link"></i></label>
                            <select id="documents" name="documents[]" multiple="multiple" data-placeholder="Выберите документы" data-dropdown-css-class="select2-purple" class="form-control">
                                @foreach($documents as $document)
                                    <option value="{{ $document->id }}" {{ isset($selected_documents) && in_array($document->id, $selected_documents)?"selected":"" }}>{{ $document->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>      
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
 
<input type="hidden" id="getContactsAjaxUrl" value="{{ url('/admin/api/contacts/get-contacts-by-status') }}" />