<?php
        session_start();

        include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
        $mail = $_POST["mail"];
        $passwd = $_POST["passwd"];

        
        try {
            global $db_dsn, $db_user, $db_password;
            $db = new PDO($db_dsn, $db_user, $db_password);

            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            $sql = "SELECT * from users WHERE mail = :mail AND NOT del = 1";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':mail', $mail);
            $stmt->execute();
        } catch (PDOException $error) {
            echo "error" . $error->getMessage();
        }
        // SQLより取り出したデータを配列に格納
          $data = $stmt->fetchAll();
          $id_db = array_column($data, 'id');
          $name_db = array_column($data, 'name');
          $mail_db = array_column($data, 'mail');
          $passwd_db = array_column($data, 'password');

          $_SESSION['id'] = $id_db[0];
          $_SESSION['mail'] = $mail_db[0];
          $_SESSION['name'] = $name_db[0];
          $_SESSION['passwd'] = $passwd_db[0];

          $decryption_passwd = openssl_decrypt($passwd_db[0], $cipher, $key);

          if ($decryption_passwd == $passwd) {
                $_SESSION['first_login_date'] = date('Y/m/d', strtotime($today));
                http_response_code( 301 ) ;
                header( "Location: http://localhost:8888/user/userpage.php" ) ;
                exit ;
          } else {
                $_SESSION['login'] = "failure";
                http_response_code( 301 ) ;
                header( "Location: http://localhost:8888/user/index.php" ) ;
                exit ;
          }
 ?>