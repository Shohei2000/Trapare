<!DOCTYPE html>
<html>
  <head>
      
    <title>Hello, WebVR! - A-Frame</title>
    <meta name="description" content="Hello, WebVR! - A-Frame">
      
    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
    <!--three.ar.jsとaframe-ar.jsを追加(下記2行)-->
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/aframe/build/aframe-ar.js"></script> 
    <script src="https://raw.githack.com/AR-js-org/AR.js/master/three.js/build/ar-nft.js"></script> 
      
  </head>
    
  <body>
      
    <!--a-sceneの次にarと書き加えることでAR機能が使える-->
    <a-scene>
      <a-cylinder position="0 0 -1" radius="0.2" height="0.5" color="#FFC65D" shadow></a-cylinder>
      <!--カメラの子要素に空文字を追加。常に何かが描画されていないと画面が真っ白になるため-->
      <a-entity camera>
        <a-text position="0 0 -1"></a-text>
      </a-entity>
    </a-scene>
      
  </body>
    
</html>