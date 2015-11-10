<?php
//##copyright##

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