<?php
        include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み

        function passwd_dec($pass) {// パスワードを暗号化するための関数
            global $cipher, $key;
            $decryption_passwd = openssl_decrypt($pass, $cipher, $key);
            return $decryption_passwd;
        }

        function passwd($passwd) {//　パスワードの文字数を受け取って、文字を"＊"に変更するための関数
            $passwd_len = mb_strlen($passwd, 'UTF-8');
            $passwd_text = str_repeat("＊", $passwd_len);
            return $passwd_text;
        }
        function time_logout($first_login_date) {// 24時を過ぎると自動でログアウトするための関数
            global $today;
            $today_date = date('Y/m/d', strtotime($today));
            if ($today_date !== $first_login_date){
                http_response_code( 301 ) ;
                header( "Location: http://localhost:8888/user/index.php" ) ;
                exit ;
            }
        }
        function check_upd_deletedmail($mail) {// すでに削除済みのアドレスには、ログイン後変更できないようにする関数
            try {
                global $db_dsn, $db_user, $db_password;
                $db = new PDO($db_dsn, $db_user, $db_password);

                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                $sql = "SELECT * from users WHERE mail =  :mail";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':mail', $mail);
                $stmt->execute();
                } catch (PDOException $error) {
                    echo "error" . $error->getMessage();
                }
                $data = $stmt->fetchAll();
                $del = array_column($data, 'del');

                // return $del[0];
                
            if ($del[0] == 1){
                $_SESSION["signup"] = "failure";
                http_response_code( 301 ) ;
                header( "Location: http://localhost:8888/user/index.php" ) ;
                exit ;
            }
        }
        function dbdel($mail) {// 削除するための関数
            try {
                global $db_dsn, $db_user, $db_password,$cipher, $key;


                $db = new PDO($db_dsn, $db_user, $db_password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

                $sql = "UPDATE users 
                        SET del = TRUE
                        WHERE mail = :mail ";
                $stmt = $db->prepare($sql);
                //$stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $error) {
                echo "error" . $error->getMessage();
            }
        }
        function db_mail_check($mail) {//登録済みのメールアドレスの数をカウントするための関数
            try {
                global $db_dsn, $db_user, $db_password;
                $db = new PDO($db_dsn, $db_user, $db_password);

                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                $sql = "SELECT COUNT(*) FROM users WHERE mail = :mail";
                $stmt = $db->prepare($sql);
                $stmt->bindValue(':mail', $mail);
                $stmt->execute();

                } catch (PDOException $error) {
                    echo "error" . $error->getMessage();
                }
                // SQLより取り出したデータを配列に格納
                  $data = $stmt->fetchAll();
                  $count = array_column($data, 'COUNT(*)');

                 return $count[0];

        }
        function dbin($name, $mail, $passwd, $today) {//データベースに登録するための関数
            try {
                global $db_dsn, $db_user, $db_password,$cipher, $key;
                //$hash = password_hash($passwd, PASSWORD_DEFAULT);
                $cryptography_passwd = openssl_encrypt($passwd, $cipher, $key);


                $db = new PDO($db_dsn, $db_user, $db_password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "INSERT INTO users (name, mail, password, create_date) VALUES (:name, :mail, :passwd, :today)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindParam(':passwd', $cryptography_passwd, PDO::PARAM_STR);
                $stmt->bindParam(':today', $today, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $error) {
                echo "error" . $error->getMessage();
            }
        }
        
        function dbsel($mail) { //登録情報を参照するための関数
            try {
                global $db_dsn, $db_user, $db_password;
                $db = new PDO($db_dsn, $db_user, $db_password);

                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                $sql = "SELECT * from users WHERE mail =  :mail";
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

                 return array('name'=>$name_db[0], 'mail'=>$mail_db[0], 'passwd'=>$passwd_db[0]);
        }
        function dbupd($id, $name, $mail, $passwd) {//登録情報を更新するための関数
            try {
                global $db_dsn, $db_user, $db_password,$cipher, $key;
                $cryptography_passwd = openssl_encrypt($passwd, $cipher, $key);


                $db = new PDO($db_dsn, $db_user, $db_password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "UPDATE users 
                        SET name = :name, mail = :mail, password = :passwd
                        WHERE id = :id ";        

                $stmt = $db->prepare($sql);
                $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
                $stmt->bindParam(':passwd', $cryptography_passwd, PDO::PARAM_STR);

                $stmt->execute();
            } catch (PDOException $error) {
                echo "error" . $error->getMessage();
            }
        }
        function dbin_log($id, $name_before, $mail_before, $passwd_before, $name_after, $mail_after, $passwd_after) {//登録情報を変更した際に、ログテーブルに記録を残すための関数
                global $cipher, $key;
                $change_item_array = array();
                $change_before_array = array();
                $change_after_array = array();
                $number = 0;
                $passwd_after_en = openssl_encrypt($passwd_after, $cipher, $key);
                
                if ($name_before !== $name_after) {
                    $change_item_array[] = "name";
                    $change_before_array[] = $name_before;
                    $change_after_array[] = $name_after;
                    $number ++;
                }
                if ($mail_before !== $mail_after) {
                    $change_item_array[] = "mail";
                    $change_before_array[] = $mail_before;
                    $change_after_array[] = $mail_after;
                    $number ++;
                }
                if ($passwd_before !== $passwd_after_en) {
                    $change_item_array[] = "password";
                    $change_before_array[] = $passwd_before;
                    $change_after_array[] = $passwd_after_en;
                    $number ++;
                }
                $change_item =  implode(',', $change_item_array); 
                $change_before = implode(',', $change_before_array); 
                $change_after = implode(',', $change_after_array); 

                if ($number !== 0) {
                    try {
                        global $db_dsn, $db_user, $db_password, $today;
                        //$cryptography_passwd = $name_before_en;

                        // echo "ふぁんく".$id. $change_item. $change_before. $change_after. $today."<br>";
                        $db = new PDO($db_dsn, $db_user, $db_password);
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                        $sql = "INSERT INTO userlog (user_id, change_item, change_before, change_after, change_date) VALUES (:user_id, :change_item, :change_before, :change_after, :change_date)";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':user_id', $id, PDO::PARAM_STR);
                        $stmt->bindParam(':change_item', $change_item, PDO::PARAM_STR);
                        $stmt->bindParam(':change_before', $change_before, PDO::PARAM_STR);
                        $stmt->bindParam(':change_after', $change_after, PDO::PARAM_STR);
                        $stmt->bindParam(':change_date', $today, PDO::PARAM_STR);
                        $stmt->execute();
                    } catch (PDOException $error) {
                        echo "error" . $error->getMessage();
                    }                    
                }
                

        }

 ?>