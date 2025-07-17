<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Baisc</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: lightyellow;
        }
    </style>
</head>

<body>
    <h1>Welcome to PHP Basic</h1>
    <p>This is a simple PHP application.</p>
    <hr>
    <h1 style="color:red;">Basic PHP Syntax </h1>
    <pre>
        &lt;?php
            echo "Hello Thailand";
        ?&lt;
    </pre>
    <h3>Result</h3>
    <div style="color: blue;">
        <?php
        echo "Hello Thailand<br>";
        print "<span style='color: pink;'>Kim</span>";
        ?>
    </div>
    <hr>

    <!--=========================================================-->


    <h1 style="color:red;">PHP Variables</h1>
    <pre>
        &lt;?php
            $greeting = "Hello, World!";
            echo $greeting;
        ?&lt;
    </pre>
    <h3>Result</h3>
    <?php
    $greeting = "Hello, World!";
    echo "<span style='color:blue;'>$greeting</span>";
    ?>
    <hr>
    <h1 style="color:red;">Integer Varriable Exmple</h1>
    <?php
    $age = 20;
    echo "<span style='color:blue;'>I am $age years old</span>";
    ?>


    <hr>

    <!--=========================================================-->


    <h1 style="color:red;">Calulate with Variables</h1>
    <?php
    $a = 5;
    $b = 4;
    $sum = $a + $b;

    echo "<span style='color:blue;'> The sum of $a and $b is $sum </span>";
    ?>


    <hr>
    <h1 style="color:red;">คำนวณพื้นที่สามเหลี่ยม</h1>
    <?php
    $base = 10;
    $height = 5;
    $area = 0.5 * $base * $height;

    echo "<span style='color:blue;'>พื้นที่ของสามเหลี่ยมคือ $area ตารางหน่วย</span>";
    ?>


    <hr>

    <!--=========================================================-->


    <h1 style="color:red;">คำนวณอายุจากปีเกิด</h1>
    <?php
    $birth_year = 2003;
    $year = 2023;
    $o = $birth_year - $year;
    echo "<span style='color:blue;'>อายุของผมคือ $o ปี</span>";

    ?>
    <hr>
    <h1 style="color: blue;">IF-Else</h1>
    <!--เกณฑ์ผ่านการสอบ ต้องได้คะแนน มากกว่า 60 คะแนน-->

    <?php
    $score = 50; // เปลี่ยนค่า score เพื่อทดสอบ
    if ($score > 60) {
        echo "คะแนนของคุณคือ $score <br>";
        echo "ผลลัพธ์คือ : สอบผ่าน";
    } else {
        echo "คะแนนของคุณคือ $score <br>";
        echo "ผลลัพธ์คือ : สอบไม่ผ่าน";
    }
    ?>

    <h1 style="color: blue;">Boolean Variable</h1>
    <!--ตรวจสอบว่าเป็นนักศึกษาหรือไม่-->
    <?php
    echo "<h3>คุณเป็นนักเรียนใช่หรือไม่</h3>";
    $is_dtudent = true; // เปลี่ยนค่าเป็น fales,true เพื่อทดสอบ
    if (!$is_dtudent) {
        echo "ใช่";


    } else {
        echo "ไม่ใช่";
    }

    ?>
    <hr>

    <!--========================Loop=================================-->

    <h1 style="color: blue;">Loop</h1>
    <h2>========Loop For========</h2>
    <h3>แสดงตัวเลข 1 ถึง 10</h3>
    <?php
    $sum = 0;
    for ($i = 5; $i <= 9; $i++) {
        $sum += $i;
        if ($i < 9) {
            echo "$i + ";

        } else {
            echo "$i = $sum ";
        }
    }

    echo "<h3>ผลบวกของตัวเลข 5 ถึง 9 คือ $sum </h3>";

    //5 + 6 + 7 + 8 + 9 = 35
    
    ?>
    <hr>

    <!--========================while Loop=================================-->


    <h2>====สูตรคูณแม่ 2====</h2>
    <?php
    // ค่าเริ่มต้น
    $j = 1;

    while ($j <= 12) { //เงื่อนไข
        echo "2 x $j = " . (2 * $j) . "<br>";  //แสดงผล
        $j++;   // เพิ่มลดค่า 
    }
    ?>

    <hr>

    <h2>====สูตรคูณแม่ 2 ใส่ตาราง====</h2>
    <table class="table table-bordered table-striped w-auto mx-auto text-ceter">
        <thead class="table-success">
            <tr>
                <th>ลำดับ</th>
                <th>สูตรคูณ</th>
                <th>ผลลัพธ์</th>
            </tr>
        </thead>
        <tbody>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                echo "<tr>";
                echo "<td>$i</td>";                // ลำดับ
                echo "<td>2 x $i</td>";            // สูตรคูณ
                echo "<td>" . (2 * $i) . "</td>";  // ผลลัพธ์
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>



    <!--=========================================================-->

    <!-- ======================================================== -->
    <!-- ======================================================== -->
    <!-- ======================================================== -->
    <!-- ======================================================== -->

    <hr>
    <h2>สร้างตัวแปรอาเรย์ แบบที่ 1: Indexed Array</h2>
    <hr>
    <?php
    $fruits = ["Apple", "Banana", "Cherry"];
    ?>

    <h3>แสดงรายการผลไม้ โดยใช้ index</h3>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        echo $fruits[0] . " <br>"; // Apple
        echo $fruits[1] . " <br>"; // Banana
        echo $fruits[2] . " <br>"; // Cherry
        ?>
    </div>
    <br>
    <h5>PHP จะกำหนด index เป็นตัวเลขอัตโนมัติ โดยเริ่มจาก 0</h5>
    <div style="color:red; background-color: lightgray; padding: 10px;">
        <?php
        echo "รายการผลไม้: <br>";
        echo "ผลไม้ที่ 1: " . $fruits[0] . "<br>"; // Apple
        echo "ผลไม้ที่ 2: " . $fruits[1] . "<br>"; // Banana
        echo "ผลไม้ที่ 3: " . $fruits[2] . "<br>"; // Cherry
        ?>
    </div>

    <h4>แสดงรายการผลไม้ โดยใช้ print readable</h4>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        echo "รายการผลไม้: <br>";
        print_r($fruits);
        echo "<br>";
        ?>
    </div>
    <!-- ======================================================== -->
    <br>
    <h4>แสดงรายการผลไม้ โดยใช้ implode เพื่อแปลงอาเรย์เป็นสตริง</h4>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        // แสดงรายการผลไม้และจำนวนสมาชิกในอาเรย์
        // ใช้ implode เพื่อแปลงอาเรย์เป็นสตริง และแสดงผลลัพธ์
        echo "รายการผลไม้: " . implode("-", $fruits) . "<br>"; // ผลลัพธ์: Apple-Banana-Cherry
        echo "<br>";
        ?>
    </div>

    <!-- ======================================================== -->

    <br>
    <h4>แสดงรายการผลไม้ ใช้คำสั่ง foreach เพื่อวนลูป</h4>

    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        // ใช้คำสั่ง foreach เพื่อวนลูปค่าใน array ทีละตัว โดยในแต่ละรอบ ตัวแปร $fruit จะเก็บค่าผลไม้ 1 ชนิด
        foreach ($fruits as $fruit) {
            echo "ผลไม้: $fruit<br>";
        }
        echo "<br>"
            ?>
    </div>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        // ใช้คำสั่ง foreach เพื่อวนลูปค่าใน array ทีละตัว โดยในแต่ละรอบ ตัวแปร $fruit จะเก็บค่าผลไม้ 1 ชนิด
        foreach ($fruits as $fruit) {
            echo "ผลไม้: $fruit <br>";
        }
        if ($fruits === end($fruits)) {
            echo "$fruit.";
        } else {
            echo "$fruit,";
        }

        echo "<br>"
            ?>
    </div>

    <!-- ======================================================== -->
    <!-- ======================================================== -->

    <hr>

    <h6>เป็น array ซ้อนกันหลายชุด (Multidimensional array)</h6>
    <h6>แต่ละชุดเป็น associative array ที่ระบุชื่อ key ชัดเจน เช่น "name" และ "price"</h6>
    <h6>ใช้สำหรับเก็บข้อมูลที่มีความสัมพันธ์กัน key => value เช่น รายการสินค้า</h6>

    <h2>สร้างตัวแปรอาเรย์ แบบที่ 2: Associative Array</h2>
    <?php
    // สร้างอาเรย์ของผลไม้ที่มีชื่อและราคา
    $products = [
        ["name" => "Apple", "price" => 30],
        ["name" => "Banana", "price" => 20],
        ["name" => "Cherry", "price" => 15]
    ];
    ?>


    <!-- ======================================================== -->
    <br>
    <h4>แสดงรายการผลไม้ ใช้คำสั่ง key value</h4>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        // แสดงผลลัพธ์ของการเข้าถึงข้อมูลในอาเรย์
        echo $products[0]["name"] . "<br>";  // Apple
        echo $products[2]["price"] . "<br>"; // 15
        ?>
    </div>
    <h4>แสดงรายการผลไม้ ใช้คำสั่ง foreach เพื่อวนลูป</h4>
    <div style="color:blue; background-color: lightgray; padding: 10px;">
        <?php
        $total_price = 0; // กำหนดตัวแปรเก็บผลรวมราคา
        
        foreach ($products as $product) {
            echo "สินค้า: " . $product["name"] . "<br>" . " ราคา: " . $product["price"] . " บาท<br>";
            $total_price += $product["price"];
        }

        echo "<br>ราคารวมทั้งหมด: $total_price บาท<br>";
        ?>

    </div>
    <br>
</body>

</html>
<hr> <a href="index.php">HOME</a>