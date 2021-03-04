<?php
        include(dirname(__FILE__).'/php_function.php');//PHP関数ファイルの読み込み
        include(dirname(__FILE__) . '/js_function.php');//JS関数ファイルの読み込み
        include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
        session_start();

        $mail = $_SESSION["mail"];
        $pass = passwd_dec($_SESSION['passwd']);
        $passwd_change_ast = passwd($pass);
        //echo $_SESSION["id"]. $_SESSION["name"]. $_SESSION["mail"]. $_SESSION["passwd"];
        time_logout($_SESSION['first_login_date']);// 24時を過ぎると自動でログアウト

 ?>	
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>ログイン情報</title>
 	<link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9f015e8d67.js" crossorigin="anonymous"></script>
 </head>
 <body>
 	<p class="userpage_top">こんにちは<?php echo $_SESSION['name'];?>さん</p>
	<div class="container userpage_inf">
        <div class="box">
            <p class="check_inf top user_top">登録情報</p>
            <p class="check_inf label name">name</p>
            <p class="check_inf name post"><?php echo $_SESSION['name']; ?></p>
            <p class="check_inf label email">email</p>
            <p class="check_inf email post"><?php echo $mail; ?></p>
            <p class="check_inf label password">password</p>
            <p class="check_inf password post"><?php echo $passwd_change_ast; ?></p>
            <form name="form1" action="userpage_inf_change.php" method="post">
                <input type="hidden" name="change_inf" value="change_inf">
                <input type="submit" class="button_right bt_right userpage_bt_right" value="変更" onclick="return conf_change()">
            </form>
            <form name="form2" action="index.php" method="post">
                <input type="hidden" name="delete_inf" value="delete_inf">
                <input type="submit" class="button_left bt_left userpage_bt_left" value="削除" onclick="return conf_delete()">
            </form>
        </div>
    </div>
 	<a onclick="history.back()" href="#" class="arrow_back"><i class="far fa-arrow-alt-circle-left fa-3x"></i></a>
 </body>
 </html>