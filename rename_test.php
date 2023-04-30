<!DOCTYPE html>
<html>
    <head>    
    </head>

    <body>
        <?php
            $uploadfile = '/var/www/html/scripts/examples/images/yamaguchi_concat.jpg';
            if(substr($uploadfile, -3) == "png"){
                    return;
                }else{
                    $name = strstr($uploadfile, '.', true);
                    $newName = $name.'.png';
                    rename( $uploadfile, $newName );
                }
        ?>
    </body>
</html>