<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
      <h1 class="text-center">PHP Check Grade A-E from Score</h1>
      <hr>
      <p class="text-center">กรุณากรอกตัวเลขเพื่อทำการตรวจสอบว่าไก้เกรดอะไร</p>

      <form action="" method="post" class="text-center">
            <div form-group>
              <input type="number"name="score"id="score" value="<?php echo isset ($_POST['score']) ? $_POST['score'] : '';  ?>"
              class="form-control w-50 mx-auto" placeholder="Enter a secore" required >
            </div>
            <button type="submit" class="btn btn-primary mt-3 mb-3">Check</button>
            <button type="button" class="btn btn-secondary mt-3 mb-3" onclick="clearGrade()">Reset</button>
      </form>

    
  </div>
    <!--=====แสดงผลลัพธ์=========-->
    <!--=====คำนวณเลขคู่เลขคี่=========-->

    <div id="grade">
    <?php
    $get_score = $_POST['score'] ?? null;
        if($get_score >= 80){
                echo "<h3 class='text-success text-center'>Your grade is A</h3>";
            }else if($get_score >= 70){
                echo "<h3 class='text-success text-center'>Your grade is B</h3>";
            }else if($get_score >= 60){
                echo "<h3 class='text-success text-center'>Your grade is C</h3>";
            }else if($get_score >= 50){
                echo "<h3 class='text-success text-center'>Your grade is D</h3>";
            }else {
                echo "<h3 class='text-danger text-center'>Your grade is E</h3>";
            }

?>
</div>
 <script>
        // ฟังก์ชันสำหรับล้างผลลัพธ์เกรดและช่องกรอกคะแนน
        function clearGrade() {
            document.getElementById('grade').innerHTML = '';
            document.getElementById('score').value = '';
        }  
    </script>

<a href="index.php">HOME</a>
</body>
</html>