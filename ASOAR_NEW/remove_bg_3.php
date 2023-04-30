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
                "img_name":"{$_SESSION['file_name']}",
                "x_axis":"{$_SESSION['x_axis']}",
                "y_axis":"{$_SESSION['y_axis']}",
                "z_axis":"{$_SESSION['z_axis']}",
                "x_axis_cm":"{$_SESSION['x_axis_cm']}",
                "y_axis_cm":"{$_SESSION['y_axis_cm']}",
                "z_axis_cm":"{$_SESSION['z_axis_cm']}",
                "transparent":"0"
            }
            EOM;

            $data = json_decode($obj,true);

            #保存場所
            $json = fopen('/var/www/html/ASOAR_NEW/getFunction.json', 'w+b');

            #日本語変換
            fwrite($json, json_encode($data, JSON_UNESCAPED_UNICODE));
            fclose($json);

            try {
                $command = "sudo python3 /var/www/html/ASOAR_NEW/QR_make.py";
                exec($command,$output);
                
                $url = "./ASOAR_ImageShow3.php";
                header( "Location:$url") ;
                ?>
        
                <?php

            } catch (Exception $e) {
                echo $e;
            }

        ?>
    </body>
</html>