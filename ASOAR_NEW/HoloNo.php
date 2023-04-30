<?php require './require/header1.php';?>
<?php require './require/nav3.php';?>


	<div class="container">
		<div class="row" style="text-align: center; justify-content: center;">
			<form method="POST" action="./HoloNo2.php"
				enctype="multipart/form-data" style="display: contents;">
				<div class="col-sm-12" style="margin: 3vh 0;">
					<input type="file" id="file" name="file" accept="image/*"
						onchange="previewImage(this);" onload="putAxis();"
						style="text-align-last: center;"> <input type="submit"
						id="buttonSubmit" value="画像生成" style="display: none;">
				</div>
            </form>
			<div class="col-sm-12" style="margin: 1em;">
				<img id="preview"
					src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
					onload="putAxis();">
			</div>
		</div>
	</div>

</body>

<script>
    function previewImage(obj)
    {
        var image = document.getElementById( 'preview' );

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
</script>