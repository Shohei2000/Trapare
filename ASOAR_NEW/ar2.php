<?php
$height = $_REQUEST['y_cm'];
$width = $_REQUEST['x_cm'];

$true_height = $height/10;
$true_width = $width/10;

$pos_y = ($true_height / 3);
$pos_z = 0.000;

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

$url = "./ar.php?name=".$id."&x=".$x."&y=".$y."&z=".$z."&x_cm=".$x_cm."&y_cm=".$y_cm."&z_cm=".$z_cm."&flag=".$flag;

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
        
        <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
        <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.6.2/aframe/build/aframe-ar.js"></script>
        
    </head>

    <body style='margin: 0; overflow: hidden;'>

<!--        <a class="backButton" href="./ASOAR_ImageUpdate.php">＜ BACK</a>-->

        <div class="switch">
            <a id="swMarker" class="swItem no_current" href="<?php echo $url; ?>"><img src="./sources/armarker_img.png" width="40%"></a>
            <a id="swGyro" class="swItem current"><img src="./sources/gyro_img.png" width="40%"></a>
        </div>
        
        <a-scene embedded arjs="debugUIEnabled: false">
            <a-assets timeout="9000">
                <img id="img" src="<?php echo $img_pass; ?>">
            </a-assets>
            
            <a-entity light="type: ambient; color: #BBB"></a-entity>
            <a-entity light="type: directional; color: #FFF; intensity: 0.35" position="-2 10 5"></a-entity>
            <a-entity light="type: directional; color: #FFF; intensity: 0.17" position="0 -4 1"></a-entity>
            
            <a-camera scale="1 1 1.5" position="0 0.5 4"></a-camera>
            
            <a-entity position="0 0 0" visible="">
                
                <?php
                    for($i = 0; $i < $z_cm; $i++){
                        
                        ?>
                            <a-entity scale="1 1 3" position="0 <?php echo $pos_y;?>  <?php echo $pos_z;?>" rotation="0 0 0" material="src: #img; transparent: true; side:double;" geometry="primitive: plane; height:<?php echo $true_height; ?>; width:<?php echo $true_width; ?>;" src="#img" visible=""></a-entity>
                            
                        <?php
                            $pos_z = $pos_z + (-0.003);
                    }
                ?>
                
            </a-entity>
                        
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
	padding: 0.3em;
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
    
    <script>
      var scene = document.querySelector("a-scene");
      var hitTest = document.querySelector("#hitTest");
      var button = document.querySelector("#button");

      button.addEventListener("click", function() {
        let box = document.createElement("a-box");
        box.setAttribute("color", "cyan" );
        box.setAttribute("position", new THREE.Vector3(0, 0.05, 0).add(hitTest.object3D.position));
        box.setAttribute("rotation", hitTest.getAttribute("rotation"));
        box.setAttribute("scale", "0.1 0.1 0.1");
        scene.appendChild(box);
      });
    </script>
    
</html>