<?php require './require/header1.php';?>
<?php require './require/nav1.php';?>

<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>AR</h1>
            <a href="./ASOAR_ImageUplode3.php" style="float:right; padding:0.5em 4vw;">透過しない人はこちら</a>
        </div>
    </div>
    <div class="row">

		<div class="col-sm-12 col-md-6" style="display: flex; justify-content: center; height: 100%; margin-bottom:1em;">
            <div class="row w-100 h-100">
                <div class="col-sm-12 img-div w-100 h-100" style="display:flex; text-align:center;">
                    <a href="ASOAR_ImageUplode.php"><img class="img_main" alt="人物AR" src="./sources/hito_ar.jpeg"></a>
                </div>
                <div class="col-sm-12 col-sm-12" style="display: flex; justify-content: center;">
                    <p>人物の背景を透過</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6" style="display: flex; justify-content: center; height: 100%;">
            <div class="row w-100 h-100">
                <div class="col-sm-12 img-div w-100 h-100" style="display:flex; text-align:center;">
                    <a href="ASOAR_ImageUplode2.php"><img class="img_main" alt="物体AR" src="./sources/mono_ar.jpeg"></a>
                </div>
                <div class="col-sm-12 col-sm-12" style="display: flex; justify-content: center;">
                    <p>物体の背景を透過</p>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <h1>Hologram</h1>
            <a href="HoloNo.php" style="float:right; padding:0.5em 4vw;">透過しない人はこちら</a>
        </div>
    </div>
    <div class="row">

        <div class="col-sm-12 col-md-6" style="display: flex; justify-content: center; height: 100%; margin-bottom:2em;">
            <div class="row w-100 h-100">
                <div class="col-sm-12 img-div w-100 h-100" style="display:flex; text-align:center;">
                    <a href="HoloUp.php"><img class="img_main" alt="人物ホログラム" src="./sources/hito_hol.jpeg"></a>
                </div>
                <div class="col-sm-12 col-sm-12" style="display: flex; justify-content: center;">
                    <p>人物をホログラムで表示</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-6" style="display: flex; justify-content: center; height: 100%; margin-bottom:3em;">
            <div class="row w-100 h-100">
                <div class="col-sm-12 img-div w-100 h-100" style="display:flex; text-align:center;">
                    <a href="Holoview.php"><img class="img_main" alt="物体ホログラム" src="./sources/mono_hol.png"></a>
                </div>
                <div class="col-sm-12 col-sm-12" style="display: flex; justify-content: center;">
                    <p>物体をホログラムで表示</p>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    h1{
        font-size: 3em;
        margin:0.5em 1em 0 0.5em;
        font-family: serif;
    }
    p{
        font-family: serif;
        font-size: 1.2em;
        text-align: center;
        padding-top: 1em;
    }
    .img-div {
        width:3em;
        height: 1.5em;
    }
    .img_main{
        width: 85%;
    }
    .img_main:hover {
        opacity: 0.5 ;
    }
    .container{
        margin-top: 3vw;
        margin-bottom: 3vw;
        background: #F7F6FD;
    }
</style>

<?php require './require/footer1.php';?>