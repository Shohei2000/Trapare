<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>ImageUpload</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    </head>
    <body>
        <!--HTML部分-開始-->
        <div class="container" style="text-align:center; margin-top:10vh;">
            <div class="row">
                <div class="col-sm-12">
                    <img src='./scripts/examples/hologram/<?php echo $_SESSION['file_name']; ?>' alt="ARMarker" width="400px">
                </div>
                <div class="col-sm-12">
                    <a><?php echo $_SESSION['file_name']; ?></a>
                </div>
                <div class="col-sm-12">
                <a href="./scripts/examples/hologram/<?php echo $_SESSION['file_name']; ?>">画像を拡大</a>
                    <span>/</span>
                    
                    <!--<a href="./scripts/examples/skepng/<?php echo $_SESSION['file_name']; ?>">透過pngを拡大</a>-->
                    
                    <br>
                    
                    <a href="./scripts/examples/hologram/<?php echo $_SESSION['file_name']; ?>" download="<?php echo $_SESSION['file_name']; ?>">画像を保存</a>
                    <span>/</span>
                    
                    <!--<a href="./scripts/examples/skepng/<?php echo $_SESSION['file_name']; ?>" download="<?php echo $_SESSION['file_name']; ?>">透過pngを保存</a>
                    <span>/</span>-->
                    <a href="HoloNo.php">トップへ戻る</a>
                    
                </div>
            </div>
        </div>
        <!--HTML部分-終了-->
    </body>
    
<script>
 window.onload=function(){
   window.addEventListener("keydown",reloadoff,false);
 }

 function reloadoff(evt){
   evt.preventDefault();
 }
</script>
    
</html>