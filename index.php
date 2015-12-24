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
	$article = $iaCore->iaView->getValues('item');

	if ($article && function_exists('curl_init'))
	{
		$url = 'http://ajax.googleapis.com/ajax/services/language/translate';
		$data = array(
			'v' => '1.0',
			'langpair' => '|' . $_GET['to_lang'],
			'q' => $article['title'] . '<break />' . $article['body']
		);
		$iaCore->get('google_api_key') and $data['key'] = $iaCore->get('google_api_key');

		$data['userip'] = iaUtil::getIp(false);

		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_REFERER, !empty($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : "");
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$result = curl_exec( $ch );
		curl_close( $ch );

		$result = iaUtil::jsonDecode($result);
		if (!empty($result->responseData->translatedText))
		{
			list($article['title'], $article['body']) = explode('<break />', $result->responseData->translatedText, 2);

			$iaCore->iaView->assign('item', $article);
		}
	}
}