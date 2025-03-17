<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>表單</title>
</head>
<body>
    <h1>調查表單</h1>
    <from action="" method="post">
    
    <fieldset>
    <legend>基本資料</legend>
    <p>

    <label for="name">姓名</label>
    <input type="text" name="name" id="name" value="" placeholder="請用中文">
    </p>
    <p>
        <label for="">性別</label>
        <input type="radio" name="gender" id="gender1" value="1"> 
        <label for="gender1">男生</label>
        <input type="radio" name="gender" id="gender2" value="2"> 
        <label for="gender2">女生</label>



    </p>
    <p>
       <label for="bday">生日</label> 
       <input type="date" name="bday" id="bday">
    </p>
<p>
       <label for="place">電話</label> 
       <input type="text" name="phone" id="phone">
</p>
<p>
<label for="place">居住區域</label>

<select name="place" id="place">
       <option value="1">北部</option>
       <option value="2">中部</option>
       <option value="3">南部</option>
       <option value="4">東部</option>
       <option value="5">外島</option>
</select>


</p>
    </fieldset>

<fieldset>
<legend> 使用行為</legend>
<input type="checkbox" name="behavior[]" id="behavior1">
<label for="behavior1">聊天</label>
<input type="checkbox" name="behavior[]" id="behavior2">
<label for="behavior2">直播</label>
<input type="checkbox" name="behavior[]" id="behavior3">
<label for="behavior3">書信</label>
<input type="checkbox" name="behavior[]" id="behavior4">
<label for="behavior4">其他</label>






    </fieldset>

    <fieldset>
    <legend>滿意度</legend>
    </fieldset>


    <fieldset>
    <legend>資料上傳</legend>
    </fieldset>
    </p>
    <input type="submit" name="submit" value="送出">
    </from>
    <hr>
    
    <?php
    if (isset($__POST["submit"])) {
      $name   =$_REQUEST["name"];
      $gender =$_REQUEST["gender"];
      $bday   =$_REQUEST["bday"];
      $phone  =$_REQUEST["phone"];
      $area   =$_REQUEST["area"];
      echo "<p>收到資料</p>";
      echo "<p>你的名字是: .name .</p.>";
      
 if ($gender=="1"){
    echo "<p>你是男生</p>";
}   elseif ($gender=="2") {
    echo "<p>妳是女生</p>";
}  else {
    echo "<p>你是男生還是女生?</P>";
 }
 echo "<p>你的生日:" . $bday . "</p>";

    }
       
    ?>
    <script type='text/javascript'>
        function preview_image(event) {
            var reader = new FileReader();
            reader.onload =function () {
                var output = document.getElementById('output_image');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
    }



</script>
</body>
</html>