(function($) {

	var MediaChooser = function(element, options) {
		if (this === window) {
			return new MediaChooser(element, options);
		}

		var that = this;

		// Option defaults
		this.options = {

			// Limit for files to choose
			_limit: null,
			get limit() {

				// If no limit has been provided, let's just
				// use the 
				if (this._limit === null) {
					this._limit = parseInt(that.$element.data('limit'));

					if (isNaN(this._limit)) {
						this._limit = 0;
					}
				}

				return this._limit;
			},
			set limit(limit) {
				this._limit = limit;
			},

			// Identifier
			_identifier: null,
			get identifier() {

				// If no identifier has been provided, let's just
				// use the 
				if (this._identifier === null) {
					var val;
					if ( ! (val = that.$element.attr('id'))) {
						val = that.$element.selector;
					}
					this.identifier = val.replace(/[^a-zA-Z0-9_-]/g, '');
				}

				return this._identifier;
			},
			set identifier(identifier) {
				this._identifier = identifier;
			},

			// Under limit selector
			_underLimitSelector: null,
			get underLimitSelector() {
				if (this._underLimitSelector === null) {
					
					this._underLimitSelector = '#media-chooser-under-limit-'+that.options.identifier;
				}

				return this._underLimitSelector;
			},
			set underLimitSelector(underLimitSelector) {
				if (typeof underLimitSelector !== 'array') {
					$.error('Invalid allowed choose methods provided.');
				}

				this._underLimitSelector = underLimitSelector;
			},

			// Over limit selector
			_overLimitSelector: null,
			get overLimitSelector() {
				if (this._overLimitSelector === null) {
					
					this._overLimitSelector = '#media-chooser-over-limit-'+that.options.identifier;
				}

				return this._overLimitSelector;
			},
			set overLimitSelector(overLimitSelector) {
				if (typeof overLimitSelector !== 'array') {
					$.error('Invalid allowed choose methods provided.');
				}

				this._overLimitSelector = overLimitSelector;
			},

			// Plugin namespace for DOM devents
			namespace: 'mediachooser',

			// Choose method specific options
			methods : {

				// Upload specific options. Can be used by callbacks
				upload : {

					// Tab selector. By default, the modal window has
					// tabs inside it that we use to separate chooser
					// methods.
					_tabSelector: null,
					get tabSelector() {

						if (this._tabSelector === null) {
							this._tabSelector = '#media-chooser-upload-'+that.options.identifier;
						}

						return this._tabSelector;
					},
					set tabSelector(tabSelector) {
						this._tabSelector = tabSelector;
					},

					// The selector for the file upload DOM element.
					_fileuploadSelector: null,
					get fileuploadSelector() {

						if (this._fileuploadSelector === null) {

							// Selector differs because we use the same upload
							// form outside the media chooser to keep our code DRY
							this._fileuploadSelector = '#media-upload-'+that.options.identifier;
						}

						return this._fileuploadSelector;
					},
					set fileuploadSelector(fileuploadSelector) {
						this._fileuploadSelector = fileuploadSelector;
					},

					// Blueimp file upload configuration.
					fileupload: {

						// Maximum number of files
						_maxNumberOfFiles: null,
						get maxNumberOfFiles() {

							if (this._maxNumberOfFiles === null) {

								// Try grab the max number of files from the media chooser
								var limit;
								// this._maxNumberOfFiles = (limit = that.$element.data('limit')) ? limit : undefined;

								// You can upload as many files as you want, but only choose two.
								this._maxNumberOfFiles = undefined;
							}

							return this._maxNumberOfFiles;
						},
						set maxNumberOfFiles(maxNumberOfFiles) {
							this._maxNumberOfFiles = maxNumberOfFiles;
						},

						// Filetypes allowed
						_acceptFileTypes: null,
						get acceptFileTypes() {

							if (this._acceptFileTypes === null) {

								var mimes;

								if (mimes = that.$element.data('mimes').split(',')) {
									acceptFileTypes = '^('+mimes.join('|').replace('/', '\/')+')$';

									this._acceptFileTypes = new RegExp(acceptFileTypes, 'i');
								} else {
									this._acceptFileTypes = /.+$/i;
								}
							}

							return this._acceptFileTypes;
						},
						set acceptFileTypes(acceptFileTypes) {
							this._acceptFileTypes = acceptFileTypes;
						},

						// Maximum number of files
						_formData: null,
						get formData() {

							if (this._formData === null) {

								// Initialize form data
								this._formData = {};

								// Grab the CSRF value
								var $csrf = $('#media-upload-csrf-'+that.options.identifier);
								if ($csrf.length) {
									this._formData[$csrf.attr('name')] = $csrf.val();
								}
							}

							return this._formData;
						},
						set formData(formData) {
							this._formData = formData;
						},

						// // Maximum number of files
						// _maxNumberOfFiles: null,
						// get maxNumberOfFiles() {

						// 	if (this._maxNumberOfFiles === null) {
						// 		this._maxNumberOfFiles = (that.options.limit > 0) ? that.options.limit : undefined;
						// 	}

						// 	return this._maxNumberOfFiles;
						// },
						// set maxNumberOfFiles(maxNumberOfFiles) {
						// 	this._maxNumberOfFiles = maxNumberOfFiles;
						// },

						// The ID for the upload template
						_uploadTemplateId: null,
						get uploadTemplateId() {

							if (this._uploadTemplateId === null) {
								this._uploadTemplateId = 'media-upload-template-'+that.options.identifier;
							}

							return this._uploadTemplateId;
						},
						set uploadTemplateId(uploadTemplateId) {
							this._uploadTemplateId = uploadTemplateId;
						},

						// The ID for the download template
						_downloadTemplateId: null,
						get downloadTemplateId() {

							if (this._downloadTemplateId === null) {
								this._downloadTemplateId = 'media-download-template-'+that.options.identifier;
							}

							return this._downloadTemplateId;
						},
						set downloadTemplateId(downloadTemplateId) {
							this._downloadTemplateId = downloadTemplateId;
						},

						// The media extension for the fileupload plugin adds
						// a choose style
						_mediaChooseStyle: null,
						get mediaChooseStyle() {

							if (this._mediaChooseStyle === null) {
								this._mediaChooseStyle = 'checkbox';
							}

							return this._mediaChooseStyle;
						},
						set mediaChooseStyle(chooseStyle) {
							if ($.inArray(chooseStyle, ['checkbox', 'radio']) < 0) {
								return;
							}

							this._mediaChooseStyle = chooseStyle;
						},
					}
				},

				// Library specific options. Can be used by callbacks
				library : {
					
					// Tab selector. By default, the modal window has
					// tabs inside it that we use to separate chooser
					// methods.
					_tabSelector: null,
					get tabSelector() {

						if (this._tabSelector === null) {
							this._tabSelector = '#media-chooser-library-'+that.options.identifier;
						}

						return this._tabSelector;
					},
					set tabSelector(tabSelector) {
						this._tabSelector = tabSelector;
					},

					// Selector for the table which loads library items
					_tableSelector: null,
					get tableSelector() {

						if (this._tableSelector === null) {
							this._tableSelector = '#media-chooser-library-table-'+that.options.identifier;
						}

						return this._tableSelector;
					},
					set tableSelector(tableSelector) {
						this._tableSelector = tableSelector;
					},

					// URL for library data
					_libraryUrl: null,
					get libraryUrl() {

						if (this._libraryUrl === null) {
							this._libraryUrl = platform.url.admin('media');
						}

						return this._libraryUrl;
					},
					set libraryUrl(libraryUrl) {
						this._libraryUrl = libraryUrl;
					}
				},

				// When a new choose method is chosen, fire
				// the callback on that method
				changeCallback: function(method, options, mediaChooser) {

					// Change actions based on the method chosen
					switch (method) {

						// Upload new media
						case 'upload':

							// After upload tab is chosen
							var $fileupload = $(options.fileuploadSelector);
							if ( ! $fileupload.length) {
								$.error('No fileupload DOM object found.');
							}

							$fileupload.fileupload(options.fileupload);

							break;

						// Choose existing media from the library
						case 'library':

							// After media method is chosen
							if ( ! mediaChooser.$element.data('method.library.initialized')) {

								/**
								 * ---------------------------------------
								 *
								 * Start: Dirty paltform.table workaround.
								 *
								 * Temporary flag for whether the
								 * library table has been initialized
								 * or not. Only needed because of the
								 * limitations of platform.table as current.
								 *
								 * ---------------------------------------
								 */

								// Override the URL
								platform.table.options.url = options.libraryUrl + '?' + $.param({
									choose: that.options.limit
								});

								// Initialize Platform table
								platform.table.init(options.tableSelector, {});

								// Seeings though this is called at the time
								// that the modal appears, we can fetch the
								// table just now as well.
								platform.table.fetch();

								/*
								 * ---------------------------------------
								 *  End: Dirty paltform.table workaround.
								 * ---------------------------------------
								 */

								// Initialized the plugin
								mediaChooser.$element.data('method.library.initialized', true);
							}

							// // To avoid the changing lots, let's just empty it
							// // on load
							// $(options.tableSelector).find('tbody').html('');

							// // Seeings though this is called at the time
							// // that the modal appears, we can fetch the
							// // table just now as well.
							// platform.table.fetch();

							break;
					}

					// Trigger a DOM event for easy extra functionality
					that.$element.trigger(that.options.namespace+'methodchange', [method, options, mediaChooser]);
				}
			},

			// As well as specifying default methods, we can specify
			// the allowed methods.
			_allowedMethods: null,
			get allowedMethods() {
				if (this._allowedMethods === null) {
					this._allowedMethods = [];

					for (var i in this.methods) {
						if (typeof this.methods[i] === 'object') {
							this._allowedMethods.push(i);
						}
					}
				}

				return this._allowedMethods;
			},
			set allowedMethods(allowedMethods) {
				if (typeof allowedMethods !== 'array') {
					$.error('Invalid allowed choose methods provided.');
				}

				this._allowedMethods = allowedMethods;
			},

			// Modal configuration
			modal: {

				// The media chooser uses a modal window by default.
				// The selector for this modal window:
				_selector: null,
				get selector() {
					if (this._selector === null) {
						this._selector = '#media-chooser-modal-'+that.options.identifier;
					}

					return this._selector;
				},
				set selector(selector) {
					this._selector = selector;
				},

				// After modal window is shown
				shownCallback: function(methods, mediaChooser) { },

				// After a model window is hidden.
				hiddenCallback: function(methods, mediaChooser) {

					// Loop through all methods. We'll disable them.
					$.each(methods, function(index, method) {

						// Grab method options
						var options = mediaChooser.options.methods[method];

						// Switch based on method name
						switch (method) {

							case 'upload':

								var $fileupload = $(options.fileuploadSelector);

								// Check we have a fileupload element
								if ($fileupload.length) {

									// Destroy the file upload if it exists
									try {
										if ($fileupload.data('fileupload')) {
											$fileupload.fileupload('destroy');
										}
									} catch (e) {
										// Do nothing.
									}
								}

								break;

							case 'library':

								// There is currently no way to destroy a
								// platform table, so we just set a property
								// so it's initialized next time.
								mediaChooser.$element.data('method.library.initialized', false);

								// Grab table
								var $table = $(options.tableSelector);

								// Let's manually remove some DOM elements as well
								$table.find('#table-filters').html('');
								$table.find('tbody').html('');

								break;
						}
					});
				},
			},

			// The default link selector.
			_linkSelector: null,
			get linkSelector() {
				if (this._linkSelector === null) {
					this._linkSelector = '#media-chooser-link-'+that.options.identifier;
				}

				return this._linkSelector;
			},
			set linkSelector(linkSelector) {
				this._linkSelector = linkSelector;
			},

			// Selector for all tabs
			_tabsSelector: null,
			get tabsSelector() {
				if (this._tabsSelector === null) {
					this._tabsSelector = '#media-chooser-tabs-'+that.options.identifier;
				}

				return this._tabsSelector;
			},
			set tabsSelector(tabsSelector) {
				this._tabsSelector = tabsSelector;
			},

			// Selector for the default tab
			_defaultTabSelector: null,
			get defaultTabSelector() {
				if (this._defaultTabSelector === null) {
					this._defaultTabSelector = '[data-default-tab-'+that.options.identifier+']';
				}

				return this._defaultTabSelector;
			},
			set defaultTabSelector(defaultTabSelector) {
				this._defaultTabSelector = defaultTabSelector;
			},

			// All choosing related options
			choose: {

				// The selector to find all inputs which
				// contain the chosen options for the media
				// chooser. All inputs should have this so we
				// can capture their value when the chooser is
				// closed. This selector is of course relative
				// to each instance.
				inputSelector: '.media-chosen',

				// A button selector that we use to confirm our
				// choice.
				_buttonSelector: null,
				get buttonSelector() {
					if (this._buttonSelector === null) {
						this._buttonSelector = '#media-chooser-choose-'+that.options.identifier;
					}

					return this._buttonSelector;
				},
				set buttonSelector(buttonSelector) {
					this._buttonSelector = buttonSelector;
				},

				// Callback for when items are chosen.
				callback: function(items, mediaChooser) {
					return that.$element.trigger(that.options.namespace+'choose', [items, mediaChooser]);
				},
			}

		};

		// Override options
		$.extend(true, this.options, options);

		// Set some properties
		this.$element = $(element);

		// Validate options
		if (isNaN(parseInt(this.options.limit))) {
			$.error('Invalid limit option ['+this.options.limit+'] passed to $.mediaChooser');
		}

		// Add link
		this.$link = $(this.options.linkSelector);
		if ( ! this.$link.length) {
			$.error('Media chooser link selector ['+this.options.linkSelector+'] does not match any DOM objects.');
		}

		// Add modal
		this.$modal = $(this.options.modal.selector);
		if ( ! this.$modal.length) {
			$.error('Media chooser modal selector ['+this.options.modal.selector+'] does not match any DOM objects.');
		}

		this.$chooseBtn = $(this.options.choose.buttonSelector);

		if ( ! this.$chooseBtn.length) {
			$.error('Media chooser choose button selector ['+this.options.choose.buttonSelector+'] does not match any DOM objects.');
		}

		this.observeModal()
		    .observeMethods()
		    .observeChoosing();

		return this;
	};

	MediaChooser.prototype = {

		constructor: MediaChooser,

		observeModal: function() {
			var that = this,
			      ns = this.options.namespace;

			// After a modal is shown
			that.$modal.on('shown.'+ns, function(e) {

				// Grab the default tab
				var $tab = $(that.options.defaultTabSelector).first();

				// No default tab
				if ( ! $tab.length) {
					$.error('No default tab available for $.mediaChooser with identifier ['+that.options.identifier+']');
				}

				// Remove active class from parent, just in case
				$tab.parent('li').removeClass('active');

				// Show it
				$tab.tab('show');

				// Callback. Methods are driver based
				// so we don't know what they are.
				that.options.modal.shownCallback(that.options.allowedMethods, that);
			});

			// After a modal is hidden
			that.$modal.on('hidden.'+ns, function(e) {

				// Callback - pass through all methods so that they may
				// be deactivated by the user. Methods are driver based
				// so we don't know what they are.
				that.options.modal.hiddenCallback(that.options.allowedMethods, that);
			});

			// When the link is clicked, show the modal.
			that.$link.on('click.'+ns, function(e) {
				e.preventDefault();

				that.$modal.modal('show');
			});

			return this;
		},

		observeMethods: function() {
			var that = this,
			      ns = this.options.namespace;

			$(that.options.tabsSelector).on('shown.'+ns, function(e) {
				e.stopPropagation();

				// When a tab changes, the choose method changes.
				var method = $(e.target).data('method'),
				   methods = that.options.allowedMethods;

				// Validate method
				if (( ! method) || ($.inArray(method, methods) < 0)) {
					$.error('Invalid tab method provided ['+method+']. Must be either ['+methods.join(',')+']');
				}

				that.options.methods.changeCallback(method, that.options.methods[method], that);

			});

			return this;
		},

		observeChoosing: function() {
			var      that = this,
			           ns = this.options.namespace,
			inputSelector = that.$element.selector+' '+that.options.choose.inputSelector,
			  $underLimit = $(that.options.underLimitSelector),
			   $overLimit = $(that.options.overLimitSelector);

			$('body').on('change.'+ns, inputSelector, function(e) {
				e.stopPropagation();

				var $checked = $(inputSelector).filter(':checked');

				// No items checked?
				if ($checked.length === 0) {
					that.$chooseBtn.attr('disabled', 'disabled');

					// Show / hide validation
					$underLimit.removeClass('hide');
					$overLimit.addClass('hide');
				}

				// Too many items checked?
				else if ((that.options.limit > 0) && ($checked.length > that.options.limit)) {
					that.$chooseBtn.attr('disabled', 'disabled');

					// Show / hide validation
					$underLimit.addClass('hide');
					$overLimit.removeClass('hide');
				}

				// All good
				else {
					that.$chooseBtn.removeAttr('disabled');

					// Show / hide validation
					$underLimit.addClass('hide');
					$overLimit.addClass('hide');
				}

				// Enable / disable choose button
				// that.$chooseBtn[($(inputSelector).filter(':checked').length > 0) ? 'removeAttr']

				// Validate the number of items chosen
			});

			that.$chooseBtn.on('click.'+ns, function(e) {
				
				// Array of items to send
				var items = [],
				 $checked = $(inputSelector).filter(':checked');

				// Make sure we have some active items
				if ( ! $checked.length) {
					alert('nochecked');
					return;
				}

				$checked.each(function() {
					items.push($(this).data());
				});

				that.options.choose.callback(items, that);

				that.$modal.modal('hide');
			});
		}

	};

	$.fn.mediaChooser = function(options) {
		return new MediaChooser(this, options);
	}

})(jQuery);