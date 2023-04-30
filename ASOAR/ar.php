<?php require "header.php" ?>

<div class="container">
    
    <div class="row col-sm-12 m-0 p-0">
        
        <div class="row col-sm-6 m-0 p-0">
            <input id="qr" type="image" src="hamabe.png">
        </div><!-- 左側 col-sm-6　-->
        
        <div class="row  col-sm-6 p-0 m-0" style="background-color:white;">            
            
            <div id="file" class="row col-sm-12 p-0 m-0 rows" style="background-color:white;">
                <div id="attachment" style="width:100%;" class="rows">
                    <form action="cgi-bin/example.cig" method="post" style="height:100%;">
                        <label><input type="file" name="ファイル添付" class="fileinput" accept="image/*">画像を選択する</label>
                        <!--<span class="filename">選択されていません</span>-->
                    </form>
                </div>                
            </div>
            
            <div class="row col-sm-12 rows">
                <div class="size">
                    <label>幅　：</label>
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <br>
                    <label>高さ：</label>
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                    <br>
                    <label>奥行：</label>
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                </div>
            </div>
            
        </div><!-- 右側のcol-sm-6　-->
        
    </div><!-- 全体のcol-sm-12　-->

</div><!-- container　-->

<button id="but" type="button" class="btn btn-primary">背景を透過させて作成</button>
<button id="but2" type="button" class="btn btn-secondary">背景を透過させずに作成</button>
  
<?php require "footer.php" ?>