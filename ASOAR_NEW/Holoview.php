<?php require './require/header1.php';?>
<?php require './require/nav3.php';?>

<div class="container">
	<div class="row" style="text-align: center; justify-content: center;">
		<form method="POST" action="./Holoview2.php" enctype="multipart/form-data" style="display: contents;">    
			<div class="col-sm-12" style="margin: 3vh 0;">
        <input type="hidden" name="hidden1" id="hidden1">
        <input type="hidden" name="hidden2" id="hidden2">
        <input type="hidden" name="hidden3" id="hidden3">
        <input type="hidden" name="hidden4" id="hidden4">
				<input type="file" id="file" name="file" accept="image/*"
					onchange="previewImage(this);" onload="putAxis();"
					style="text-align-last: center;"> <input type="submit"
					id="buttonSubmit" value="透過開始" style="display: none;"
                    class="btn btn-primary btn-lg">
			</div>
      <div class="col-xs-12 col-sm-12 col-md-12">
        <ul style="display:flex; justify-content:center; padding:0px;">
          <li>R: <span id="r"></span></li>
          <li>G: <span id="g"></span></li>
          <li>B: <span id="b"></span></li>
          <li class="display_none">A: <span id="a"></span></li>
        </ul>
      </div>
    </form>
    <div class="col-sm-12" style="margin: 1em;">
			<img id="tgt-img" src="" onload="putAxis();" style="border:1px solid black; width:40vw;">
		</div>
  </div>
</div>

<script>
  var pre_x = 0;
	var pre_y = 0;
	var pre_z = 0;
    
  var image = document.getElementById( 'tgt-img' );
  image.crossOrigin = '' // デモ用に外部から画像を取得するため

  let context = null;
    
  var canvas = document.createElement('canvas');

imgElement.onload = () => {
  // canvas 要素に画像を描画
  const canvas = document.createElement('canvas');
  canvas.width = imgElement.width;
  canvas.height = imgElement.height;
  context = canvas.getContext('2d');
  context.drawImage(imgElement,0,0, imgElement.width, imgElement.height);
  // 初期化時、画像クリック時に画像中の色情報を取得する関数を実行
  getColor();
  imgElement.addEventListener('click',e=>getColor(e.offsetX, e.offsetY));
}

  var r;        
  var g;
  var b;
  var a;

  function getColor(x=0,y=0){
    // canvas 中の座標を指定して該当部の色情報を取得
    var imgData = context.getImageData(x,y,1,1);

    r = imgData.data[0];        
    g = imgData.data[1];
    b = imgData.data[2];
    a = imgData.data[3];

    document.querySelector('#r').innerText = r;
    document.querySelector('#g').innerText = g;  
    document.querySelector('#b').innerText = b;  
    document.querySelector('#a').innerText = a;

    document.getElementById( "hidden1" ).value =r;
    document.getElementById( "hidden2" ).value =g;
    document.getElementById( "hidden3" ).value =b;
    document.getElementById( "hidden4" ).value =a;
  }

  function putAxis()
    {
      //色取得
            
      // canvas 要素に画像を描画
      canvas.width = image.width;
      canvas.height = image.height;
      context = canvas.getContext('2d');
      context.drawImage(image,0,0, image.width, image.height);
      // 初期化時、画像クリック時に画像中の色情報を取得する関数を実行
      getColor();
      image.addEventListener('click',e=>getColor(e.offsetX, e.offsetY));
    }

  function previewImage(obj){

    var image = document.getElementById( 'tgt-img' );

    var fileReader = new FileReader();
    fileReader.onload = (function() {
    	image.src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);

    const buttonSubmit = document.getElementById("buttonSubmit");
    buttonSubmit.style.display = "inline";

  }

</script>
<style>
/*リスト*/
ul {
	list-style: none;
}

li {
	float: left;
	padding: 0 1vw;
}

.textAxis, .textAxis_cm {
	width: 5vw;
}

.textAxis {
	color: darkgray;
}
    .display_none{
        display: none;
    }
</style>
</html>
