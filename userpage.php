<?php 
	session_start();
        
        include(dirname(__FILE__).'/php_function.php');//PHPファイルの読み込み
        include(dirname(__FILE__) . '/js_function.php');//JS関数ファイルの読み込み
        include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
       
        time_logout($_SESSION['first_login_date']);// 24時を過ぎると自動でログアウト

        if (!empty($_POST['name'])) {
            $mail = $_POST['mail'];
            if ($_POST["mail"] !== $_SESSION["mail"]) {//変更前と変更後のメールアドレスが同じであれば、db_mail_check関数を呼ばない
                $count_mail = db_mail_check($mail);//メールアドレスが重複していないかチェックする関数
            }
            if ($count_mail == 0) {//メールアドレスに重複なかったら登録
                dbin_log($_POST["id"], $_SESSION["name"], $_SESSION["mail"], $_SESSION["passwd"], $_POST["name"], $_POST["mail"], $_POST["passwd"]);

                dbupd($_POST["id"], $_POST["name"], $_POST["mail"], $_POST["passwd"]);
                $data = dbsel($_POST['mail']);

                $_SESSION['mail'] = $data["mail"];
                $_SESSION['name'] = $data["name"];
                $_SESSION['passwd'] = $data["passwd"];
            } else {//メールアドレスに重複があればアラート表示
                echo <<<EOM
                <script type="text/javascript">
                  signup_alert();
                </script>
                EOM;
            }
        } 
 ?>	
<!DOCTYPE html>
 <html>
 <head>
 	<meta charset="utf-8">
 	<meta http-equiv="X-UA-Compatible" content="IE=edge">
 	<title>ユーザーページ</title>
 	<link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/9f015e8d67.js" crossorigin="anonymous"></script>
 </head>
 <body>
 	<p class="userpage_top">こんにちは<?php echo $_SESSION['name']; ?>さん</p>
 	<div class="btn_container">
 		<a href="userpage_inf.php" class="btn userpage inf">ユーザー情報</a>
 		<a href="http://acrovision.nobushi.jp/task_program/sugisawa.hose/mail/start.php" class="btn userpage mail">メール配信システム</a>
 	</div>
    <div class="btn_container">
        <a href="userpage_inf.php" class="btn userpage inf">ユーザー一覧</a>
        <a href="http://acrovision.nobushi.jp/task_program/sugisawa.hose/mail/start.php" class="btn userpage mail">マスターテーブル一覧</a>
    </div>
 </body>
 </html>