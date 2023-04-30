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
                
    			<div class="col-xs-12 col-sm-12 col-md-11 border">
                    <div class="row">
        				<div class="col-xs-6 col-sm-6 d-md-none w-50" style="display:flex; align-items:center;">
                            <img class="d-md-none toggle_btn" alt="toggle_btn" src="./sources/menu.png" style="width:3vw;">
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-12 w-50">
                            <a class="p-2" href="./ASOAR_Top.php" style="font-size: 3vw; float: right;">AR & Hologram</a>
                        </div>
    					<div class="col-xs-12 col-sm-12 col-md-12">
    						<div class="row">
                                <div class="col-xs-12 col-sm-12 d-md-none subtitle" style="height:20vw; ">
                                    <p class="subtitle" style="font-size:3.5vw;">あなたの手の中にもう一つの世界をいってらっしゃい</p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-3 d-none d-md-flex subtitle">
                                    <p class="subtitle">あなたの手の中にもう一つの世界をいってらっしゃい</p>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-9 p-0" style="text-align:center; background:black;">
                                    <div class="w-100 h-100">
                                        <video class="mov w-100 h-100" src="./sources/TopVideo2.mov" autoplay muted loop controls controlsList="nodownload"></video>
                                    </div>
                                </div>
    						</div>
    					</div>
    				</div>
    			</div>
                
    		</div>
		</div>

	</header>

<?php require './require/nav_css_js.php';?>