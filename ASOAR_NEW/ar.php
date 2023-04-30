<?php
$height = $_REQUEST['y_cm'];
$width = $_REQUEST['x_cm'];

$true_height = $height/3;
$true_width = $width/3;

$pos_y = 0.000;


$id = $_REQUEST['name'];
$x = $_REQUEST['x'];
$y = $_REQUEST['y'];
$z = $_REQUEST['z'];
$x_cm = $_REQUEST['x_cm'];
$y_cm = $_REQUEST['y_cm'];
$z_cm = $_REQUEST['z_cm'];
$flag = $_REQUEST['flag'];

//厚みがもし初期値の0だった場合は、1を設定してあげる
if($_REQUEST['z_cm'] == 0){
    $z_cm = 1;
}else{
    $z_cm =  $_REQUEST['z_cm'] * 10;
}

$url = "./ar2.php?name=".$id."&x=".$x."&y=".$y."&z=".$z."&x_cm=".$x_cm."&y_cm=".$y_cm."&z_cm=".$z_cm."&flag=".$flag;

//画像が透過されているか判断、flag=0は透過されていない
if($flag == 0){
    $img_pass =  "./scripts/examples/images/".$id;
}else{
    $img_pass =  "./scripts/examples/skepng/".$id;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AR_Camera</title>
        
        <script src="https://aframe.io/releases/0.8.2/aframe.min.js"></script>
        <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.6.2/aframe/build/aframe-ar.js"></script>

    </head>

    <body style='margin: 0; overflow: hidden;'>

<!--        <a class="backButton" href="./ASOAR_ImageUpdate.php">＜ BACK</a>-->

        <div class="switch">
            <a id="swMarker" class="swItem current"><img src="./sources/armarker_img.png" width="40%"></a>
            <a id="swGyro" class="swItem no_current" href="<?php echo $url; ?>"><img src="./sources/gyro_img.png" width="40%"></a>
        </div>

        <a-scene embedded arjs="debugUIEnabled: false" device-orientation-permission-ui="enabled: false" vr-mode-ui="enabled: false">

            <a-assets timeout="9000">
                <img id="img" src="<?php echo $img_pass; ?>" side="double">
            </a-assets>

            <a-camera-static material="" camera="" data-aframe-inspector-original-camera="">

            </a-camera-static>

            <a-marker type="pattern" url="./scripts/examples/important/pattern-go.patt">
                <a-entity position="0 0 0" visible="">
                    <?php
                        for($i = 0; $i < $z_cm; $i++){
                    ?>
                    <a-entity position="0 <?php echo $pos_y;?> 0" rotation="-90 0 0" material="src: #img; transparent: true; side:double;" geometry="primitive: plane; height:<?php echo $true_height; ?>; width:<?php echo $true_width; ?>;" src="#img" visible="">
                    </a-entity>
                    <?php
                        $pos_y = $pos_y + (0.003);
                        }
                    ?>
                </a-entity>
            </a-marker>

        </a-scene>

        <?php
            // デバッグ用
//            echo $id;
//            echo $x
//            echo $y
//            echo $z
//            echo './scripts/examples/skepng/'.$id;
        ?>

    </body>

<style>
.backButton {
	position: fixed; /* 要素の位置を固定する */
	top: 0; /* 基準の位置を画面の一番下に指定する */
	left: 0; /* 基準の位置を画面の一番右に指定する */
	padding: 0.5em;
	text-align: center;
	opacity: 0.7;
	font-size: small;
	text-shadow: 1px 1px 1px #fff, -1px 1px 1px #fff, 1px -1px 1px #fff,
		-1px -1px 1px #fff;
	z-index: 3;
}

.switch {
	position: fixed; /* 要素の位置を固定する */
	top: 0; /* 基準の位置を画面の一番下に指定する */
	right: 1vh; /* 基準の位置を画面の一番右に指定する */
	width: 16vw;
	padding: 0.3em;
	text-align: center;
	opacity: 0.7;
	background: darkgray;
	border-radius: 0em 0em 0.7em 0.7em; /* 左上、右上、右下、左下 */
	z-index: 2;
}

.swItem {
	padding: 0 0.1em;
}

    .current {
        opacity: 1;
    }
    .no_current {
        opacity: 0.5;
    }

a, a:hover {
	text-decoration: none;
	color: black;
}
</style>
</html>