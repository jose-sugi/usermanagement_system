 <?php 
include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
  ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/ja.js"></script>
 <script type="text/javascript">
         function check_signup(){//「送信」ボタンを押下したときポップアップ表示で確認するための関数（繰り返し機能offのとき）
            select = confirm("こちらの内容で登録しますか？");
            return select;
         }	
         function signup_alert() {
         	alert("※登録できませんでした。\nこのメールアドレスはすでに登録済みです。");
         }
        function check_input(obj) {//件名と本文に空文字が入っていたときに、アラート表示させるための関数
             text_value = document.form1[obj].value;
             text_length = text_value.length;
 
             if (text_length >= <?php echo $max_name_length; ?> && obj == "name") {
                 alert("【注意】名前は<?php echo $max_name_length; ?>文字以下でお願いいたします");
             }
            
             if (text_length >= <?php echo $max_mail_length; ?> && obj == "mail") {
                 alert("【注意】メールアドレスは<?php echo $max_mail_length; ?>文字以下でお願いいたします");
             }

             if (!text_value.match(/\S/g)) {
                 alert("【注意】文字を入力してください");
             }
         }
        function conf_change(){//「送信」ボタンを押下したときポップアップ表示で確認するための関数（繰り返し機能offのとき）
            select = confirm("登録内容を変更しますか？");
            return select;
        }
        function conf_delete(){//「送信」ボタンを押下したときポップアップ表示で確認するための関数（繰り返し機能offのとき）
            select = confirm("登録内容を削除しますか？");
            return select;
        }
        function check_signup_submit() {
            mail_value = document.form1.mail.value;
            mail_length = mail_value.length;
            pass_value = document.form1.passwd.value;
            pass_length = pass_value.length;

            if (mail_length >= <?php echo $max_mail_length; ?>) {
                alert("【注意】<?php echo $max_mail_length; ?>文字以下でお願いいたします");
                return false;
                }
            if (!mail_value.match(/\S/g)) {
                alert("【注意】文字を入力してください");
                return false;
                }
            if (pass_length < 6) {
                alert("【注意】パスワードは6桁以上です");
                return false;
                } 
            if (pass_length > 10) {
                alert("【注意】パスワードは10桁以下です");
                return false;
                }
            if(!pass_value.match(/^[a-z0-9]*$/)){
                alert("【注意】パスワードは半角英数字です");
                return false;
                }
        }
 </script>