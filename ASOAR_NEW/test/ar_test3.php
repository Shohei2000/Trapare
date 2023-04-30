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
        <a-light type="directional" color="#FFF" intensity="0.5" position="-1 1 2"></a-light>
        <a-light type="ambient" color="#FFF"></a-light>
        <a-camera position="0 1 4" cursor-visible="true" cursor-scale="2" cursor-color="#0095DD" cursor-opacity="0.5"></a-camera>
        <a-cube color="#0095DD" rotation="20 40 0" position="0 1 0">
          <a-animation attribute="rotation" from="20 0 0" to="20 360 0" direction="alternate" dur="4000" repeat="indefinite" easing="ease"></a-animation>
        </a-cube>
        <a-entity geometry="primitive: torus; radius: 1; radiusTubular: 0.1; segmentsTubular: 12;" material="color: #EAEFF2; roughness: 0.1; metalness: 0.5;" rotation="10 0 0" position="-3 1 0">
        <a-animation attribute="scale" to="1 0.5 1" direction="alternate" dur="2000" repeat="indefinite" easing="linear"></a-animation>
        </a-entity>
      </a-scene>
      
  </body>
    
</html>