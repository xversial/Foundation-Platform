@layout('templates.default')

<!-- Page Title -->
@section('title')
	{{ Lang::line('platform/menus::general.title') }}
@endsection

<!-- Queue Styles -->
{{ Theme::queue_asset('menus', 'platform/menus::css/menus.less', 'style') }}

<!-- Styles -->
@section ('styles')
@endsection

<!-- Queue Scripts -->
{{ Theme::queue_asset('jquery-helpers', 'js/vendor/platform/helpers.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-tab', 'js/bootstrap/tab.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-toggle', 'js/bootstrap/toggle.js', 'jquery') }}
{{ Theme::queue_asset('bootstrap-button', 'js/bootstrap/button.js', 'jquery') }}
{{ Theme::queue_asset('jquery-ui', 'js/vendor/jquery/ui-1.8.18.min.js', 'jquery') }}
{{ Theme::queue_asset('jquery-nestedsortable', 'js/vendor/platform/nestedsortable-1.3.5.js', 'jquery') }}
{{ Theme::queue_asset('tempo', 'js/vendor/tempojs/tempo-1.8.min.js') }}
{{ Theme::queue_asset('jquery-nestysortable', 'js/vendor/platform/nestysortable-1.0.js', 'jquery') }}
{{ Theme::queue_asset('menussortable', 'platform/menus::js/menussortable-1.0.js', 'jquery') }}
{{ Theme::queue_asset('validate', 'js/vendor/platform/validate.js', 'jquery') }}

<!-- Scripts -->
@section('scripts')
<script>

	$(document).ready(function() {

		// Menu sortable plugin
		$('#menu').menuSortable({

			slugs: {
				// An array of slugs persisted to the
				// database already. We use to make sure
				// our slugs are unique and the user doesn't
				// get an error when saving.
				persisted: {{ json_encode($persisted_slugs) }},
			},

			types: {

				// This is the value of the child type that is
				// a static child. Static children are required and
				// cannot be removed.
				staticValue: {{ Platform\Menus\Menu::TYPE_STATIC }},

				// Callback fired whenever a menu type (other than
				// the default, static) is chosen. The value is passed
				// through the callback.
				chooseCallback: function(value, menuSortable) {
					var ns = menuSortable.options.namespace;

					// Do different custom actions based on the value
					// chosen
					switch (value) {
						case '{{ Platform\Menus\Menu::TYPE_PAGE }}':

							// And the name DOM object
							var $name       = $(menuSortable.options.nestySortable.fields.name.newSelector),
							    $pageSelect = $(menuSortable.options.nestySortable.fields.page_id.newSelector);

							// A function to update the menu
							function prefillNewChild(pageName) {

								// Let's prefill the name and slugs.
								$name.val(pageName);

								// Let's make menu sortable update the slug by triggering
								// a blur
								$name.trigger('blur.'+ns);
							}

							// When the page select changes, we'll
							// update the name properties of the
							// new child.
							$pageSelect.on('change.'+ns, function() {
								prefillNewChild($(this).find('option[value="'+$(this).val()+'"]').text());
							});

							// And, let's trigger the initial change
							$pageSelect.trigger('change.'+ns);

							break;
					}
				}
			},

			// Define Nesty Sortable dependency for the menu sortable.
			nestySortable: {

				/**
				 * An object containing all the fields for the
				 * Nesty Sortable. Each key in the object represents
				 * the field's slug. Each field has a unique slug.
				 * Each value in the object is an object containing
				 * specifications for the field:
				 *
				 *   - newSelector: This is the selector string (or jQuery object)
				 *                  representing the DOM object for a each new sortable
				 *                  object.
				 *
				 * <code>
				 *		{
				 *			'my_field_slug' : {
				 *				newSelector : '.new-item-my-field'
				 *			}
				 *		}
				 * </code>
				 */
				fields : {

					// ------------------------
					// Required fields for menu
					// ------------------------

					'name' : {
						newSelector: '#new-child-name',
						itemSelector: '.child-name'
					},

					'slug' : {
						newSelector: '#new-child-slug',
						itemSelector: '.child-slug'
					},

					'type' : {
						newSelector: '#new-child-type',
						itemSelector: '.child-type',
					},

					// ------------------------
					// Optional fields for menu
					// ------------------------

					'page_id' : {
						newSelector: '#new-child-page-id',
						itemSelector: '.child-page-id',
					},

					'uri' : {
						newSelector: '#new-child-uri',
						itemSelector: '.child-uri'
					},

					'secure' : {
						newSelector: '#new-child-secure',
						itemSelector: '.child-secure'
					},

					'visibility' : {
						newSelector: '#new-child-visibility',
						itemSelector: '.child-visibility'
					},

					'target' : {
						newSelector: '#new-child-target',
						itemSelector: '.child-target'
					},

					'class' : {
						newSelector: '#new-child-class',
						itemSelector: '.child-class'
					}
				},

				// The ID of the last item added. Used so we fill
				// new templates with an ID that won't clash with existing
				// items.
				lastItemId: {{ $last_child_id }}
			}
		})
	});
