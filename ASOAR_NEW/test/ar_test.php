<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <script src="https://aframe.io/releases/1.2.0/aframe.min.js"></script>
      
    <script type="module">
      import { sleep } from "https://code4sabae.github.io/js/sleep.js";

      window.onload = () => {
        document.body.onclick = async () => {
          tower.setAttribute("position", { x:0, y:10, z:0 });
          await sleep(500);
          tower.setAttribute("position", { x:0, y:0, z:0 });
        };
      };
    </script>
      
  </head>
  <body>
    <a-scene id="scene">
      <a-entity position="0 0 -50">
        <a-box position="0 -.5 0" width="80" height="1" depth="100" color="gray"></a-box>
        <a-cone color="green" position="0 1 0" radius-bottom="18" radius-top="15" height="2"></a-cone>

        <a-entity id="tower" animation="property:rotation; to:0 360 0; dur:20000; easing:linear; loop:true">
          <a-cone color="white" position="0 35 0" radius-bottom="10" radius-top="3" height="70"></a-cone>
          <a-cone color="white" position="-15 24 0" rotation="0 0 70" radius-bottom="8" radius-top="1" height="35"></a-cone>
          <a-cone color="white" position="15 24 0" rotation="0 0 -70" radius-bottom="8" radius-top="1" height="35"></a-cone>
          <a-cylinder color="gold" position="0 60 5" rotation="90 0 0" radius="6" height=".5"></a-cylinder>>
          <a-cylinder color="#ccc" position="0 20 8" rotation="90 0 0" radius="5" height="1"></a-cylinder>>
        </a-entity>

        <a-box position="39 35 0" width="2" height="70" depth="2" color="red"></a-box>
        <a-text position="42 35 0" width="120" color="red" rotation="0 0 0" value="70m"></a-text>

      </a-entity>
      <a-sky color="#cef"></a-sky>

    </a-scene>
  </body>
</html>