<!DOCTYPE html>
<html>
    <head>
<!--
        <meta charset="UTF-8">
        <title>ARカメラ</title>
-->
      <!-- ① スクリプトの読み込み -->
      <script src="https://aframe.io/releases/0.8.2/aframe.min.js"></script>
      <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.6.2/aframe/build/aframe-ar.js"></script>
    
    </head>

    <body style='margin: 0; overflow: hidden;'>
    
        <a-scene embedded arjs="debugUIEnabled:false;">
            
            <a-marker type='pattern' url='./scripts/examples/pattern-go.patt'>
                <a-image id="icon_4b_128" src="./scripts/examples/<?php echo $_REQUEST['name']; ?>" position="0 0 0" rotation="-90 0 0">
            </a-marker>
                
            <a-entity camera></a-entity>
        </a-scene>
        <?php
            echo $_REQUEST['name'];
        ?>
        
    
<!--
        <h1>デバッグ</h1>
        <img src="./scripts/examples/fukuhara.png" alt="QRImage" width="300px">
-->
    </body>
</html>