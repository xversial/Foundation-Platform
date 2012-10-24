@layout('templates.default')

<!-- Page Title -->
@section('title')
    {{ Lang::line('themes::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('themes','themes::css/themes.less', 'style') }}

<!-- Queue Scripts -->
{{ Theme::queue_asset('themes','themes::js/themes.js', 'jquery') }}

<!-- Page Content -->
@section('content')
<section id="themes">

    <!-- Tertiary Navigation & Actions -->
    <header class="navbar">
        <div class="navbar-inner">
            <div class="container">
                <!-- .btn-navbar is used as the toggle for collapsed navbar content -->
                <a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
                    <span class="icon-reorder"></span>
                </a>

                <a class="brand" href="#">{{ $theme['name'] }} by {{ $theme['author'] }}</a>
            </div>
        </div>
    </header>

    <hr>

    <div class="quaternary page">
        @if (count($theme['options']))
        <form action="{{ URL::to_admin('themes/edit/' . $type . '/' . $theme['theme']) }}" id="theme-options" class="form-horizontal" method="POST" accept-char="UTF-8">

            <input type="hidden" name="{{ Session::csrf_token }}" value="{{ Session::token() }}">

            @foreach ($theme['options'] as $id => $option)
            <fieldset>
                <div class="control-group">
                    <legend>{{ $option['text'] }}</legend>
                                
                    @foreach ($option['styles'] as $style => $value)
                    <label class="control-label" for="{{ $id }}_{{ $style }}">{{ $style }}</label>
                    
                    <div class="controls">
                        <input type="text" id="{{ $id }}_{{ $style }}" name="options[{{ $id }}][styles][{{ $style }}]" value="{{ $value }}">
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @endforeach

            <div class="form-actions">
                <a class="btn btn-large" href="{{ URL::to_admin('themes/' . $type) }}">{{ Lang::line('button.cancel') }}</a>
                <button class="btn btn-large btn-primary" type="submit" name="save" id="save" value="1">{{ Lang::line('button.update') }}</button>
                @if ($theme['changed'])
                <button class="btn btn-large btn-warning" type="submit" name="reset_changes" id="reset_changes" value="1">{{ Lang::line('button.reset_changes') }}</button>
                @endif
            </div>
        </form>
        @else
        <div class="unavailable">
            {{ Lang::line('themes::messages.no_options') }}
        </div>
        @endif
    </div>
</section>
@endsection