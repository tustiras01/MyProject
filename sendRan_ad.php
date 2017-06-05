<html lang="en">
<head>
  <title>ส่งข้อสอบ</title>
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
  //1. เชื่อมต่อ database:
  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี

  $exam_id = $_REQUEST["exam_id"];

  //2. query ข้อมูลจากตาราง:
  $sql = "SELECT * FROM create_exam WHERE exam_id='$exam_id' ";
  $result = mysqli_query($dbc, $sql) or die ("Error in query: $sql " . mysqli_error());
  $row = mysqli_fetch_array($result);
  extract($row);
  ?>

  <?php
  session_start();
  // echo $_SESSION['name'];
  // echo $_SESSION['pass'];
  // echo "OK";
  ?>
  <nav class="navbar navbar-default">
    <div class="container-fluid ">
      <div class="navbar-header navbar-right">
        <a class="navbar-brand" href="#">&nbsp;CS - COMPREHENSIVE</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="disabled"><a href="">หน้าหลัก</a></li>
        <li class="disabled"><a href="">สุ่มข้อสอบ</a></li>


      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" style="color:#6699CC;">
          <span class="glyphicon glyphicon-user"></span> <u><?php echo $_SESSION['name'];?></u>&nbsp;
          <span class="glyphicon glyphicon-book"></span> <u><?php echo $_SESSION['class'];?></u>
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
            <div class="panel-heading w3-cyan">
              ส่งชุดข้อสอบ
            </div>
            <div class="panel-body">
              <form action="sendRan_db.php" class="form-horizontal" name="from1" method="post" enctype="multipart/form-data" >
                <br /><div class="form-group">
                  <input type="hidden" class="form-control" name="exam_id" value="<?php echo $exam_id; ?>" />
                  <input type="hidden" class="form-control" name="send_random" value="<?php echo 'สุ่ม'; ?>" />
                  <label class="col-sm-3 control-label">ชื่อชุดข้อสอบ</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="exam_name" placeholder="ชื่อชุดข้อสอบ" value="<?php echo $exam_name;?>" />
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label">รหัสวิชา</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="users_class_id" value="<?php echo $_SESSION['class'];?>" disabled/>
                  </div>
                </div>

                <div class="form-group">
                  <div class=" col-sm-12">
                    <button type="submit" class="btn btn-success col-sm-offset-8 col-md-3"
                    name="uploadExam" style="" value="submit">เลือกข้อสอบ</button>
                  </div>
                </div>
              </form>
              <a href="testRandom.php">
              ย้อนกลับ</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container w3-animate-opacity">
      <div class="container-fluid">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="panel panel">
            <div class="panel-heading w3-green">
              ตารางแสดงรายการข้อสอบ <?php echo $exam_name; ?>
            </div>
            <div class="panel-body">
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

              <th>ที่</th>
              <th>โจทย์</th>


              </tr>
              </thead>
              <tbody>";

              while($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" .$row["test_no"] .  "</td> ";
                echo "<td>" .$row["test_name"] .  "</td> ";


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
