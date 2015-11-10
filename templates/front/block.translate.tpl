{assign langs $core.config.google_langs|unserialize}

<div id="google_translate_element"></div>

<script type="text/javascript">
	function googleTranslateElementInit()
	{
		new google.translate.TranslateElement(
		{
			pageLanguage: 'en',
			includedLanguages: '{$langs|array_keys|implode:","}'
		},
		'google_translate_element');
	}
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>