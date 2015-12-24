<?php
/******************************************************************************
 *
 * Subrion - open source content management system
 * Copyright (C) 2015 Intelliants, LLC <http://www.intelliants.com>
 *
 * This file is part of Subrion.
 *
 * Subrion is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Subrion is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Subrion. If not, see <http://www.gnu.org/licenses/>.
 *
 *
 * @link http://www.subrion.org/
 *
 ******************************************************************************/

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