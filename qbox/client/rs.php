<?php

require_once('curl.php');

/**
 * func PutFile(url, key, mimeType, localFile, customMeta, callbackParams string) => (data PutRet, code int, err Error)
 * 匿名上传一个文件(上传用的临时 url 通过 $rs->PutAuth 得到)
 */
function QBox_RS_PutFile($url, $tblName, $key, $mimeType, $localFile, $customMeta = '', $callbackParams = '', $upToken = '') {

	if ($mimeType === '') {
		$mimeType = 'application/octet-stream';
	}
	$entryURI = $tblName . ':' . $key;
	$action = '/rs-put/' . QBox_Encode($entryURI) . '/mimeType/' . QBox_Encode($mimeType);
	if ($customMeta !== '') {
		$action .= '/meta/' . QBox_Encode($customMeta);
	}
	$params = array('action' => $action, 'file' => "@$localFile");
	if ($callbackParams !== '') {
		if (is_array($callbackParams)) {
			$callbackParams = http_build_query($callbackParams);
		}
		$params['params'] = $callbackParams;
	}
	if ($upToken != '') {
		$params['auth'] = $upToken;
	}
	$response = QBox_ExecuteRequest($url, $params, QBOX_HTTP_METHOD_POST);
	//var_dump($response);

	$code = $response['code'];
	if ($code === 200) {
		return array($response['result'], 200, null);
	}
	return array(null, $code, $response['result']);
}

