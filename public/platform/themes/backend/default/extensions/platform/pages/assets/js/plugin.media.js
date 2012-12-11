if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};

RedactorPlugins.media = {

	contents: {},

	init: function() {
		var self = this;
		var textarea = ($('.redactor_box').find('textarea'));

		this.addBtnBefore('video', 'media', 'Insert Media');

		$('#redactor_media').mediaChooser({

			_identifier: 'redactor_media',
			linkSelector: '.redactor_btn_media',

			choose : {
				callback: function(items, mediaChooser) {
					var img = null;

					for (var i in items) {
						var item = items[i];
						console.log(item);
						if (/png|jpeg|jpg|gif/.test(item.fileExtension.toLowerCase())) {
							img = item.thumbnailUrl;
						}
					}

					content = '<img src="'+img+'">';

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

}
