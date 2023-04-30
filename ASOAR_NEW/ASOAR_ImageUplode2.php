<?php require './require/header1.php';?>
<?php require './require/nav2.php';?>


<div class="container-fluid">
	<div class="row" style="text-align: center; justify-content: center;">
		<form method="POST" action="./upload2.php" enctype="multipart/form-data" style="display: contents;">
            
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
            <div class="col-xs-12 col-sm-12 col-md-6">
                <ul style="display:flex; justify-content:center; padding:0px;">
                        <li>R: <span id="r"></span></li>
                        <li>G: <span id="g"></span></li>
                        <li>B: <span id="b"></span></li>
                        <li class="display_none">A: <span id="a"></span></li>
                </ul>
            </div>
			<div class="col-xs-12 col-sm-12 col-md-7">
				<div class="row">
					<div class="col-sm-12" style="margin: 0.5em; display:flex; justify-content: center;">
						<ul
							style="display:flex; align-items: center; margin-bottom: 0px; padding:0;">
							<!--                        To-do 入力値が数字だけに設定する(バリデーション)-->
							<li><a>cm</a></li>
							<li><span>縦：</span> <input class="textAxis_cm" id="y_axis_cm"
								type="text" name="y_axis_cm" placeholder="0cm" value="0"
								disabled></li>
							<li><span>横：</span> <input class="textAxis_cm" id="x_axis_cm"
								type="text" name="x_axis_cm" placeholder="0cm" value="0"
								disabled></li>
							<li><span>奥行：</span> <input class="textAxis_cm" id="z_axis_cm"
								type="text" name="z_axis_cm" placeholder="0cm" value="0"
								disabled></li>
						</ul>
					</div>
					<!-- col-sm-12 -->
                    <div class="col-sm-12" style="margin: 0.5em; display:flex; justify-content: center;">
						<ul
							style="display: flex; align-items: center; margin-bottom: 0px; padding:0; color: darkgray;">
							<!--                        To-do 入力値が数字だけに設定する(バリデーション)-->
							<li><a>px</a></li>
							<li><span>縦：</span> <input class="textAxis" id="y_axis"
								type="text" name="y_axis" placeholder="0cm" value="0"
								readonly="readonly"></li>
							<li><span>横：</span> <input class="textAxis" id="x_axis"
								type="text" name="x_axis" placeholder="0cm" value="0"
								readonly="readonly"></li>
							<li><span>奥行：</span> <input class="textAxis" id="z_axis"
								type="text" name="z_axis" placeholder="0cm" value="0"
								readonly="readonly"></li>
						</ul>
					</div>
					<!-- col-sm-12 -->
				</div>
				<!-- row -->
			</div>
			<!-- col-sm-8 -->
			<div class="col-xs-12 col-sm-12 col-md-5">
				<div class="row" style="height: 100%;">
					<div class="col-sm-12" style="height: 50%;">
						<div class="btn-group" role="group">
                            <input
								type="button" id="buttonZoomIn1" onclick="changeZoomIn1();"
								value="× 1.2" style="" disabled
                                class="btn btn-secondary">
                            <input
								type="button" id="buttonZoomOut1" onclick="changeZoomOut1();"
								value="× -1.2" style="" disabled
                                class="btn btn-secondary">
						</div>
					</div>
					<div class="col-sm-12" style="height: 50%;">
						<div class="btn-group" rolo="group">
							<input
								type="button" id="buttonRecomendXYZ" onclick="recomendXYZ();"
								value="オススメ" style="" disabled
                                class="btn btn-secondary">
							<input type="button" id="buttonApplyXYZ" onclick="changeXYZ();"
								value="調整" style="" disabled
                                class="btn btn-secondary">
                            <input
								type="button" id="buttonAxisGet" onclick="resetAxis();"
								value="リセット" style="" disabled
                                class="btn btn-secondary">
						</div>
					</div>
				</div>
			</div>
		</form>
		<div class="col-sm-12" style="margin: 1em;">
			<img id="tgt-img" src="" onload="putAxis();" style="border:1px solid black;">
		</div>
	</div>
</div>

</body>

