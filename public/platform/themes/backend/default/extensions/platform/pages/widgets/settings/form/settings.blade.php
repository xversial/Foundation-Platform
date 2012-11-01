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