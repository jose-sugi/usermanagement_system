    <?php 
        include(dirname(__FILE__) . '/php_function.php');//関数ファイルの読み込み
        include(dirname(__FILE__) . '/js_function.php');//JS関数ファイルの読み込み
        session_start();
        $name = $_POST["name"];
        $mail = $_POST["mail"];
        $passwd = $_POST["passwd"];
        time_logout($_SESSION['first_login_date']);// 24時を過ぎると自動でログアウト
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
            <p class="check_inf name">name</p>
            <p class="check_inf name post"><?php echo $name; ?></p>
            <p class="check_inf email">email</p>
            <p class="check_inf email post"><?php echo $mail; ?></p>
            <p class="check_inf password">password</p>
            <p class="check_inf password post"><?php echo passwd($passwd); ?></p>
            <form action="userpage.php" class="check_form" method="post" onsubmit="return check_signup();">
                <input type="hidden" name="id" value="<?php echo $_SESSION["id"]; ?>">
                <input type="hidden" name="name" value="<?php echo $name; ?>">
                <input type="hidden" name="mail" value="<?php echo $mail; ?>">
                <input type="hidden" name="passwd" value="<?php echo $passwd; ?>">
                <input type="submit" value="登録" class="button_right bt_right">
            </form>
            <button type="button" class="button_left bt_left" onclick="location.href='http://localhost:8888/user/userpage_inf_change.php'">修正</button>
        </div>
    </div>
</body>
</html>