<script>
    
	var original_x = 0;
	var original_y = 0;
	var original_z = 0;
	var original_x_cm = 0;
	var original_y_cm = 0;
	var original_z_cm = 0;

	var pre_x = 0;
	var pre_y = 0;
	var pre_z = 0;
    
    var image = document.getElementById( 'tgt-img' );
    image.crossOrigin = '' // デモ用に外部から画像を取得するため

    let context = null;
    
    var canvas = document.createElement('canvas');

    function previewImage(obj)
    {
        var image = document.getElementById( 'tgt-img' );

        // CSSをリセット
    	image.style.width =  ''; // 横幅
        image.style.height = ''; // 縦幅

    	var fileReader = new FileReader();
    	fileReader.onload = (function() {
    		image.src = fileReader.result;
    	});
    	fileReader.readAsDataURL(obj.files[0]);

        const buttonSubmit = document.getElementById("buttonSubmit");
        buttonSubmit.style.display = "inline";

        // 部品を活性化させる
        document.getElementById("x_axis_cm").disabled = false;
        document.getElementById("y_axis_cm").disabled = false;;
        document.getElementById("z_axis_cm").disabled = false;;

        document.getElementById("buttonZoomIn1").disabled = false;;
        document.getElementById("buttonZoomOut1").disabled = false;;

        document.getElementById("buttonRecomendXYZ").disabled = false;;
        document.getElementById("buttonApplyXYZ").disabled = false;;
        document.getElementById("buttonAxisGet").disabled = false;;

    };

    function putAxis()
    {
        var image = document.getElementById( 'tgt-img' );
        var width = image.width;
        var height = image.height;
        
        console.log(width)
        console.log(height)

        var x_axis_js = document.getElementById( 'x_axis' );
        var y_axis_js = document.getElementById( 'y_axis' );
        var z_axis_js = document.getElementById( 'z_axis' );

        var x_axis_cm_js = document.getElementById( 'x_axis_cm' );
        var y_axis_cm_js = document.getElementById( 'y_axis_cm' );
        var z_axis_cm_js = document.getElementById( 'z_axis_cm' );

        if(width == 1 && height == 1){// ページを読み込んだ時
            // 何もしない
        }else{// 画像を選択した時
        	//ローカル変数に保存(リセットボタン用)
            original_x  = width;
            original_y = height;
            original_z = 0;

            pre_x = width;
            pre_y = height;
            pre_z = 0;

            //cmに変換
            var cmArray = calcCm(width, height);
            // 小数第一位を基準とした方法 Math.round( something * 10 ) / 10
            x_axis_cm_js.value = Math.round(cmArray[0] * 10) / 10;
            y_axis_cm_js.value = Math.round(cmArray[1] * 10) / 10;
        	//ローカル変数に保存(リセットボタン用)
            original_x_cm = Math.round(cmArray[0] * 10) / 10;
        	original_y_cm = Math.round(cmArray[1] * 10) / 10;
        	original_z_cm = 0;

            //pixcelの方
        	x_axis_js.value = width;
            y_axis_js.value = height;
            z_axis_js.value = 0;
            
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
    };

    function resetAxis()
    {
    	var image = document.getElementById( 'tgt-img' );

        var x_axis_js = document.getElementById( 'x_axis' );
        var y_axis_js = document.getElementById( 'y_axis' );
        var z_axis_js = document.getElementById( 'z_axis' );
        var x_axis_cm_js = document.getElementById( 'x_axis_cm' );
        var y_axis__cm_js = document.getElementById( 'y_axis_cm' );
        var z_axis_cm_js = document.getElementById( 'z_axis_cm' );

        x_axis_js.value = original_x;
        y_axis_js.value = original_y;
        z_axis_js.value = original_z;

        x_axis_cm_js.value = original_x_cm;
        y_axis__cm_js.value = original_y_cm;
        z_axis_cm_js.value = original_z_cm;

        image.style.width = original_x +'px'; // 横幅
        image.style.height = original_y +'px'; // 縦幅
        
        canvas.width = original_x;
        canvas.height = original_y;
        context = canvas.getContext('2d');
        context.drawImage(image,0,0, original_x, original_y);    
    }

    // cmのテキストボックスに入力された数値より、pxを計算しvalueに格納
    // 及び、画像サイズをpxで変更
    function changeXYZ()
    {
        var image = document.getElementById( 'tgt-img' );

        //cmのvalue取得
        var x_cm_value = document.getElementById( 'x_axis_cm' ).value;
        var y_cm_value = document.getElementById( 'y_axis_cm' ).value;

        var pixcelArray = calcPixcel(x_cm_value, y_cm_value);

        var new_x = Math.round(pixcelArray[0]);
        var new_y = Math.round(pixcelArray[1]);

        // pxのvalueを変更
        document.getElementById( 'x_axis' ).value = new_x;
        document.getElementById( 'y_axis' ).value = new_y;

        // 画像サイズを変更
        image.style.width = new_x +'px'; // 横幅
        image.style.height = new_y +'px'; // 縦幅
        
        canvas.width = new_x;
        canvas.height = new_y;
        context = canvas.getContext('2d');
        context.drawImage(image,0,0, new_x, new_y);
    }

    // プラス1.2倍する
    function changeZoomIn1()
    {
        var image = document.getElementById( 'tgt-img' );

        var x_axis_js = document.getElementById( 'x_axis' );
        var y_axis_js = document.getElementById( 'y_axis' );
        var x_axis_cm_js = document.getElementById( 'x_axis_cm' );
        var y_axis_cm_js = document.getElementById( 'y_axis_cm' );

        var x = x_axis_js.value;
        var y = y_axis_js.value;
        var x_cm = x_axis_cm_js.value;
        var y_cm = y_axis_cm_js.value;

        x = Math.round(x * 1.2);
        y = Math.round(y * 1.2);
        x_cm = Math.round(x_cm * 1.2);
        y_cm = Math.round(y_cm * 1.2);

        x_axis_js.value = x; // テキストボックスの横幅
        y_axis_js.value = y; // テキストボックスの横幅
        x_axis_cm_js.value = x_cm; // テキストボックスの横幅
        y_axis_cm_js.value = y_cm; // テキストボックスの横幅

        image.style.width = x +'px'; // 画像の横幅
        image.style.height = y +'px'; // 画像の縦幅
        
        canvas.width = x;
        canvas.height = y;
        context = canvas.getContext('2d');
        context.drawImage(image,0,0, x, y);
    }

    // マイナス1.2倍する
    function changeZoomOut1()
    {
        var image = document.getElementById( 'tgt-img' );

        var x_axis_js = document.getElementById( 'x_axis' );
        var y_axis_js = document.getElementById( 'y_axis' );
        var x_axis_cm_js = document.getElementById( 'x_axis_cm' );
        var y_axis_cm_js = document.getElementById( 'y_axis_cm' );

        var x = x_axis_js.value;
        var y = y_axis_js.value;
        var x_cm = x_axis_cm_js.value;
        var y_cm = y_axis_cm_js.value;

        x = Math.round(x / 1.2);
        y = Math.round(y / 1.2);
        x_cm = Math.round(x_cm / 1.2);
        y_cm = Math.round(y_cm / 1.2);

        x_axis_js.value = x; // テキストボックスの横幅
        y_axis_js.value = y; // テキストボックスの横幅
        x_axis_cm_js.value = x_cm; // テキストボックスの横幅
        y_axis_cm_js.value = y_cm; // テキストボックスの横幅

        image.style.width = x +'px'; // 画像の横幅
        image.style.height = y +'px'; // 画像の縦幅
        
        canvas.width = x;
        canvas.height = y;
        context = canvas.getContext('2d');
        context.drawImage(image,0,0, x, y);
    }

    function recomendXYZ()
    {
        var image = document.getElementById('tgt-img');

        var x_axis = document.getElementById('x_axis');
        var y_axis = document.getElementById('y_axis');
        var x_axis_cm = document.getElementById('x_axis_cm');
        var y_axis_cm = document.getElementById('y_axis_cm');

        var recomend_size = 8;

        var recomend_x_cm = original_x_cm;
        var recomend_y_cm = original_y_cm;

        if( original_x_cm >= original_y_cm ){// 横が縦より大きい場合
			if(original_x_cm > recomend_size ){// 横が推奨サイズより大きい場合
				while( recomend_x_cm > recomend_size ){// 横が推奨サイズより大きい間繰り返す
					recomend_x_cm = recomend_x_cm / 1.1;
					recomend_y_cm = recomend_y_cm / 1.1;
				}
			}else{
				while( recomend_x_cm < recomend_size ){
					recomend_x_cm = recomend_x_cm * 1.1;
					recomend_y_cm = recomend_y_cm * 1.1;
				}
			}
        }else{
        	if(original_y_cm > recomend_size ){
				while( recomend_y_cm > recomend_size ){
					recomend_x_cm = recomend_x_cm / 1.1;
					recomend_y_cm = recomend_y_cm / 1.1;
				}
			}else{
				while( recomend_y_cm < recomend_size ){
					recomend_x_cm = recomend_x_cm * 1.1;
					recomend_y_cm = recomend_y_cm * 1.1;
				}
			}
        }

		x_axis_cm.value = Math.round(recomend_x_cm * 10) / 10;
		y_axis_cm.value = Math.round(recomend_y_cm * 10) / 10;

		const pixcelArray = calcPixcel(recomend_x_cm, recomend_y_cm);

		var new_x = Math.round(pixcelArray[0]);
		var new_y = Math.round(pixcelArray[1]);

		// pxのvalueを変更
		document.getElementById( 'x_axis' ).value = new_x;
		document.getElementById( 'y_axis' ).value = new_y;

		// 画像サイズを変更
		image.style.width = new_x +'px'; // 横幅
		image.style.height = new_y +'px'; // 縦幅
        
        canvas.width = new_x;
        canvas.height = new_y;
        context = canvas.getContext('2d');
        context.drawImage(image,0,0, new_x, new_y);
    }

    //pixcel to cm
    function calcCm(x,y)
    {
        return [x * 2.54 / 96, y * 2.54 / 96];
    }

    //cm to pixcel
    function calcPixcel(x,y)
    {
        return [x / 2.54 * 96, y / 2.54 * 96];
    }
    
    
    //中村

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
    
    
    // input要素
    const inputElem = document.getElementById('range');

    // 埋め込む先の要素
    const currentValueElem = document.getElementById('current-value');

    // 現在の値を埋め込む関数
    const setCurrentValue = (val) => {
      currentValueElem.innerText = val;
    }

    // inputイベント時に値をセットする関数
    const rangeOnChange = (e) =>{
      setCurrentValue(e.target.value);
    }

    window.onload = () => {
      // 変更に合わせてイベントを発火する
      inputElem.addEventListener('input', rangeOnChange);
      // ページ読み込み時の値をセット
      setCurrentValue(inputElem.value);
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