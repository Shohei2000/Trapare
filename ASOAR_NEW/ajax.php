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
            $img_name = $_SESSION['file_name'];
            $r = $_SESSION['hidden1'];
            $g = $_SESSION['hidden2'];
            $b = $_SESSION['hidden3'];
            $a = $_SESSION['hidden4'];
            $x_axis = $_SESSION['x_axis'];
            $y_axis = $_SESSION['y_axis'];
            $z_axis = $_SESSION['z_axis'];
            $x_axis_cm = $_SESSION['x_axis_cm'];
            $y_axis_cm = $_SESSION['y_axis_cm'];
            $z_axis_cm = $_SESSION['z_axis_cm'];
        

            #json書き込み
            $obj = <<< EOM
            {"r":"{$r}",
            "g": "{$g}",
            "b": "{$b}",
            "a": "{$a}",
            "x_axis":"{$_SESSION['x_axis']}",
            "y_axis":"{$_SESSION['y_axis']}",
            "z_axis":"{$_SESSION['z_axis']}",
            "x_axis_cm":"{$_SESSION['x_axis_cm']}",
            "y_axis_cm":"{$_SESSION['y_axis_cm']}",
            "z_axis_cm":"{$_SESSION['z_axis_cm']}",
            "img_name": "{$img_name}",
            "transparent": "1"
            }
            EOM;

            $data = json_decode($obj,true);

            #保存場所
            $json = fopen('/var/www/html/ASOAR_NEW/getFunction2.json', 'w+b');

            #日本語変換
            fwrite($json, json_encode($data, JSON_UNESCAPED_UNICODE));
            fclose($json);

            try{
                
                #python 呼び出し
                $command = "sudo python3 /var/www/html/ASOAR_NEW/sub2main.py";
                exec($command,$output);
                
                $url = "./ASOAR_ImageShow2.php";
                header( "Location:$url") ;
                
            } catch (Exception $e) {
                echo $e;
            }
        
            print "$output[0]";
            print "$output[1]";
            print "$output[2]";
        ?>
    </body>
</html>