<?php	
	function writeLog($logText)
	{
	    $f = fopen("logfile.txt", "a");
	    fwrite($f, '[' . date('d.m.o H:i:s') . "] -- $logText \n");
	    fclose($f);
	    return;
	}
	
	$users = array(
		array(
			'id' => '1',
			'name' => 'Sergey',
			'email' => 'Sergey@mail.com'
		),
		array(
			'id' => '2',
			'name' => 'Ivan',
			'email' => 'Ivan@mail.com'
		),
		array(
			'id' => '3',
			'name' => 'Viktor',
			'email' => 'Viktor@mail.com'
		),
	);
	$errors = array(
		'error' => false,
		'name' => false,
		'surname' => false,
		'email' => false,
		'notEmail' => false,
		'password' => false,
		'checkPassword' => false,
		'differentPasswords' => false,
		'msg' => ''
	);
	$textForLog = '';
	foreach(array_keys($_POST) as $key)
	{
		if(empty($_POST[$key]))
		{
			$errors[$key] = true;
			if(!$errors['error'])
			{
				$errors['msg'] .= "<font color='red'>Необходимо ввести все поля</font></br>";
				$errors['error'] = true;
			}
		}
	}
	if(!$errors['email'] && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$errors['notEmail'] = true;
		$errors['msg'] .= "<font color='red'>Почта введена неверно</font></br>";
		$errors['error'] = true;
	}
	if(!$errors['password'] && !$errors['checkPassword'] && $_POST['password']!=$_POST['checkPassword'])
	{
		$errors['differentPasswords'] = true;
		$errors['msg'] .= "<font color='red'>Пароли не совпадают</font></br>";
		$errors['error'] = true;
	}
	if($errors['error'])
	{
		echo json_encode($errors);
		return;
	}
	foreach($users as $user)
	{
		if($_POST['email'] == $user['email'])
		{
			$usedEmail = array(
				'usedEmail' => true,
				'msg' => "<font color='red'>Пользователь с таким email уже существует</font></br>",
			);
			writeLog("Пользователь с введенной почтой уже существует");
			echo json_encode($usedEmail);
			return;
		}
	}
	$msg = array('msg' => "<h3 class='h3 mb-3 fw-normal text-center text-success'>Регистрация произведена успешно</h3></br>");
	writeLog("Пользователь успешно зарегистрирован");
	echo json_encode($msg);
	return;
?>