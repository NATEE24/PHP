<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Odd Even Number</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
      <h1 class="text-center">Odd Even Number Checker</h1>
      <hr>
      <p class="text-center">กรุณากรอกตัวเลขเพื่อทำการตรวจสอบเลขคู่เลขคี่</p>

      <form action="" method="post" class="text-center">
            <div form-group>
              <input type="number"name="number"id="number" class="form-control w-50 mx-auto" placeholder="Enter a number" required >
            </div>
            <button type="submit" class="btn btn-primary mt-3">Checker</button>
      </form>

    
  </div>
    <!--=====แสดงผลลัพธ์=========-->
    <!--=====คำนวณเลขคู่เลขคี่=========-->
    <?php
    $get_number = $_POST['number'] ?? null;
    if ($get_number % 2 == 0) {
        echo "<h3 class='text-success text-center'>$get_number เป็นเลข คู่</h3>";
        
    } else {
        echo "<h3 class='text-danger text-center'>$get_number เป็นเลข คี่</h3>";
    }
?>
<hr>

<a href="index.php">HOME</a>
 
</body>
</html>