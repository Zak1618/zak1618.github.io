<?
 
 function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
 
$clientName = "не указал";
if( isset($_POST['name'])) {
    $clientName = $_POST['name'];
  }

$clientPhone = "не указал";
  if( isset($_POST['phone'])) {
    $clientPhone = $_POST['phone'];
  }
$clientEmail = "не указал";
  if( isset($_POST['email'])) {
    $clientPhone = $_POST['email'];
  }

$tnxPage = "index2.html";
  if( isset($_POST['tnxpage'])) {
    $tnxPage = $_POST['tnxpage'];
  }
  
$toAdmin  = "bodi9ka@gmail.com";
$prokla = "tongkatnaebka.com";
  
$headers  = "Content-type: text/html; charset=UTF-8 \r\n"; 

$subject = 'Tovarka NEW ORDER - Phone:'. $clientPhone;
$body = ' 
  <html> 
    <head> 
      <title>Продажа ТонгКат</title> 
    </head>
    <body> 
    <b>Клиент:</b>
      <p><span style="color:red;">Имя:</span> '.$clientName.'<br><span style="color:red;">Email:</span> '.$clientEmail.'<br>
      <span style="color:red;">Телефон:</span> '.$clientPhone.'<br><span style="color:red;">Страница:</span> '.$prokla.' </p>
    </body> 
  </html>';
  
  mail($toAdmin , $subject, $body, $headers); 
///////////////дописанно для интеграции с ML///////////
	//собираем данные о клиенете в один массив для отправки
	$data = [
		'tel' => $clientPhone,
		'client' => $clientName,
		'ip' => $_SERVER['REMOTE_ADDR']
	];
	$ch = curl_init();
	$url = 'https://api.monsterleads.pro/method/order.add?api_key=b5fa52e1fb157ff7ddabc5d3e352dd36&format=json&code=nm4an6';
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$res= curl_exec($ch);
	curl_close($ch);
	$answer = json_decode($res, true);

	if($answer['status'] == 'ok'){
		// лид успешно добавлен
		redirect($tnxPage); //redirect to thnx page
		die();
	}else{
		//ошибка добавления лида(в этот блок можно дописать обработку таких случаев)
		redirect($tnxPage); //redirect to thnx page
		die();
	}
///////////////дописанно для интеграции с ML///////////	
  
  
  