<?php require './require/header1.php';?>

    <header>
        <?php require './require/navArea.php';?>
        
        <div class="container-fluid">
    		<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-1 m-0 p-0 border d-none d-md-flex toggle_btn" style="display: flex; align-items: center; justify-content: center;">
    				<div style="display: flex; place-content: center; justify-content: center;">
    					<img alt="toggle_btn" src="./sources/menu.png" style="width: 50%;">
    				</div>
    			</div>
                
    			<div class="col-sm-11 border">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 d-md-none w-50" style="display:flex; align-items:center;">
                            <img class="d-md-none toggle_btn" alt="toggle_btn" src="./sources/menu.png" style="width:3vw;">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-12 w-50">
                            <a class="p-2" href="./ASOAR_Top.php" style="font-size: 3vw; float: right;">AR & Hologram</a>
                        </div>
                        
                        <div class="col-sm-12 p-5" style="background-color: #99ccff;">
                            <div class="row">
                                <div class="col-sm-12">
                                    <p style="font-size: 4vw;">AR</p>
                                </div>
                                <div class="col-sm-12">
                                    <p style="font-size: 1vw;">
                                        あなたが選んだ写真で<br>オリジナルのARを映し出しましょう。
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    		</div>
		</div>
        
	</header>

<?php require './require/nav_css_js.php';?>