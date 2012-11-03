<form action="{{ URL::to_admin('users/groups/edit/' . $group['id']) }}" id="edit-form" class="form-horizontal" method="POST" accept-char="UTF-8">
    <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

    <fieldset>
        <legend>Updating {{ $group['name'] }}</legend>

        <!-- Group Name -->
        <div class="control-group">
            <label class="control-label" for="name">{{ Lang::line('platform/users::form.groups.edit.name') }}</label>
            <div class="controls">
                <div class="input-append">
                    <input type="text" id="name" name="name" value="{{ Input::old('name', $group['name']); }}" required>
                    <span class="add-on"><i class="icon-group"></i></span>
                </div>
                <span class="help-block">{{ Lang::line('platform/users::form.groups.edit.name_help') }}</span>
            </div>
        </div>

    </fieldset>

    <div class="form-actions">
        <a class="btn btn-large" href="{{ URL::to_admin('users/groups') }}">{{ Lang::line('button.cancel') }}</a>
        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
    </div>
</form>
