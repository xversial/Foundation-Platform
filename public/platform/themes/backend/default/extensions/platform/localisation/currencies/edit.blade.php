@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('platform/localisation::currencies/general.title') }}
@endsection

<!-- Page Content -->
@section('content')
<section id="currencies">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="{{ URL::to_admin('localisation/currencies') }}">{{ Lang::line('platform/localisation::currencies/general.title') }}</a>

                <!-- Everything you want hidden at 940px or less, place within here -->
                <div id="tertiary-navigation" class="nav-collapse">
                    @widget('platform/menus::menus.nav', 2, 1, 'nav pull-right', ADMIN)
                </div>
            </div>
        </div>
    </header>

    <div class="quaternary page">
        <form action="{{ URL::to_admin('localisation/currencies/edit/' . $currency['slug']) }}" id="currency-edit-form" class="form-horizontal" method="POST" accept-char="UTF-8">
            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            <fieldset>
                <legend>{{ Lang::line('platform/localisation::currencies/general.description.edit', array('currency' => $currency['name'])) }}</legend>

                <div class="control-group">
                    <label class="control-label" for="name">{{ Lang::line('platform/localisation::currencies/form.name') }}</label>
                    <div class="controls">
                        <input type="text" name="name" id="name" value="{{ Input::old('name', $currency['name']); }}" required />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.name_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="code">{{ Lang::line('platform/localisation::currencies/form.code') }}</label>
                    <div class="controls">
                        <input type="text" name="code" id="code" value="{{ Input::old('code', $currency['code']); }}" required="required" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.code_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="rate">{{ Lang::line('platform/localisation::currencies/form.rate') }}</label>
                    <div class="controls">
                        <input type="text" name="rate" id="rate" value="{{ Input::old('rate', $currency['rate']); }}" required="required" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.rate_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="sign">{{ Lang::line('platform/localisation::currencies/form.sign') }}</label>
                    <div class="controls">
                        <input type="text" name="sign" id="sign" value="{{ Input::old('sign', $currency['sign']); }}" required="required" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.sign_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="after_price">{{ Lang::line('platform/localisation::currencies/form.after_price') }}</label>
                    <div class="controls">
                        <input type="checkbox" name="after_price" id="after_price" value="1"{{ ( Input::old('after_price', $currency['after_price']) ? ' checked' : '' ) }} />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.after_price_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="ths_sign">{{ Lang::line('platform/localisation::currencies/form.ths_sign') }}</label>
                    <div class="controls">
                        <input type="text" name="ths_sign" id="ths_sign" value="{{ Input::old('ths_sign', $currency['ths_sign']); }}" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.ths_sign_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="decimal_sign">{{ Lang::line('platform/localisation::currencies/form.decimal_sign') }}</label>
                    <div class="controls">
                        <input type="text" name="decimal_sign" id="decimal_sign" value="{{ Input::old('decimal_sign', $currency['decimal_sign']); }}" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.decimal_sign_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="decimals">{{ Lang::line('platform/localisation::currencies/form.decimals') }}</label>
                    <div class="controls">
                        <input type="text" name="decimals" id="decimals" value="{{ Input::old('decimals', $currency['decimals']); }}" />
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.decimals_help') }}</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">{{ Lang::line('platform/localisation::currencies/form.status') }}</label>
                    <div class="controls">
                        {{ Form::select('status', general_statuses(), $currency['status'], array('required')); }}
                        <span class="help-block">{{ Lang::line('platform/localisation::currencies/form.status_help') }}</span>
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('localisation/currencies') }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.update') }}</button>
                @if ( ! $currency['default'])
                <a class="btn btn-large btn-danger" href="{{ URL::to_admin('localisation/currencies/delete/' . $currency['slug']) }}">{{ Lang::line('button.delete') }}</a>
                @endif
            </div>
        </form>
    </div>
</section>
@endsection