<?php
		require 'PHPMailer_5.2.0/class.phpmailer.php';

		/* validation */
    $arr = [];
		$name = "";
		$phone = "";
		$email = "";
		$city = "";
		$country = "";
		$msg = "";
		$error = [];
		$data = [];
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			// print_r($_POST);
			// empty($_POST['name']) ? $GLOBALS['error'] .= 'Your name is required. <br>' : $GLOBALS['name'] = san_input($_POST['name']);
			empty($_POST['name']) ? $error['name'] = 'Your name is required.' : $GLOBALS['name'] = san_input($_POST['name']);
			// empty($_POST['address']) ? $GLOBALS['error'] .= 'Your email is required. <br>' :
      //   filter_var(san_input($_POST['address']), FILTER_VALIDATE_EMAIL) ? $GLOBALS['email'] = san_input($_POST['address']) : $GLOBALS['error'] .= 'Your email seems invalid. <br>';
			empty($_POST['address']) ? $error['email'] = 'Your email is required.' :
        filter_var(san_input($_POST['address']), FILTER_VALIDATE_EMAIL) ? $GLOBALS['email'] = san_input($_POST['address']) : $error['email'] = 'Your email seems invalid.';
      empty($_POST['phone']) ? $GLOBALS['phone'] = null : $GLOBALS['phone'] = san_input($_POST['phone']);
      // empty($_POST['city']) ? $GLOBALS['error'] .= 'City is required. <br>' : $GLOBALS['city'] = san_input($_POST['city']);
			empty($_POST['city']) ? $error['city'] = 'City is required.' : $GLOBALS['city'] = san_input($_POST['city']);
			empty($_POST['company']) ? $error['company'] = 'Company is required.' : $GLOBALS['city'] = san_input($_POST['city']);
      // empty($_POST['country']) ? $GLOBALS['country'] = null : $GLOBALS['country'] = san_input($_POST['country']);
			empty($_POST['country']) ? $error['country'] = 'Country is required' : $GLOBALS['country'] = san_input($_POST['country']);
			// empty($_POST['msg']) ? $GLOBALS['msg'] = null : $GLOBALS['msg'] = san_input($_POST["msg"]);
			empty($_POST['msg']) ? $error['msg'] = 'Please write us a note.' : $msg = san_input($_POST["msg"]);
		}
		function san_input($data){
			return htmlspecialchars(trim($data));
		}

		if(!empty($error)){
			$data['success'] = false;
			$data['errors'] = $error;
			echo json_encode($data);
			die();
		}

		// if($error != "")
		// 	died();

		// header('Refresh: 5;url=index.php');
		// function died(){
			// $error_message_mk = 'Имаше грешки со праќањето на Вашиот емаил:<br>'
			// 					. $GLOBALS['error'] . '<br><br>' . 'Ве молиме пробајте повторно.<br>'
			// 					. 'Ќе бидете пренасочени за 10 секунди.';

			// $error_message = "We encounter errors while sending your message:<br>";

			// header('Refresh: 10;url=index.php');
			// echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-2">';
			// echo $error_message_mk;
			// echo '</div></div>';
			// echo '<div class="row"><div class="col-md-3 col-md-offset-2">';

      // $arr["error_message"] = $error_message;


			// $data['success'] = false;
			// $data['errors'] =
			// echo $error_message;
			// echo '</div></div></div>';
			// die();
		// }
    // echo '!$success';

		$mail = new PHPMailer;
		$mail->IsSMTP();
		$mail->SMTPDebug = 0;
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->Username = 'info@thinkerlab.io';
		$mail->Password = 'jrjecbifsfnnunmv';
		$mail->setFrom($email, $name);
		$mail->addAddress('xrristo@gmail.com');
		if(empty($subject))
			$subject = 'Nova poraka od WeVector';
		$mail->Subject = $subject;
		// echo '<br>subject: '.$subject . '<br>';
		if(empty($msg))
			$message = 'Message has no content.';
		else {
			$message = '<p style="text-align:center;"><h2 style="margin-left:30%;">New mail from WeVector</h2></p><br>'
			. '<p>' . $msg . '</p><br><p style="text-align:right; color:grey; font-size: 1.3em;">' . $name
			. ',<br>' . $email . '</p>';
		}
		$mail->Body = $message;
		if(!$success=$mail->send()){
			// echo 'invalid';

      // $arr["error_info"] = 'There has been an error:' . $mail->ErrorInfo;
			$data['success'] = false;
			$data['errors'] = 'Error sending the mail';
      // echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-4">';
			// echo 'There has been an error:<br>';
			// echo $mail->ErrorInfo;
			// echo '</div></div></div>';
		} else {
      // $arr["success"] = 'Mail sent.';
			$data['success'] = true;
			$data['message'] = 'Your message has been sent.';
      // echo '<div class="container mail-msg bg-primary"><div class="row"><div class="col-md-3 col-md-offset-4">';
			// echo '<br>Mail sent.<br>';
			// echo '</div></div></div>';

		}

		echo json_encode($data);
    // echo 'arr: ' . var_dump($arr);
    // echo json_encode($arr);
?>
