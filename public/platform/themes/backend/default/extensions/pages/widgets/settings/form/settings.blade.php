<form method="POST" accept-char="UTF-8" autocomplete="off" id="pages_settings_form">
	{{ Form::token() }}

	<input type="hidden" name="extension" value="pages">

	<fieldset>
		<div>
			<label for="page">Default Page:</label>
			{{ Form::select('default:page', $pages, $page, array('id' => 'page')) }}
			<span class="help"></span>
		</div>

		<div>
			<label for="template">Default Template:</label>
			{{ Form::select('default:template', $templates, $template, array('id' => 'template')) }}
			<span class="help"></span>
		</div>
    </fieldset>

    <hr>

    <div class="actions">
        <button class="btn btn-large btn-primary" type="submit">{{ Lang::line('button.update') }}</button>
    </div>

</form>