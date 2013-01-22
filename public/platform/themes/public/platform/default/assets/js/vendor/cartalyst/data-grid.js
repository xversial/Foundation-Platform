(function($) {

	/**
	 * DataGrid constructor.
	 *
	 * @return void
	 */
	var DataGrid = function(element, options) {

		// Just double check me we're running
		// the function as an object constructor
		// and not in the global namespace.
		if (this === window) {
			return new DataGrid(element, options);
		}

		if (typeof Tempo === 'undefined') {
			$.error('$.dataGrid requires TempoJS v2.0.0 or later to run.');
		}

		// We'll now define the default options the
		// data grid will have.
		this.options = {

			// The source is required for every data grid.
			// It must be a full URI to the resource which
			// returns the correct JSON for the data grid
			source: undefined,

			// Here we can specify some options we would
			// like to customize how our pagination works.
			// Pagination in this DataGrid is dynamic, it
			// will attempt to divide the results up to
			// match the requested pages, however not letting
			// the results slip below the minimum results
			// per page. Adjust at will.
			pagination: {
				requestedPages: 10,
				minimumPerPage: 10
			},

			// Options used for initializing TempoJS
			tempoOptions: {
				var_braces : '\\[\\[\\]\\]',
				tag_braces : '\\[\\?\\?\\]'
			},
		}

		// Merge the options passed through the jQuery
		// plugin
		$.extend(true, this.options, options);

		// Now we have our options setup, we'll begin setting
		// some instance properties on our object
		this.$element       = element;
		this.source         = this.$element.data('source') || this.options.source;
		this.templates      = {};
		this.filters        = [];
		this.appliedFilters = [];
		this.results        = [];
		this.pagination     = {
			page: 1,
			navigation: []
		};

		// Our results DOM object must be found
		// first before we attempt to move on as
		// other methods utiize properties in it.
		this.findResultsObject();

		// Great, it's now time to setup our filters. This will
		// inspect our results table to find all applicable HTML
		// entities. We'll cache our filter data on this object
		// for later use
		this.setupFilters();

		// We'll now prepare our templates which registers
		// the various compoenents using TempoJS
		this.prepareTemplates();

		// We will now render our initial filters for the
		// data grid
		this.renderFilters();

		// We will observe applied filters
		this.observeAppliedFilters();

		// All systems go - let's fetch our first lot of
		// data
		this.fetch();
	}

	// All of the methods which remain the same between
	// instnaces of DataGrid
	DataGrid.prototype = {

		// Always set our constructor property
		constructor: DataGrid,

		findResultsObject: function() {
			var resultsSelector, $results;

			// Let's check our results
			if ( ! (resultsSelector = this.$element.data('results'))) {
				$.error('$.dataGrid requires you specify the results DOM object through [data-results=".selector-of-results"], none given.');
			}

			if ( ! ($results = $(resultsSelector)).length) {
				$.error('Results DOM object with selector [' + resultsSelector + '] does not exist.');
			}

			// And now we prepare our DOM object for use with TempoJS
			this.$results = $results;
		},

		/**
		 * Prepares the templates for use with TempoJS
		 * by creating the instances needed.
		 *
		 * @return void
		 */
		prepareTemplates: function() {
			this.prepareResultsTemplate();
			this.prepareFiltersTemplate();
			this.prepareAppliedFiltersTemplate();
			this.preparedPaginationTemplate();
		},

		prepareResultsTemplate: function() {
			this.templates.results = Tempo.prepare(this.$results[0], this.options.tempoOptions);
		},

		prepareFiltersTemplate: function() {
			var filtersSelector, $filters;

			// Let's check our filters
			if ( ! (filtersSelector = this.$element.data('filters'))) {
				$.error('$.dataGrid requires you specify the filters DOM object through [data-filters=".selector-of-filters"], none given.');
			}

			if ( ! ($filters = $(filtersSelector)).length) {
				$.error('Filters DOM object with selector [' + filtersSelector + '] does not exist.');
			}

			// And now we prepare our DOM object for use with TempoJS
			this.$filters = $filters;
			this.templates.filters = Tempo.prepare(this.$filters[0], this.options.tempoOptions);
		},

		prepareAppliedFiltersTemplate: function() {
			var appliedFiltersSelector, $appliedFilters;

			// Let's check our applied filters
			if ( ! (appliedFiltersSelector = this.$element.data('applied-filters'))) {
				$.error('$.dataGrid requires you specify the appliedFilters DOM object through [data-applied-filters=".selector-of-applied-filters"], none given.');
			}

			if ( ! ($appliedFilters = $(appliedFiltersSelector)).length) {
				$.error('Applied Filters DOM object with selector [' + appliedFiltersSelector + '] does not exist.');
			}

			// And now we prepare our DOM object for use with TempoJS
			this.$appliedFilters = $appliedFilters;
			this.templates.appliedFilters = Tempo.prepare(this.$appliedFilters[0], this.options.tempoOptions);
		},

		preparedPaginationTemplate: function() {
			var paginationSelector, $pagination;

			// Let's check our pagination
			if ( ! (paginationSelector = this.$element.data('pagination'))) {
				$.error('$.dataGrid requires you specify the pagination DOM object through [data-pagination=".selector-of-pagination"], none given.');
			}

			if ( ! ($pagination = $(paginationSelector)).length) {
				$.error('Pagination DOM object with selector [' + paginationSelector + '] does not exist.');
			}

			// And now we prepare our DOM object for use with TempoJS
			this.$pagination = $pagination;
			this.templates.pagination = Tempo.prepare(this.$pagination[0], this.options.tempoOptions);
		},

		setupFilters: function() {
			var me = this
			$resultsHeaders = this.$results.find('thead th'),
			  $resultsCells = this.$results.find('[data-template] td');

			$resultsCells.each(function(index) {
				var $cell = $(this),
				  $header = $($resultsHeaders[index]),
				     type,
				 mappings = [];

				// Sometimes a cell will have a 'data-no-filters' attribute.
				// This is fine as they may not want me column to be
				// filtereable. If so, we'll just skip over the cell
				if (typeof($cell.data('no-filters')) !== 'undefined') {
					return;
				}

				switch (type = $cell.data('type') ? $cell.data('type') : 'text') {
					case 'select':
						mappings = me.parseMappings($cell.data('mappings'));
						break;
				}

				me.filters.push({
					'type': type,
					'index': $cell.data('index'),
					'label': $header.text(),
					'mappings': mappings
				});
			});
		},

		renderFilters: function() {
			this.templates.filters.render(this.filters);
		},

		observeAppliedFilters: function() {
			var me = this;

			// Adding global filters
			$('body').on('click', me.$filters.selector + ' .add-global-filter', function() {
				me.applyFilter($(this).siblings(':input').first(), 'global');
				me.renderAppliedFilters();
				me.fetch();
			});

			// Adding normal filters
			$('body').on('click', me.$filters.selector + ' .add-filter', function() {
				me.applyFilter($(this).siblings(':input').first(), 'normal');
				me.renderAppliedFilters();
				me.fetch();
			});

			// Removing filters
			$('body').on('click', me.$appliedFilters.selector + ' .remove-filter', function() {
				var index = $(this).closest('[data-template]').index();
				me.removeFilter(index);
				me.renderAppliedFilters();
				me.fetch();
			});
		},

		applyFilter: function(input, type) {
			var value, index, filter = {};

			// Default the filter type
			if (typeof type === 'undefined') {
				type = 'global';
			}

			// If the apply filter was triggered
			// however no value was present on the
			// filter input, we'll just stop here
			if ( ! (value = input.val())) {
				return;
			}

			if (type == 'normal' && ! (index = input.data('index'))) {
				$.error('$.dataGrid requires each filter specify it\'s result index through [data-index="the_result_index"], none given.');
			}

			// Now we build our new filter object for the
			// filters array
			if ((filter['type'] = type) == 'normal') {
				filter['index'] = index;
			}
			filter['value'] = value;

			// Add the filter to the list of filters
			this.appliedFilters.push(filter);

			// Empty out the input's
			// value to default
			input.val('');
		},

		removeFilter: function(index) {
			this.appliedFilters.splice(index, 1);
		},

		renderAppliedFilters: function() {
			this.templates.appliedFilters.render(this.appliedFilters);
		},

		fetch: function() {
			var me = this;

			// Let's retrieve the new JSON payload from the server with our
			// fetch parameters that we've built.
			$.getJSON(this.source, this.buildFetchParameters(), function(data) {

				me.loadResults(data.results);
				me.loadPagination(data.pagination);
				me.renderResults();
				me.renderPagination();

			// Handle JSON errors
			}).error(function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.status + ' ' + errorThrown);
			});
		},

		loadResults: function(results) {
			this.results = results;
		},

		loadPagination: function(pagination) {

			// Reset our pagination data
			this.pagination.navigation = [];

			// Loop through the pages and add a new index
			// to the pagination data array
			for (i = 1; i <= pagination.total_pages; i++) {
				this.pagination.navigation.push({
					page: i
				});
			}
		},

		renderResults: function() {
			this.templates.results.clear();
			this.templates.results.render(this.results);
		},

		renderPagination: function() {
			console.log(this.pagination.navigation);
			this.templates.pagination.render(this.pagination.navigation);
		},

		/*
		|--------------------------------------------------------------------------
		| Utilities
		|--------------------------------------------------------------------------
		|
		| The methods below are various utilities used throughout the DataGrid
		| object.
		|
		*/

		/**
		 * Parses a mappings string and returns an array of objects with
		 * the mappings provided.
		 *
		 * Input format:
		 *     "Two Items:2|One Item:1|Zero Items:0"
		 *
		 * Output format:
		 *     [{"label":"Two Items","value":"2"}...]
		 *
		 * @param  string  mappingsString
		 * @return array
		 */
		parseMappings: function(mappingsString) {
			var mappings = [];

			$.each(mappingsString.split('|'), function(index, mapping) {
				var mappingParts = mapping.split(':');
				mappings.push({
					label: mappingParts[0],
					value: mappingParts[1]
				});
			});

			return mappings;
		},

		buildFetchParameters: function() {
			var me = this,
			parameters = {
				page: this.pagination.page,
				requested_pages: this.options.pagination.requestedPages,
				minimum_per_page: this.options.pagination.minimumPerPage,
				filters: []
			};

			// Loop through filters and build up
			// array of filter parameters
			$.each(this.appliedFilters, function(index, filter) {
				if (filter.type === 'global') {
					parameters.filters.push(filter.value);
				} else {
					var newFilter = {};
					newFilter[filter.index] = filter.value;
					parameters.filters.push(newFilter);
				}
			});

			return parameters;
		}

	};

	$.fn.dataGrid = function(options) {
		return new DataGrid(this, options);
	}

})(jQuery);
