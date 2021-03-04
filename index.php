<?php 
		include(dirname(__FILE__) . '/php_function.php');//PHP関数ファイルの読み込み
		include(dirname(__FILE__) . '/js_function.php');//JS関数ファイルの読み込み
		include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
		session_start();

		
		if (!empty($_POST['name'])) {
			$mail = $_POST["mail"];
        	$passwd = $_POST["passwd"];
            $name = $_POST["name"];
            $count_mail = db_mail_check($mail);
            if ($count_mail == 0) {//メールアドレスに重複なかったら登録
            	dbin($name, $mail, $passwd, $today);
            } else {//メールアドレスに重複があればアラート表示
            	echo <<<EOM
				<script type="text/javascript">
				  signup_alert();
				</script>
				EOM;
            }
        } 
        if (!empty($_POST['delete_inf'])) {
        	//$del = $_POST["delete_inf"];
        $mail = $_SESSION["mail"];
        dbdel($mail);
        } else {
        	$del = null;
        }
        
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	    <link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="container">
			<?php if (@$_SESSION['login'] == "failure") : ?>
				<p class="result_login">※　メールアドレス、またはパスワードが間違っています</p>
				<?php unset($_SESSION['login']); ?>
			<?php endif; ?>
		<div class="box">
			<form action="login_check.php" name="form1" method="post">
					<input type="email" class="dummy" disabled>
				<p>mail</p><input type="email" name="mail" autocomplete="off" onchange="check_input(this.name);" required>
				 	<input type="password" class="dummy" disabled>
				<p>password</p><input type="password" name="passwd" autocomplete="off" onchange="check_input(this.name);" required>
					<input type="submit" value="Login" class="button_left" required>
					<a href="signup.php"  class="button_right">Sign Up</a>
			</form>			
		</div>
	</div>	
</body>
</html>