<div class="row">
    <div class="col-md-6">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <label for="name" class="control-label">{{ 'Название' }}</label>
            <input class="form-control" name="name" type="text" id="name" value="{{ isset($document->name) ? $document->name : ''}}" placeholder="Название">
            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>
    </div>
    <div class="col-md-6">
        
        <div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
            <label for="file" class="control-label">{{ 'Файл' }}</label>
            <input class="form-control" name="file" type="file" id="file">
            {!! $errors->first('file', '<p class="text-danger">:message</p>') !!}
        </div>
        @if(isset($document->file) && !empty($document->file))
            <a href="{{ url('uploads/documents/' . $document->file) }}"><i class="fa fa-download"></i> {{$document->file}}</a>
        @endif
    </div>
</div>
 
 
<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Создать' }}">
</div>
