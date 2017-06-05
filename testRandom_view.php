<html lang="en">
<head>
  <title>ตรวจข้อสอบ</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <?php
  include("jscss.php");
  include("mysqlconnect.php");
  ?>

</head>
<body>
  <?php
  session_start();
  //echo $_SESSION['name'];
  // echo "OK";
  ?>
  <?php
  //1. เชื่อมต่อ database:
  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
  $exam_id = $_REQUEST["exam_id"];

  //2. query ข้อมูลจากตาราง:
  $sql = "SELECT * FROM create_exam WHERE exam_id='$exam_id' ";
  $result = mysqli_query($dbc, $sql) or die ("Error in query: $sql " . mysqli_error());
  $row = mysqli_fetch_array($result);



  ?>

  <nav class="navbar navbar-default">
    <div class="container-fluid ">
      <div class="navbar-header navbar-right">
        <a class="navbar-brand" href="#">CES</a>
      </div>
      <ul class="nav navbar-nav">
        <li class=""><a href="coordinatorIndex.php">หน้าหลัก</a></li>
        <li class="active"><a href="#">สุ่มข้อสอบ</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" style="color:orange;">
          <span class="glyphicon glyphicon-credit-card"></span> <u><?php echo $_SESSION['type'];?></u>
        </a></li>
        <li><a href="#" style="color:#6699CC;">
          <span class="glyphicon glyphicon-book"></span> <u><?php echo $_SESSION['class'];?></u>&nbsp;
          <span class="glyphicon glyphicon-user"></span> <u><?php echo $_SESSION['name'];?></u>
        </a></li>
        <li><a href="../index.php" style="color:#990033;" class="w3-hover-red">
          <span class="glyphicon glyphicon-log-out"></span> Logout &nbsp;</a></li>
        </ul>
      </div>
    </nav>

    <div class="container w3-padding-16 w3-animate-opacity">
      <div class="container-fluid">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="panel">
            <div class="panel-heading w3-pink">
              ตารางแสดงรายการข้อสอบ
            </div>
            <div class="panel-body" style="width: 100%; height: 550px; overflow: auto;">
              <?php
              //1. เชื่อมต่อ database:  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

              //2. query ข้อมูลจากตาราง tb_member:
              $query = "SELECT * FROM test_exam WHERE exam_id = $exam_id ORDER BY test_no asc" or die("Error:" . mysqli_error());
              //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
              $result = mysqli_query($dbc, $query);
              //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:


              while($row = mysqli_fetch_array($result)) {
                $no = $row["test_no"];

                echo "<td>" .$row["test_no"] . "." .  "</td> ";
                echo "<td>" .$row["test_name"] .  "</td> ";
                $image_name = $row["test_namepic"];
                if(empty( $image_name )) {
                  echo "<td></td>";

                } else {
                  echo "<br /><td>". "<img src='../img/".$row["test_namepic"]."' width='600'>" . "</td> <br />";
                }
                echo "<br /><td>" . "1. " .$row["choiceA"] .  "</td> ";
                echo "<br /><td>" . "2. " .$row["choiceB"] .  "</td> ";
                echo "<br /><td>" . "3. " .$row["choiceC"] .  "</td> ";
                echo "<br /><td>" . "4. " .$row["choiceD"] .  "</td> ";
                echo "<br /><td>" . "เฉลย <u>" .$row["test_ans"] .  "</u></td> ";

                echo "<hr />";
              }

              ?>

            </div>
          </div>
          <a href="testRandom.php" style="color:orange;">
            ย้อนกลับ</a>
          </div>
        </div>
      </div>
      <div class="container w3-animate-opacity">
        <div class="container-fluid">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="panel">
              <div class="panel-heading w3-lime">
                ตารางแสดงรายการข้อสอบ
              </div>
              <div class="panel-body" style="width: 100%; height: 200px; overflow: auto;">
                <?php
                //1. เชื่อมต่อ database:  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

                //2. query ข้อมูลจากตาราง tb_member:
                $query = "SELECT * FROM test_exam WHERE exam_id = $exam_id ORDER BY test_no asc" or die("Error:" . mysqli_error());
                //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
                $result = mysqli_query($dbc, $query);
                //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:

                echo "<table class='table table-hover'>";
                //หัวข้อตาราง
                echo "<thead>
                <tr>

                <th width='5%'>ที่</th>
                <th width='75%'>โจทย์</th>
                <th width='15%'>รูป</th>
                <th width='5%'></th>
                </tr>
                </thead>
                <tbody>";

                while($row = mysqli_fetch_array($result)) {
                  echo "<tr>";
                  echo "<td>" .$row["test_no"] .  "</td> ";
                  echo "<td>" .$row["test_name"] .  "</td> ";
                  
                  $image_name = $row["test_namepic"];
                  if(empty( $image_name )) {
                    echo "<td></td>";

                  } else {
                    echo "<td>". "<img src='../img/".$row["test_namepic"]."' width='100'>" . "</td> ";

                  }

                  echo "<td width='5%'><label><a href='testDelete.php?exam_id=$exam_id&test_id=$row[0]' title='ลบข้อสอบ'
                  onclick=\"return confirm('Do you want to delete this record? !!!')\">
                  <img src = 'icon/remove.png' width=30 px></label></td> ";

                  echo "</tr>";
                }
                echo "</tbody></table>";
                //5. close connection
                mysqli_close($dbc);
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </body>
    </html>
