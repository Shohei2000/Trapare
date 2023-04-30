<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ASOAR</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
        <?php        
            #json書き込み
            $obj = <<< EOM
            {
                "img_name":"{$_SESSION['file_name']}"
            }
            EOM;

            $data = json_decode($obj,true);

            #保存場所
            $json = fopen('/var/www/html/ASOAR_NEW/getFunction.json', 'w+b');

            #日本語変換
            fwrite($json, json_encode($data, JSON_UNESCAPED_UNICODE));
            fclose($json);

            try {
                
                #$command = "sudo python3 /var/www/html/ASOAR_NEW/resize_Y.py";
                #exec($command,$output);

                #$command2 = "sudo python3 /var/www/html/ASOAR_NEW/remove_bg.py";
                #exec($command2,$output);

                #$command3 = "sudo python3 /var/www/html/ASOAR_NEW/scripts/demo.py";
                #exec($command3,$output);

                #$command4 = "sudo python3 /var/www/html/ASOAR_NEW/HoloTp.py";
                #exec($command4,$output);

                $command5 = "sudo python3 /var/www/html/ASOAR_NEW/hologramNo.py";
                exec($command5,$output);
                                
                $url = "./HoloNoShow.php";
                header( "Location:$url") ;
                ?>
        
<!--        HTML部分-開始-->
<!--
        <div class="container" style="text-align:center; margin-top:10vh;">
            <div class="row">
                <div class="col-sm-12">
                    <img src='./scripts/examples/armarker.png' alt="ARMarker" width="300px">
                </div>
                <div class="col-sm-12">
                    <a href="./scripts/examples/armarker.png" download="<?php echo $_SESSION['file_name']; ?>">画像を保存</a>
                    <span>/</span>
                    <a href="ASOAR_ImageUpdate.php">トップへ戻る</a>
                </div>
            </div>
        </div>
-->
<!--        HTML部分-終了-->
        
                <?php

            } catch (Exception $e) {
                echo $e;
            }
            print "$output[0]";
            print "$output[1]";
            print "$output[2]";
            print "$output[3]";
            print "$output[4]";

        ?>
    </body>
</html>

<!--変更しちゃダメ!!-->