if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.content = {

	contents: {},

	init: function() {
		var self = this;
		var textarea = ($('.redactor_box').find('textarea'));

		$.ajax({
			type: 'GET',
			url: platform.url.admin('pages/content/findall'),
			async: false,
			dataType: 'JSON',
			success: function(data) {
				_content = {};
				$.each(data, function(i, item) {
					_content[item['slug']] = {
						title: item.name,
						callback: function() {

							content = '@content(\''+item.slug+'\')';

							if ( ! self.opts.visual)
							{
								self.$el.focus();
								pos = self.getCursorPosition(textarea);
								val = textarea.val();

								val1 = val.substring(0, pos[0]);
								val2 = val.substring(pos[1], val.length);
								textarea.val(val1+content+val2);
								self.setCursorPosition(textarea, (pos[1]-(pos[1]-pos[0]))+content.length);
							}
							else
							{
								self.restoreSelection();
								self.insertHtml(content);
							}
						}
					}
				});

				self.contents = _content;
			}
		});

		this.addBtnBefore('video', 'content', 'Insert Content', function() {}, self.contents);
	},

	getCursorPosition: function(el) {
        var el = el.get(0);
        var start = 0;
        var end = 0;
        if('selectionStart' in el)
        {
            start = el.selectionStart;
            end   = el.selectionEnd;
        }
        else if('selection' in document)
        {
            range = document.selection.createRange();

        	if (range && range.parentElement() == el)
        	{
	            len = el.value.length;
	            normalizedValue = el.value.replace(/\r\n/g, "\n");

	            // Create a working TextRange that lives only in the input
	            textInputRange = el.createTextRange();
	            textInputRange.moveToBookmark(range.getBookmark());

	            // Check if the start and end of the selection are at the very end
	            // of the input, since moveStart/moveEnd doesn't return what we want
	            // in those cases
	            endRange = el.createTextRange();
	            endRange.collapse(false);

	            if (textInputRange.compareEndPoints("StartToEnd", endRange) > -1)
	            {
	                start = end = len;
	            }
	            else
	            {
	                start = -textInputRange.moveStart("character", -len);
	                start += normalizedValue.slice(0, start).split("\n").length - 1;

	                if (textInputRange.compareEndPoints("EndToEnd", endRange) > -1)
	                {
	                    end = len;
	                }
	                else
	                {
	                    end = -textInputRange.moveEnd("character", -len);
	                    end += normalizedValue.slice(0, end).split("\n").length - 1;
	                }
	            }
       	 	}
       	}

        return [start, end];
    },

    setCursorPosition: function(el, pos) {
    	var el = el.get(0);

        if('selectionStart' in el) {
            el.setSelectionRange(pos, pos);
        } else if('selection' in document) {
            el.focus();
        	pos = (-el.value.length)+pos+1;
            range = document.selection.createRange();
            range.moveStart("character", pos);
            range.moveEnd("character", pos);
            range.select();
        }
    }

};