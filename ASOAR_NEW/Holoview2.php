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
            //pngか判断するboolean型
            $flag = true;
        
            // ファイルへのパス        
            $path = './scripts/examples/images/';
            $path2 = '/var/www/html/ASOAR_NEW/scripts/examples/images/';

            $uploadfile = $path . basename($_FILES['file']['name']);
            $uploadfile2 = $path2. basename($_FILES['file']['name']);

            if(substr($_FILES['file']['name'], -3) == "png"){
                $_SESSION['file_name'] = $_FILES['file']['name'];
            }else{
                $name = strstr($_FILES['file']['name'], '.', true);
                $newName = $name.'.png';
                $_SESSION['file_name'] = $newName;
                $flag = false;
            }
        
            $_SESSION['hidden1'] = $_REQUEST[hidden1];
            $_SESSION['hidden2'] = $_REQUEST[hidden2];
            $_SESSION['hidden3'] = $_REQUEST[hidden3];
            $_SESSION['hidden4'] = $_REQUEST[hidden4];

            echo '<br>';

//             ファイルを指定したパスへ保存する
                if( move_uploaded_file( $_FILES['file']['tmp_name'], $uploadfile2) ) {
                    
                    ?>
<!--                        <input type="button" name="submit" value="透過開始" onclick="location.href='./remove_bg.php'">-->
                    <?php
                    
//                        ファイルの拡張子をPNGに変更する
                        $uploadfile3 = $path2. $_SESSION['file_name'];
                    
                        if($flag == false){
                            rename( $uploadfile2, $uploadfile3 );
                        }
                    
                        header( "Location: ./Holoajax.php" ) ;
                    
                } else {
                    echo 'アップロードされたファイルの保存に失敗しました。';
                }
                $_FILES = array(); //初期化
        		$_FILES = null;
        ?>
    </body>
</html>