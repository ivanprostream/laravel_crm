<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($project->name) ? $project->name : old('name')}}" placeholder="Название проекта">
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('division_id') ? 'has-error' : ''}}">
    <select name="division_id" id="division_id" class="form-control">
    		<option value="">Выберите подразделение</option>
        @foreach(getDivisions() as $item)
            <option value="{{ $item->id }}" {{ isset($project->division_id) && $project->division_id == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
        @endforeach
    </select>
    {!! $errors->first('division_id', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <textarea class="form-control" name="description" type="text" id="description" placeholder="Описание" rows="4">{{ isset($project->description) ? $project->description : old('description')}}</textarea>
    {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
    <select name="status" id="status" class="form-control">
		<option value="">Выберите статус</option>
        <option value="1" {{ isset($project->status) && $project->status == 1 ? 'selected' : ''}}>Активный</option>
        <option value="2" {{ isset($project->status) && $project->status == 2 ? 'selected' : ''}}>Архивный</option>
    </select>
    {!! $errors->first('status', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('person') ? 'has-error' : ''}}">
    <input class="form-control" name="person" type="text" id="person" value="{{ isset($project->person) ? $project->person : old('person')}}" placeholder="Руководитель проекта">
    {!! $errors->first('person', '<p class="text-danger">:message</p>') !!}
</div>
 
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>