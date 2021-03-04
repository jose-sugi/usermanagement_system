<?php
	//データベースのログイン情報
    $db_dsn = 'mysql:host=localhost;dbname=mailtest';
	$db_user = 'root';
	$db_password = 'root';

	//日本時間の設定
    date_default_timezone_set('Asia/Tokyo');
    $today = date('Y/m/d H:i:s');

    //OpenSSLの暗号化メソッドとキー
    $cipher = 'aes-128-ecb'; // 暗号化メソッド
	$key = 'key'; // 暗号化キー

	$max_name_length = 255;//名前の最大文字数
    $max_mail_length = 255;//メールアドレスの最大文字数

 ?>