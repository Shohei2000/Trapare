<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>TestFile_Upload</title>
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
            $json = fopen('/var/www/html/getFunction.json', 'w+b');

            #日本語変換
            fwrite($json, json_encode($data, JSON_UNESCAPED_UNICODE));
            fclose($json);

            try {
                
//                $command = "sudo python3 /var/www/html/resize_Y.py";
//                exec($command,$output);

                $command2 = "sudo python3 /var/www/html/remove_bg.py";
                exec($command2,$output);

                $command3 = "sudo python3 /var/www/html/scripts/demo.py";
                exec($command3,$output);

                $command4 = "sudo python3 /var/www/html/remove_bg2.py";
                exec($command4,$output);

                $command5 = "sudo python3 /var/www/html/concat.py";
                exec($command5,$output);

                ?>
                    <img src='./scripts/examples/images/<?php echo $_SESSION['file_name']; ?>' alt="Images" width="300px">
                    <img src='./scripts/examples/trimaps/<?php echo $_SESSION['file_name']; ?>' alt="Trimap" width="300px">
                    <img src='./scripts/examples/mattes/<?php echo $_SESSION['file_name']; ?>' alt="Mask" width="300px">
                    <img src='./scripts/examples/<?php echo $_SESSION['file_name']; ?>' alt="DonePhoto" width="300px">
                    <br>
                    <img src='./scripts/examples/qr/<?php echo $_SESSION['file_name']; ?>' alt="QRImage" width="300px">
                    <img src='./scripts/examples/armarker.png' alt="ARMarker" width="300px">
                    <br>
                    <a href="index.html">トップへ戻る</a>
                <?php

            } catch (Exception $e) {
                echo $e;
            }

            print "$output[0]";
            print "$output[1]";
            print "$output[2]";
            print "$output[3]";
            print "$output[4]";
            print "$output[5]";
            print "$output[6]";
            print "$output[7]";
            print "$output[8]";
            print "$output[9]";
        ?>
    </body>
</html>