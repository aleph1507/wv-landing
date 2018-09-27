<?php
		require 'PHPMailer_5.2.0/class.phpmailer.php';

		/* validation */
    $arr = [];
		$name = $phone = $email = $city = $country = $msg = "";
		$error = "";
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			empty($_POST['name']) ? $GLOBALS['error'] .= 'Your name is required. <br>' : $GLOBALS['name'] = san_input($_POST['name']);
      empty($_POST['email']) ? $GLOBALS['error'] .= 'Your email is required. <br>' :
        filter_var(san_input($_POST['email']), FILTER_VALIDATE_EMAIL) ? $GLOBALS['email'] = san_input($_POST['email']) : $GLOBALS['error'] .= 'Your email seems invalid. <br>';
      empty($_POST['phone']) ? $GLOBALS['phone'] = null : $GLOBALS['phone'] = san_input($_POST['phone']);
      empty($_POST['city']) ? $GLOBALS['error'] .= 'City is required. <br>' : $GLOBALS['city'] = san_input($_POST['city']);
      empty($_POST['country']) ? $GLOBALS['country'] = null : $GLOBALS['country'] = san_input($_POST['country']);
			empty($_POST['msg']) ? $GLOBALS['msg'] = null : $GLOBALS['msg'] = san_input($_POST["msg"]);
		}
		function san_input($data){
			return htmlspecialchars(trim($data));
		}
		if($error != "")
			died();
		// header('Refresh: 5;url=index.php');
		function died(){
			// $error_message_mk = 'Имаше грешки со праќањето на Вашиот емаил:<br>'
			// 					. $GLOBALS['error'] . '<br><br>' . 'Ве молиме пробајте повторно.<br>'
			// 					. 'Ќе бидете пренасочени за 10 секунди.';
			$error_message = "We encounter errors while sending your message:<br>";
			// header('Refresh: 10;url=index.php');
			// echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-2">';
			// echo $error_message_mk;
			// echo '</div></div>';
			// echo '<div class="row"><div class="col-md-3 col-md-offset-2">';

      $arr["error_message"] = $error_message;
			// echo $error_message;
			// echo '</div></div></div>';
			die();
		}
    echo '!$success';

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->Username = 'info@thinkerlab.io';
		$mail->Password = '';
		$mail->setFrom($email, $name);
		$mail->addAddress('info@thinkerlab.io');
		if(empty($subject))
			$subject = 'Nova poraka od WeVector';
		$mail->Subject = $subject;
		// echo '<br>subject: '.$subject . '<br>';
		if(empty($msg))
			$message = 'Message has no content.';
		else {
			$message = '<p style="text-align:center;"><h2 style="margin-left:30%;">New mail from WeVector</h2></p><br>'
			. '<p>' . $msg . '</p><br><p style="text-align:right; color:grey;">' . $name
			. ',<br>' . $email . '</p>';
		}
		$mail->Body = $message;
		if(!$success=$mail->send()){
			// echo 'invalid';
      $arr["error_info"] = 'There has been an error:' . $mail->ErrorInfo;
      // echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-4">';
			// echo 'There has been an error:<br>';
			// echo $mail->ErrorInfo;
			// echo '</div></div></div>';
		} else {
      $arr["success"] = 'Mail sent.';
      // echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-4">';
			// echo '<br>Mail sent.<br>';
			// echo '</div></div></div>';

		}
    // echo 'arr: ' . var_dump($arr);
    // echo json_encode($arr);
?>