</script>
@endsection

@section('content')
<section id="menus-edit">

	<!-- Tertiary Navigation & Actions -->
	<header class="navbar">
		<div class="navbar-inner">
			<div class="container">

			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target="#tertiary-navigation">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			<a class="brand" href="#">{{ Lang::line('platform/menus::general.' . $page_type . '.title') }}</a>

			<!-- Everything you want hidden at 940px or less, place within here -->
			<div id="tertiary-navigation" class="nav-collapse">
				@widget('platform/menus::menus.nav', 2, 1, 'nav nav-pills', ADMIN)
			</div>

			</div>
		</div>
	</header>

	<hr>

	<div class="quaternary page">

		<form method="POST" method="POST" accept-char="UTF-8" autocomplete="off" id="menu">
			{{ Form::token() }}

			<fieldset class="form-horizontal">

				<legend>{{ Lang::line('platform/menus::form.legend') }}</legend>

				<div class="control-group">
					<label class="control-label" for="menu-name">
						{{ Lang::line('platform/menus::form.root.name') }}
					</label>
					<div class="controls">
						<input type="text" name="name" id="menu-name" value="{{ array_get($menu, 'name') }}" {{ (array_key_exists('user_editable', $menu) and ( ! array_get($menu, 'user_editable'))) ? 'disabled' : 'required'}}>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="menu-slug">
						{{ Lang::line('platform/menus::form.root.slug') }}
					</label>
					<div class="controls">
						<input type="text" name="slug" id="menu-slug" value="{{ array_get($menu, 'slug') }}"  {{ (array_key_exists('user_editable', $menu) and ( ! array_get($menu, 'user_editable'))) ? 'disabled' : 'required'}}>
					</div>
				</div>

			</fieldset>

			<div class="row-fluid">
				<div class="span3" id="menu-new-child">
					<fieldset>
						<legend>{{ Lang::line('platform/menus::form.create.child.legend') }}</legend>

						<!-- Item Name -->
						<div class="control-group">
							<input type="text" id="new-child-name" class="input-block-level" value="" placeholder="{{ Lang::line('platform/menus::form.child.name') }}" required>
						</div>

						<!-- Slug -->
						<div class="control-group">
							<input type="text" id="new-child-slug" class="input-block-level" value="" placeholder="{{ Lang::line('platform/menus::form.child.slug') }}" required>
						</div>

						<label>{{ Lang::line('platform/menus::form.child.type.title') }}</label>

						<select id="new-child-type" class="input-block-level">
							<option value="{{ Platform\Menus\Menu::TYPE_STATIC }}" selected>{{ Lang::line('platform/menus::form.child.type.static') }}</option>
							@if (count($pages) > 0)
								<option value="{{ Platform\Menus\Menu::TYPE_PAGE }}">{{ Lang::line('platform/menus::form.child.type.page') }}</option>
							@endif
						</select>

						<div data-new-child-type="{{ Platform\Menus\Menu::TYPE_STATIC }}" class="show">

							<!-- URI -->
							<div class="control-group">
								<input type="text" id="new-child-uri" class="input-block-level" value="" placeholder="{{ Lang::line('platform/menus::form.child.uri') }}">
							</div>

						</div>

						@if (count($pages) > 0)
							<div data-new-child-type="{{ Platform\Menus\Menu::TYPE_PAGE }}">

								<div class="control-group">
									<select id="new-child-page-id" class="input-block-level">
										@foreach ($pages as $page)
											<option value="{{ $page['id'] }}">{{ $page['name'] }}</option>
										@endforeach
									</select>
								</div>

							</div>
						@endif

						<!-- Secure -->
						<div class="control-group">
							<label class="checkbox">
								<input type="checkbox" value="1" id="new-child-secure" class="checkbox">
								{{ Lang::line('platform/menus::form.child.secure') }}
							</label>
						</div>

						<!-- Visibility -->
						<div class="control-group">
							<label for="new-child-visibility">{{ Lang::line('platform/menus::form.child.visibility.title') }}</label>
							<select id="new-child-visibility" class="input-block-level">
								<option value="{{ Platform\Menus\Menu::VISIBILITY_ALWAYS }}" selected>{{ Lang::line('platform/menus::form.child.visibility.always') }}</option>
								<option value="{{ Platform\Menus\Menu::VISIBILITY_LOGGED_IN }}">{{ Lang::line('platform/menus::form.child.visibility.logged_in') }}</option>
								<option value="{{ Platform\Menus\Menu::VISIBILITY_LOGGED_OUT }}">{{ Lang::line('platform/menus::form.child.visibility.logged_out') }}</option>
								<option value="{{ Platform\Menus\Menu::VISIBILITY_ADMIN }}">{{ Lang::line('platform/menus::form.child.visibility.admin') }}</option>
							</select>
						</div>

						<!-- Target -->
						<div class="control-group">
							<label>{{ Lang::line('platform/menus::form.child.target.title') }}</label>
							<select id="new-child-target" class="input-block-level">
								<option value="{{ Platform\Menus\Menu::TARGET_SELF }}" selected>{{ Lang::line('platform/menus::form.child.target.self') }}</option>
								<option value="{{ Platform\Menus\Menu::TARGET_BLANK }}">{{ Lang::line('platform/menus::form.child.target.blank') }}</option>
								<option value="{{ Platform\Menus\Menu::TARGET_PARENT }}">{{ Lang::line('platform/menus::form.child.target.parent') }}</option>
								<option value="{{ Platform\Menus\Menu::TARGET_TOP }}">{{ Lang::line('platform/menus::form.child.target.top') }}</option>
							</select>
						</div>

						<!-- CSS class -->
						<div class="control-group">
							<label for="new-child-class">{{ Lang::line('platform/menus::form.child.class') }}</label>
							<input type="text" id="new-child-class" class="input-block-level" value="" placeholder="{{ Lang::line('platform/menus::form.child.class') }}">
						</div>

						<div class="form-actions">
							<button type="button" class="btn btn-primary children-add-new">
								{{ Lang::line('platform/menus::button.add_child') }}
							</button>
						</div>

					</fieldset>

				</div>
				<!-- /end - menu-new-child -->

				<div class="span9">

					<ol class="menu-children">
						@if (isset($menu['children']))
							@foreach ($menu['children'] as $child)
								@render('platform/menus::edit.child', array('child' => $child, 'pages' => $pages))
							@endforeach
						@endif
					</ol>

					<div class="new-child-template-container hide">
						<ul class="new-child-template">
							@render('platform/menus::edit.child', array('child' => array(), 'pages' => $pages, 'template' => true))
						</ul>
					</div>

				</div>
			</div>

			<div class="form-actions">
				<button type="submit" class="btn btn-primary btn-save-menu" data-loading-text="{{ Lang::line('button.loading') }}" data-complete-text="{{ Lang::line('button.saved') }}">
					{{ Lang::line('button.'.(($menu_slug) ? 'update' : 'create')) }}
				</button>

				{{ HTML::link_to_secure(ADMIN.'/menus', Lang::line('button.cancel'), array('class' => 'btn')) }}
			</div>

		</form>

	</div>

</section>

@endsection
