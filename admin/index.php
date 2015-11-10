<?php
//##copyright##

if (iaView::REQUEST_HTML == $iaView->getRequestType())
{
	$langs = array(
		'af' => 'Afrikaans',
		'sq' => 'Albanian',
		'ar' => 'Arabic',
		'be' => 'Belarusian',
		'bg' => 'Bulgarian',
		'ca' => 'Catalan',
		'zh' => 'Chinese',
		'zh-CN' => 'Chinese_simplified',
		'zh-TW' => 'Chinese_traditional',
		'hr' => 'Croatian',
		'cs' => 'Czech',
		'da' => 'Danish',
		'nl' => 'Dutch',
		'en' => 'English',
		'et' => 'Estonian',
		'fi' => 'Finnish',
		'fr' => 'French',
		'gl' => 'Galician',
		'de' => 'German',
		'el' => 'Greek',
		'ht' => 'Haitian_creole',
		'iw' => 'Hebrew',
		'hi' => 'Hindi',
		'hu' => 'Hungarian',
		'is' => 'Icelandic',
		'id' => 'Indonesian',
		'ga' => 'Irish',
		'it' => 'Italian',
		'ja' => 'Japanese',
		'ko' => 'Korean',
		'lv' => 'Latvian',
		'lt' => 'Lithuanian',
		'mk' => 'Macedonian',
		'ms' => 'Malay',
		'mt' => 'Maltese',
		'no' => 'Norwegian',
		'fa' => 'Persian',
		'pl' => 'Polish',
		'pt' => 'Portuguese',
		'pt-PT' => 'Portuguese_portugal',
		'ro' => 'Romanian',
		'ru' => 'Russian',
		'sr' => 'Serbian',
		'sk' => 'Slovak',
		'sl' => 'Slovenian',
		'es' => 'Spanish',
		'sw' => 'Swahili',
		'sv' => 'Swedish',
		'tl' => 'Tagalog',
		'th' => 'Thai',
		'tr' => 'Turkish',
		'uk' => 'Ukrainian',
		'vi' => 'Vietnamese',
		'cy' => 'Welsh',
		'yi' => 'Yiddish'
	);

	if (!empty($_POST))
	{
		$data = array();
		foreach ($_POST['google_lang'] as $l)
		{
			$title = isset($_POST['label'][$l]) ? $_POST['label'][$l] : $langs[$l];
			$title = iaSanitize::html($title);
			if ($title)
			{
				$data[$l] = $title;
			}
		}
		asort($data);
		$data = serialize($data);
		$iaCore->set('google_langs', $data, true);

		// clear configuration cache
		$iaCache = $iaCore->factory('cache', iaCore::CORE);
		$iaCache->clearAll();

		$iaView->setMessages(iaLanguage::get('saved'), iaView::SUCCESS);
	}

	$stored = unserialize($iaCore->get('google_langs'));

	foreach ($langs as $k => $v)
	{
		$checked = array_key_exists($k, $stored) ? 'checked="checked"' : '';
		$title = $checked ? iaSanitize::html($stored[$k]) : iaSanitize::html($v);

		$langs[$k] = array('checked' => $checked, 'title' => $title);
	}

	iaBreadcrumb::add(iaLanguage::get('google_tools'), IA_ADMIN_URL . 'googletools/');

	$iaView->assign('google_langs', $langs);
}