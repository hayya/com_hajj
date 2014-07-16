<?php
//���� ���  ���� ������� �������� ����� file
function sendStatus($viewResult=1)
{
	global $arraySendStatus;
	$contextOptions['http'] = array('method' => 'GET', 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/sendStatus.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);
	
	if($viewResult)
		$result = printStringResult(trim($result), $arraySendStatus);
	return $result;
}

//���� ����� ���� ������ ����� ������� �� ���� ������� �������� ����� file
function changePassword($userAccount, $passAccount, $newPassAccount, $viewResult=1)
{
	global $arrayChangePassword;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'newPassword'=>$newPassAccount));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/changePassword.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);
	
	if($viewResult)
		$result = printStringResult(trim($result), $arrayChangePassword);
	return $result;
}

//���� ������� ���� ������ ����� ������� �� ���� ������� �������� ����� file
function forgetPassword($userAccount, $sendType, $viewResult=1)
{
	global $arrayForgetPassword;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'type'=>$sendType));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/forgetPassword.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);
	
	if($viewResult)
		$result = printStringResult(trim($result), $arrayForgetPassword);
	return $result;
}

//���� ��� ������ �������� ����� file
function balanceSMS($userAccount, $passAccount, $viewResult=1)
{
	global $arrayBalance;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/balance.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result), $arrayBalance, 'Balance');
	return $result;
}

//���� ������� �������� ����� file
function sendSMS($userAccount, $passAccount, $numbers, $sender, $msg, $timeSend=0, $dateSend=0, $deleteKey=0, $viewResult=1)
{
	global $arraySendMsg;
	$applicationType = "24";  
  //$msg = convertToUnicode($msg);
	$sender = urlencode($sender);
	$domainName = $_SERVER['SERVER_NAME'];
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'numbers'=>$numbers, 'sender'=>$sender, 'msg'=>$msg, 'timeSend'=>$timeSend, 'dateSend'=>$dateSend, 'applicationType'=>$applicationType, 'domainName'=>$domainName, 'deleteKey'=>$deleteKey));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/msgSend.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result), $arraySendMsg);
	return $result;
}

//���� ���� ������� �������� ����� file
function sendSMSWK($userAccount, $passAccount, $numbers, $sender, $msg, $msgKey, $timeSend=0, $dateSend=0, $deleteKey=0, $viewResult=1)
{
	global $arraySendMsgWK;
	$applicationType = "24";  
    $msg = convertToUnicode($msg);
	$msgKey = convertToUnicode($msgKey);
	$sender = urlencode($sender);
	$domainName = $_SERVER['SERVER_NAME'];
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'numbers'=>$numbers, 'sender'=>$sender, 'msg'=>$msg, 'msgKey'=>$msgKey, 'timeSend'=>$timeSend, 'dateSend'=>$dateSend, 'applicationType'=>$applicationType, 'domainName'=>$domainName, 'deleteKey'=>$deleteKey));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/msgSendWK.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arraySendMsgWK);
	return $result;
}

//���� ��� ������� �������� ����� file
function deleteSMS($userAccount, $passAccount, $deleteKey=0, $viewResult=1)
{
	global $arrayDeleteSMS;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'deleteKey'=>$deleteKey));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/deleteMsg.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arrayDeleteSMS);
	return $result;
}

//���� ��� ��� ���� (����) �������� ����� file
function addSender($userAccount, $passAccount, $sender, $viewResult=1)
{	
	global $arrayAddSender;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'sender'=>$sender));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/addSender.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result), $arrayAddSender, 'Normal');
	return $result;
}

//���� ����� ��� ���� (����) �������� ����� file
function activeSender($userAccount, $passAccount, $senderId, $activeKey, $viewResult=1)
{
	global $arrayActiveSender;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'senderId'=>$senderId, 'activeKey'=>$activeKey));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/activeSender.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arrayActiveSender);
	return $result;
}

//���� ������ �� ���� ��� ��� ���� (����) �������� ����� file
function checkSender($userAccount, $passAccount, $senderId, $viewResult=1)
{	
	global $arrayCheckSender;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'senderId'=>$senderId));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/checkSender.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arrayCheckSender);
	return $result;
}

//���� ��� ��� ���� (����) �������� ����� file
function addAlphaSender($userAccount, $passAccount, $sender, $viewResult=1)
{
	global $arrayAddAlphaSender;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount, 'sender'=>$sender));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/addAlphaSender.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arrayAddAlphaSender);
	return $result;
}

//���� ������ �� ���� ��� ��� ���� (����) �������� ����� file
function checkAlphasSender($userAccount, $passAccount, $viewResult=1)
{
	global $arrayCheckAlphasSender;
	$contextPostValues = http_build_query(array('mobile'=>$userAccount, 'password'=>$passAccount));
	$contextOptions['http'] = array('method' => 'POST', 'header'=>'Content-type: application/x-www-form-urlencoded', 'content'=> $contextPostValues, 'max_redirects'=>0, 'protocol_version'=> 1.0, 'timeout'=>10, 'ignore_errors'=>TRUE);
	$contextResouce  = stream_context_create($contextOptions);
	$url = "http://www.mobily.ws/api/checkAlphasSender.php";
	$handle = fopen($url, 'r', false, $contextResouce);
    $result = stream_get_contents($handle);

	if($viewResult)
		$result = printStringResult(trim($result) , $arrayCheckAlphasSender, 'Senders');
	return $result;
}
?>