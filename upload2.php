<?php 
    session_start();
    $_SESSION = array();	// セッション変数を全てクリア
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TestFile_Upload</title>
    </head>
    <body>
        <?php
            // ファイルへのパス
            $path = './scripts/examples/images/';
            $path2 = '/var/www/html/scripts/examples/images/';

            $uploadfile = $path . basename($_FILES['file1']['name']);
            $uploadfile2 = $path2. basename($_FILES['file1']['name']);

            $_SESSION['file_name'] = $_FILES['file1']['name'];

            var_dump($_FILES);
            echo '<br>';

//             ファイルを指定したパスへ保存する
                if( move_uploaded_file( $_FILES['file1']['tmp_name'], $uploadfile2) ) {
                    echo '　アップロードされたファイルを保存しました。';
                    echo "1".$uploadfile;
                    echo "2".$uploadfile2;
                    echo "3".basename($_FILES['file1']['name']);
                    echo "4".basename($_FILES['file1']['error']);
                    ?>
                        <br>
                        <img src='<?php echo $uploadfile; ?>' alt="UploadFile" width="300px">
<!--
                        <form action="remove_bg.php" method="post">
                            <input type="submit" name="submit" value="透過開始">
                        </form>
-->
<!--            type=button-->
            <input type="button" name="submit" value="透過開始" onclick="location.href='./remove_bg.php'">
                    <?php
                } else {
                    echo 'アップロードされたファイルの保存に失敗しました。';

            //デバッグ用
                    echo "1".$uploadfile;
                    echo "2".$uploadfile2;
                    echo "3".basename($_FILES['file1']['name']);
                    echo "4".basename($_FILES['file1']['error']);
                }
                $_FILES = array(); //初期化
        		$_FILES = null;
        ?>
    </body>
</html>