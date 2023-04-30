<?php require './require/header1.php';?>
<?php require './require/nav3.php';?>


	<div class="container">
		<div class="row" style="text-align: center; justify-content: center;">
			<form method="POST" action="./HoloUp2.php"
				enctype="multipart/form-data" style="display: contents;">
				<div class="col-sm-12" style="margin: 3vh 0;">
					<input type="file" id="file" name="file" accept="image/*"
						onchange="previewImage(this);" onload="putAxis();"
						style="text-align-last: center;"> <input type="submit"
						id="buttonSubmit" value="透過開始" style="display: none;">
				</div>
            </form>
			<div class="col-sm-12" style="margin: 1em;">
				<img id="preview"
					src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
					onload="putAxis();" style="width:40vw;">
			</div>
		</div>
	</div>

</body>

<script>
    function previewImage(obj)
    {
        var image = document.getElementById( 'preview' );

    	var fileReader = new FileReader();
    	fileReader.onload = (function() {
    		image.src = fileReader.result;
    	});
    	fileReader.readAsDataURL(obj.files[0]);

        const buttonSubmit = document.getElementById("buttonSubmit");
        buttonSubmit.style.display = "inline";

    };
</script>