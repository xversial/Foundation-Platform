<!-- Upload tab of the media chooser widget. We load in some assets and call the media upload form (which uses a jQuery plugin) -->

<!-- Queue Styles -->
{{ Theme::queue_asset('media-upload', 'platform/media::css/upload.less', 'style') }}

<!-- Queue Global Scripts -->
{{ Theme::queue_asset('jquery-ui', 'js/vendor/jquery/ui-1.9.1.min.js', 'jquery') }}

<!-- Queue App Specific Scripts -->
{{ Theme::queue_asset('tmpl', 'platform/media::js/tmpl.min.js') }}
{{ Theme::queue_asset('iframe-transport', 'platform/media::js/jquery/iframe-transport-1.5.js', 'jquery') }}
{{ Theme::queue_asset('file-upload', 'platform/media::js/jquery/fileupload-5.19.3.js', array('jquery', 'jquery-ui')) }}
{{ Theme::queue_asset('file-upload-fp', 'platform/media::js/jquery/fileupload-fp-1.2.js', 'file-upload') }}
{{ Theme::queue_asset('file-upload-ui', 'platform/media::js/jquery/fileupload-ui-6.11.js', 'file-upload-fp') }}
{{ Theme::queue_asset('file-upload-media', 'platform/media::js/jquery/fileupload-media-1.0.js', 'file-upload-ui', 'tmpl') }}

@render('platform/media::upload.form', array('identifier' => $identifier, 'chooser' => true))