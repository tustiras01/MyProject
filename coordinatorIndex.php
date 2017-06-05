<html lang="en">
<head>
  <title>หน้าหลัก</title>
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
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
  <?php
  session_start();
  // echo $_SESSION['users_id'];

  ?>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid ">
      <div class="navbar-header navbar-right">
        <a class="navbar-brand" href="#">&nbsp;CES</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">หน้าหลัก</a></li>
        <li class=""><a href="testRandom.php">สุ่มข้อสอบ</a></li>
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

    <div class="jumbotron text-center w3-animate-opacity">
      <h1>Coordinator</h1>
      <p>Comprehensive Examination Systems</p>
      <br />
      <button type="button" class="btn btn-default" data-target="#myNavbar">
        <a href="#menu" style="color:#f4511e;">
          ประกาศ
        </a>
      </button>
    </div>


    <div id="menu">
      <div class="container w3-padding-16 ">
        <div class="container-fluid">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="panel">
              <div class="panel-heading w3-red">
                <span class="glyphicon glyphicon-warning-sign"></span> &nbsp;ประกาศ
              </div>
              <div class="panel-body" style="width: 100%; height: 550px; overflow: auto;">
                <p style="font-size: 22px">
                  344-493 การประมวลและทดสอบความรอบรู้สำหรับนักวิทยาการคอมพิวเตอร์	1(0-2-1)<br>
                  344-493 Review and Test for Computer Sciencetists	1(0-2-1)
                </p>
                <hr>
                <p style="font-size: 18px"><u>รายวิชาบังคับก่อน</u> : 344-491 หรือ โดยความเห็นชอบของคณะกรรมการบริหารหลักสูตร<br>
                  <u>Prerequisite</u> : 344-491 or with the consent of the program committee</p>
                  <hr>

                  <p style="font-size: 18px">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;การประมวลทบทวนความรู้ที่ได้เรียนมาในกลุ่มวิชาหลัก (รายวิชาบังคับ) ที่สอดคล้องกับองค์ความรู้ทางวิทยาการคอมพิวเตอร์ ทดสอบความรู้และทักษะทางวิชาชีพสำหรับนักวิทยาการคอมพิวเตอร์
                    <br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Review knowledge in core areas (compulsory courses) corresponding to computer science body of knowledge; professional test of knowledge and skills for computer scientists
                    <div class="w3-panel w3-border">หมายเหตุ รายวิชา 344-493 จะจัดสอบในช่วงสัปดาห์การสอบปลายภาคการศึกษาที่ 2 พร้อมกันทั้งนักศึกษาที่เลือก
                      แผนสหกิจศึกษาและนักศึกษาที่ไม่ใช่สหกิจศึกษา การจัดการเรียนการสอนเพื่อประมวลทบทวนความรู้ในกลุ่มวิชาหลัก
                      (รายวิชาบังคับ) โดยคณาจารย์และการมอบหมายงานให้นักศึกษาเรียนรู้และฝึกทักษะด้วยตนเองทั้งก่อน-ระหว่าง-
                      หลังสหกิจศึกษาซึ่งจะมีการจัดเวลาและวิธีการที่เหมาะสมกับนักศึกษาที่เลือกเรียนทั้ง 2 แผนการศึกษา<p>
                        <!-- <img src="img/rainbow.png" class="img-responsive col-sm-offset-6" alt="Cinque Terre" width="30%" height="30%"> -->
                      </div>
                      <hr />
                      <div class="w3-container">
                        <div class="w3-panel w3-pale-red w3-leftbar w3-border-red">
                          <p>ขณะนี้อยู่ในช่วงการทดสอบ</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </body>
        </html>
