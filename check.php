    <?php 
    	include(dirname(__FILE__) . '/php_function.php');//PHP関数ファイルの読み込み
        include(dirname(__FILE__) . '/js_function.php');//JS関数ファイルの読み込みです

        $name = $_POST["name"];
        $mail = $_POST["mail"];
        $passwd = $_POST["passwd"];
     ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9f015e8d67.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container con_check">
        <div class="box">
            <p class="check_inf top">登録情報</p>
            <p class="check_inf label name">name</p>
            <p class="check_inf name post"><?php echo $name; ?></p>
            <p class="check_inf label email">email</p>
            <p class="check_inf email post"><?php echo $mail; ?></p>
            <p class="check_inf label password">password</p>
            <p class="check_inf password post"><?php echo passwd($passwd); ?></p>
            <form action="index.php" class="check_form" method="post" onsubmit="return check_signup();">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="mail" value="<?php echo $mail; ?>">
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>">
                <input type="submit" value="登録" class="button_right bt_right">
            </form>
            <button type="button" class="button_left bt_left" onclick="history.back()">修正</button>
        </div>
    </div>
    <a onclick="history.back()" href="#" class="arrow_back"><i class="far fa-arrow-alt-circle-left fa-3x"></i></a>
</body>
</html>