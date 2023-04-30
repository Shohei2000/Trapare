<?php require "header.php" ?>



<div class="container">
    
    <div class="row col-md-12 col-xs-12 m-0 p-0">
        <div class="row col-md-6 col-xs-6 m-0 p-0">
<!--            画像を表示するとこ-->
        </div><!- 左側 col-sm-6　->
        <div class="row  col-md-6 col-xs-6 p-0 m-0">            
            
            <div class="row col-sm-12 pl-5">
                <form action="cgi-bin/example.cig" method="post">
                    <input type="file" name="pic" accept="image/*">
                </form>
            </div>

            <div class="row justify-content-start">      
                <div id="sub-position" class="col-md-5 col-xs-4 d-inline-flex p-3 mb-2 bg-secondary text-white">
                    手前
                    幅：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                    高さ：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                </div>
            </div><!- 手前　->

            <div class="row justify-content-start">
                <div id="sub-position" class="col-md-5 col-xs-4 d-inline-flex p-3 mb-2 bg-secondary text-white">
                    中央
                    幅：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                    高さ：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                </div>
            </div><!- 中央　->

            <div class="row justify-content-start">
                <div id="sub-position" class="col-md-5 col-xs-4 d-inline-flex p-3 mb-2 bg-secondary text-white">
                    奥&emsp;
                    幅：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                    高さ：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                </div>
            </div><!- 奥　->

            <div class="row justify-content-start">
                <div id="sub-position" class="col-md-5 col-xs-4 d-inline-flex p-3 mb-2 bg-secondary text-white">
                    床&emsp;
                    幅：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                    高さ：
                    <select class="form-select" aria-label="Default select example">
                      <option selected></option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>&emsp;
                </div>
            </div><!- 床　->
        </div><!- 床　->
    </div><!- 右側のcol-sm-6　->

</div>

<button id="but" type="button" class="btn btn-primary">作成</button>
  
<?php require "footer.php" ?>