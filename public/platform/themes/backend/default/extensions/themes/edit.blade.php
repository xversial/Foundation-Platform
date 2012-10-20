@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('themes::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('themes','themes::css/themes.less', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('themes','themes::js/themes.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
@endsection

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
		<div class="row-fluid">
			<div class="span12">
				@if (count($theme['options']))
					{{ Form::open(null, 'POST', array('id' => 'theme-options', 'class' => 'form-horizontal')) }}

						{{ Form::token() }}

							@foreach ($theme['options'] as $id => $option)
							<fieldset>
								<legend>{{ $option['text'] }}</legend>
								@foreach ($option['styles'] as $style => $value)
									<label>{{ $style }}</label>
									<input type="text" name="options[{{$id}}][styles][{{$style}}]" value="{{ $value }}">
								@endforeach
							</fieldset>
							@endforeach

						<div class="form-actions">
				            <button class="btn btn-large btn-primary" type="submit">
				            	{{ Lang::line('button.update') }}
				            </button>
				            <a class="btn btn-large" href="{{ URL::to_secure(ADMIN.'/themes/'.$type) }}">{{ Lang::line('button.cancel') }}</a>
				        </div>

					{{ Form::close() }}

				@else

				<div class="unavailable">
					{{ Lang::line('themes::messages.no_options') }}
				</div>

				@endif

			</div>
		</div>
	</div>

</section>
@endsection
