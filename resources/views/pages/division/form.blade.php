<div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
    <input class="form-control" name="name" type="text" id="name" value="{{ isset($division->name) ? $division->name : ''}}" placeholder="Название">
    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('person_name') ? 'has-error' : ''}}">
    <input class="form-control" name="person_name" type="text" id="person_name" value="{{ isset($division->person_name) ? $division->person_name : ''}}" placeholder="Руководитель подразделения">
    {!! $errors->first('person_name', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('person_phone') ? 'has-error' : ''}}">
    <input class="form-control" name="person_phone" type="text" id="person_phone" value="{{ isset($division->person_phone) ? $division->person_phone : ''}}" placeholder="Телефон руководителя подразделения">
    {!! $errors->first('person_phone', '<p class="text-danger">:message</p>') !!}
</div>

<div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
    <textarea class="form-control" name="description" type="text" id="description" placeholder="Дополнительная информация">{{ isset($division->description) ? $division->description : ''}}</textarea>
    {!! $errors->first('description', '<p class="text-danger">:message</p>') !!}
</div>
 
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>