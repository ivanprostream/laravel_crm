<div class="row">
    <div class="col-4">
        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
            <input class="form-control" name="name" type="text" id="name" value="{{ isset($user->name) ? $user->name : ''}}" placeholder="Ф.И.О">
            {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('division_id') ? 'has-error' : ''}}">
            <select class="form-control" name="division_id" id="division_id">
                <option value="">Выберите подразделение</option>
                @foreach($divisions as $item)
                    <option value="{{ $item->id }}" {{ isset($user->division_id) && $user->division_id == $item->id ? 'selected' : ''}}>{{ $item->name }}</option>
                @endforeach
            </select>
            {!! $errors->first('division_id', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
            <input class="form-control" name="password" type="password" id="password" value="{{ isset($user->password) ? $user->password : ''}}" placeholder="Пароль">
            {!! $errors->first('password', '<p class="text-danger">:message</p>') !!}
        </div>


        @if($formMode == 'create' || ($formMode == 'edit' && $user->is_admin == 0))
            <div class="form-group {{ $errors->has('is_active') ? 'has-error' : ''}}">
                <label for="is_active" class="control-label">
                    <input type="checkbox" name="is_active" id="is_active" value="1" class="minimal" {{ $formMode == 'create'?"checked":($user->is_active == 1?"checked":"") }}>
                    {{ 'Активированный / Заблокирован' }}
                </label>
                {!! $errors->first('is_active', '<p class="text-danger">:message</p>') !!}
            </div>
        @endif
        <div class="form-group">
            <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Обновить' : 'Добавить' }}">
        </div>

    </div>
    <div class="col-4">
        <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
            <input class="form-control" name="email" type="text" id="email" value="{{ isset($user->email) ? $user->email : ''}}" placeholder="Email">
            {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('position_title') ? 'has-error' : ''}}">
            <input class="form-control" name="position_title" type="text" id="position_title" value="{{ isset($user->position_title) ? $user->position_title : ''}}" placeholder="Должность">
            {!! $errors->first('position_title', '<p class="text-danger">:message</p>') !!}
        </div>

    </div>
    <div class="col-4">
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
            <input class="form-control" name="phone" type="text" id="phone" value="{{ isset($user->phone) ? $user->phone : ''}}" placeholder="Контактный телефон">
            {!! $errors->first('phone', '<p class="text-danger">:message</p>') !!}
        </div>

        <div class="form-group {{ $errors->has('image') ? 'has-error' : ''}}">
            <input class="form-control" name="image" type="file" id="image" >
            {!! $errors->first('image', '<p class="text-danger">:message</p>') !!}
            <p class="text-muted">Фото пользователя</p>
        </div>
        @if(isset($user->image) && !empty($user->image))
            <img src="{{ url('public/uploads/users/' . $user->image) }}" width="200" height="180"/>
        @endif
    </div>

    </div>
    
   
    
</div>