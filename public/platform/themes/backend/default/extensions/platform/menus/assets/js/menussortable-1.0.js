(function($) {

	var MenuSortable = function(element, options) {
		if (this === window) {
			return new MenuSortable(element, options);
		}

		if ( ! $().nestySortable) {
			$.error('$.menuSortable requires $.nestySortable');
		}

		var that = this;

		that.options = {

			// Namespace for the plugin for registering
			// dom events
			namespace: 'menusortable',

			// Selector for control groups that wrap inputs
			controlGroupSelector : '.control-group',

			// Menu name
			rootNameSelector : '#menu-name',

			// Slug options
			slugs: {

				// An array of slugs persisted to the
				// database already. We use to make sure
				// our slugs are unique and the user doesn't
				// get an error when saving.
				persisted: [],

				rootSelector : '#menu-slug',

				// Root value
				_root: null,
				get root() {
					if (this._root === null) {
						var value = $(this.rootSelector).val();
						this._root = value;
					}

					return this._root;
				},
				set root(value) {
					this._root = value;
				},

				// New selector
				get newSelector() {
					if (this._newSelector === null) {

						var selector = null;

						if (selector = that.options.nestySortable.fields.slug.newSelector) {
							this._newSelector = selector;
						} else {
							this._newSelector = '#new-child-slug';
						}
					}

					return this._newSelector;
				},
				set newSelector(value) {
					this._newSelector = value;
				},
				_newSelector : null,

				// Separator
				separator    : '-'
			},

			// Child types
			types: {

				// This is the value of the child type that is
				// a static child. Static children are required and
				// cannot be removed.
				staticValue: 0,

				// This is the attribute used to describe
				// the container that holds the options for
				// each type. When the type select is changed,
				// The element who's {below attribute} matches
				// the value of that select will be shown, and
				// other ones will be hidden.
				newContainerAttribute: 'data-new-child-type',

				// Callback fired whenever a menu type (other than
				// the default, static) is chosen. The value is passed
				// through the callback.
				chooseCallback: function(value, menuSortable) { }
			},

			// Children
			children: {
				toggleSelector: '.child-toggle-details',
			},

			// Nesty sortable default settings
			nestySortable: {

				// Namespace for the plugin for registering
				// dom events
				namespace: 'menusortablenestysortable',

				// The selector for the sortable list,
				// used to cache the sortable list property
				sortableSelector    : '.menu-children',
				itemSelector        : '.child',
				itemDetailsSelector : '.child-details',
				itemRemoveSelector  : '.child-remove',
				itemAddSelector     : '.children-add-new',

				// Invalid field callback - must return true for valid
				// field or false for invalid field.
				invalidFieldCallback : function(slug, field, value) {
					$(field.newSelector).closest('.control-group').addClass('error');
				},

				// Callback for after an item is added
				afterAddCallback: function(item) {

					// Trigger a change on tye menu type select. The rest is taken care of.
					$(that.options.nestySortable.fields.type.newSelector).trigger('change.'+that.options.namespace);

				},

				// This is the selector for the new item's template.
				// This container should be hidden at all times as we
				// clone the HTML inside of this, apply the template and
				// then attach that to the end of the list.
				template : {
					containerSelector : '.new-child-template-container',
					selector          : '.new-child-template'
				},

				// The input name for the items
				// hierarchy that's posted to
				// the server.
				hierarchyInputName: 'children_hierarchy'
			}
		}

		$.extend(true, that.options, options);

		that.$element = element;

		return this.setupNestySortable()
		           .validateSlugs()
		           .observeTypes()
		           .checkUris()
		           .toggleChildren();
	}

	MenuSortable.prototype = {

		setupNestySortable: function() {
			var that = this,
			      ns = this.options.namespace;

			that.$element.nestySortable(that.options.nestySortable);

			return this;
		},

		validateSlugs: function() {
			var that  = this,
			      ns  = this.options.namespace,
			separator = this.options.slugs.separator;

			function slugPrepend(slug) {
				if (typeof slug === 'undefined') {
					slug = that.options.slugs.root;
				}

				if (slug) {
					return slug+separator;
				}

				return null;
			}

			function slugify(str, separator) {
				if (typeof separator === 'undefined') {
					separator = '-';
				}

				str = str.replace(/^\s+|\s+$/g, ''); // trim
				str = str.toLowerCase();

				// remove accents, swap ñ for n, etc
				var from = "ĺěščřžýťňďàáäâèéëêìíïîòóöôùůúüûñç·/_,:;";
				var to   = "lescrzytndaaaaeeeeiiiioooouuuuunc------";
				for (var i=0, l=from.length ; i<l ; i++) {
					str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
				}

				return str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
				          .replace(/\s+/g, separator) // collapse whitespace and replace by _
				          .replace(/-+/g, separator) // collapse dashes
				          .replace(new RegExp(separator+'+$'), '') // Trim separator from start
				          .replace(new RegExp('^'+separator+'+'), ''); // Trim separator from end
			}

			// Slug update events
			that.$element.bind('root_slug_update.'+ns, function(event, value) {

				if (typeof value === 'undefined') {
					value = $(that.options.rootNameSelector).val();
				}

				if (value) {
					var slug;
					if (slug = slugify(value, separator)) {
						$(that.options.slugs.rootSelector).val(slug);
						$(that.options.slugs.newSelector).val(slugPrepend(slug));
						that.options.slugs.root = slug;
					}
				}
			});

			that.$element.bind('new_slug_update.'+ns, function(event, value) {

				if (typeof value === 'undefined') {
					value = $(that.options.nestySortable.fields.name.newSelector).val();
				}

				if (value) {
					var slug, prepend;
					if ((slug = slugify(value)) && (prepend = slugPrepend())) {
						var value = prepend+slug,
						     $dom = $(that.options.slugs.newSelector);
						$dom.val(value);

						// Trigger a validation of the new slug
						that.$element.trigger('new_slug_validate.'+ns, [$dom, value]);
					}
				}
			});
			that.$element.bind('new_uri_update.'+ns, function(event, value) {

				if (typeof value === 'undefined') {
					value = $(that.options.nestySortable.fields.name.newSelector).val();
				}

				if (value) {
					var slug,
					    uriSeparator = '/';
					if (slug = slugify(value, uriSeparator)) {
						$(that.options.nestySortable.fields.uri.newSelector).val(slug)
						    .trigger('blur')
					}
				}

			});
			that.$element.bind('new_slug_validate.'+ns, function(event, dom, value) {
				if (typeof dom === 'undefined') {
					dom = $(that.options.slugs.newSelector);
				}
				if (typeof value === 'undefined') {
					value = dom.val();
				}

				// Add / remove validation error
				if (($.inArray(value, that.options.slugs.persisted) > -1)) {
					dom.addClass('error')
					    .closest(that.options.controlGroupSelector).addClass('error');
				} else {
					dom.removeClass('error')
					    .closest(that.options.controlGroupSelector).removeClass('error');
				}

			});

			// When the person changes the menu slug
			$(that.options.rootNameSelector).on('blur', function() {
				that.$element.trigger('root_slug_update.'+ns);
			});

			// Lastly, on load, trigger an update event
			that.$element.trigger('root_slug_update.'+ns);

			// New child names
			$(that.options.nestySortable.fields.name.newSelector).on('blur.'+ns, function() {
				var value = $(this).val();
				that.$element.trigger('new_slug_update.'+ns, [value])
				             .trigger('new_uri_update.'+ns, [value]);
			});

			// When the person blurs on a slug
			$(that.options.slugs.newSelector).on('blur', function() {
				that.$element.trigger('new_slug_validate.'+ns, [$(this), $(this).val()]);
			});

			return this;
		},

		observeTypes: function() {
			var that = this,
			      ns = this.options.namespace,
			    attr = that.options.types.newContainerAttribute;

			$(that.options.nestySortable.fields.type.newSelector).on('change.'+ns, function() {

				// Find the target container
				var val = $(this).val();
				var $target = $('['+attr+'="'+val+'"]');

				if ( ! $target.length) {
					$.error('No new child type container found for type {'+val+'}')
				}

				// Hide all other type containers and remove their
				// validation attributes
				$('['+attr+']').not($target).each(function() {
					$(this).find(':input').attr('novalidate', 'novalidate');
					$(this).removeClass('show');
				});

				// Show our container and add the validation back
				// in
				$target.addClass('show')
				       .find(':input').removeAttr('novalidate');

				// Call the callback only if we're on a custom
				// menu item type
				if (val != that.options.types.staticValue) {
					that.options.types.chooseCallback(val, that);
				}
			});

			return this;
		},

		checkUris: function() {
			var that = this,
			      ns = this.options.namespace;

			// URIs are not always required as some menu types
			// only deal with pages.
			if (typeof that.options.nestySortable.fields.uri === 'undefined') {
				return this;
			}

			function isFullUrl(url) {
				return /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(url);
			}
			function isSecureUrl(url) {
				return /https:\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/.test(url);
			}

			// Check new children
			var $secure = $(that.options.nestySortable.fields.secure.newSelector);
			if ($secure.length) {
				$(that.options.nestySortable.fields.uri.newSelector).on('blur.'+ns, function(e) {
					var value = $(this).val();

					if (isFullUrl(value)) {
						$secure.attr('disabled', 'disabled')
						       [(isSecureUrl(value)) ? 'attr' : 'removeAttr']('checked', 'checked');
					} else {
						$secure.removeAttr('disabled')
						       .removeAttr('checked');
					}
				});
			}

			// Existing
			$('body').on('blur.'+ns, that.options.nestySortable.fields.uri.itemSelector, function() {
				var $child = $(this).closest(that.options.nestySortable.itemSelector),
				   $secure = $child.find(that.options.nestySortable.fields.secure.itemSelector),
				     value = $(this).val();

				if ($secure.length) {
					if (isFullUrl(value)) {
						$secure.attr('disabled', 'disabled')
						       [(isSecureUrl(value)) ? 'attr' : 'removeAttr']('checked', 'checked');
					} else {
						$secure.removeAttr('disabled')
						       .removeAttr('checked');
					}
				}
			});

			return this;
		},

		toggleChildren: function() {
			var that = this,
			      ns = this.options.namespace;

			// Live toggle
			$('body').on('click.'+ns, that.options.children.toggleSelector, function(e) {
				$(this).closest(that.options.nestySortable.itemSelector).find(that.options.nestySortable.itemDetailsSelector).toggleClass('show');
			});

			return this;
		}
	}


	// The actual jquery plugin
	$.fn.menuSortable = function(options) {
		return new MenuSortable(this, options);
	}

})(jQuery);
