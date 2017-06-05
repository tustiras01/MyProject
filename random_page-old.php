<html lang="en">
<head>
  <title>สุ่มข้อสอบ</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <?php
  require_once('mpdf/mpdf.php');

  ?>
  <?php
  include("jscss.php");
  include("mysqlconnect.php");
  ?>

</head>
<body>
  <?php
  session_start();
  //echo $_SESSION['name'];
  // echo $_SESSION['pass'];
  // echo "OK";
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
            <div class="panel-heading w3-green">
              ตารางแสดงรายการข้อสอบที่เลือก
            </div>
            <div class="panel-body">
              <?php
              ob_start();

              // $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
              // ob_end_clean();
              // $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
              // $pdf->SetAutoFont();
              // $pdf->SetDisplayMode('fullpage');
              // $pdf->WriteHTML($html, 2);
              // $pdf->Output("MyPDF.pdf");         // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด

              // exit;
              ?>

              <div class=header>
                <table align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="center"><span style="font-size: 14pt; font-weight: bold; text-decoration: underline;">
                      แบบทดสอบประมวลความรอบรู้นักวิทยาการคอมพิวเตอร์</span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><span
                      style="font-size: 12pt;">
                      <?php
                      $thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
                      $thai_month_arr=array(
                        "0"=>"",
                        "1"=>"มกราคม",
                        "2"=>"กุมภาพันธ์",
                        "3"=>"มีนาคม",
                        "4"=>"เมษายน",
                        "5"=>"พฤษภาคม",
                        "6"=>"มิถุนายน",
                        "7"=>"กรกฎาคม",
                        "8"=>"สิงหาคม",
                        "9"=>"กันยายน",
                        "10"=>"ตุลาคม",
                        "11"=>"พฤศจิกายน",
                        "12"=>"ธันวาคม"
                      );
                      function thai_date($time){
                        global $thai_day_arr,$thai_month_arr;
                        $thai_date_return="วัน".$thai_day_arr[date("w",$time)];
                        $thai_date_return.= "ที่ ".date("j",$time);
                        $thai_date_return.=" เดือน".$thai_month_arr[date("n",$time)];
                        $thai_date_return.= " พ.ศ.".(date("Yํ",$time)+543);
                        // $thai_date_return.= "  ".date("H:i",$time)." น.";
                        return $thai_date_return;
                      }
                      ?>
                      <?php
                      $eng_date=time(); // แสดงวันที่ปัจจุบัน
                      echo "วันที่ออกข้อสอบ " . thai_date($eng_date); ?></span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><span
                      style="font-size: 12pt;">
                      ภาควิชาวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์</span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><span
                      style="font-size: 12pt;">
                      มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตหาดใหญ่</span>
                    </td>
                  </tr>
                </table>
                <hr />
              </div>
              <div class=body>
                <span style="font-size: 11pt; font-weight: bold; text-decoration: underline;">
                  รายวิชา 344-493 ประมวลความรอบรู้เชิงวิชาชีพ</span>
                  <?php
                  //1. เชื่อมต่อ database:  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
                  $ran = 'สุ่ม';
                  //2. query ข้อมูลจากตาราง tb_member:
                  $query = "SELECT * FROM create_exam WHERE send_random = '$ran'
                  ORDER BY exam_id asc" or die("Error:" . mysqli_error());
                  //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
                  $result = mysqli_query($dbc, $query);

                  $datb = array();
                  while($row = mysqli_fetch_array($result)) { // outer loop ชุดข้อสอบ
                    $datb[] = $row;
                    $no = $row["test_no"];
                    echo "<br /><h3>" . $row["exam_name"] . "</h3>";
                    $exam_id = $row["exam_id"];
                    $qu = "SELECT * FROM test_exam WHERE exam_id = $exam_id ORDER BY RAND() LIMIT 0,5";
                    //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
                    $resulta = mysqli_query($dbc, $qu);

                    //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
                    $num = 0;
                    $data = array();
                    while($rowa = mysqli_fetch_array($resulta)) { // inner loop ข้อสอบแต่ละข้อ
                      $data[] = $rowa;
                      $num++; // increase choice number

                      $choices[0] = $rowa["choiceA"];
                      $choices[1] = $rowa["choiceB"];
                      $choices[2] = $rowa["choiceC"];
                      $choices[3] = $rowa["choiceD"];
                      // $randomYo = $rowa["test_ans"];
                      // echo $randomYo;

                      $choice_Ans = $choices[$rowa["test_ans"]-1];
                      // echo $choice_Ans;
                      shuffle($choices);

                      for($i=0;$i<=count($choices);$i++) {
                        if(!strcmp($choices[$i], $choice_Ans)) {
                          $Answer[0] = $i + 1;
                          $Answer[1] = $choices[$i];
                        }
                      }
                      // Ans $Answer[0] = Choice Number / $Answer[1] = Choice Value
                      // echo "Choice " . $Answer[0] . " Value = " . $Answer[1];
                      // print_r($choices);
                      ?>
                      <?php

                      echo "<td>" . $num . "." .  "</td> ";
                      echo "<td>" . $rowa["test_name"].  "</td> ";
                      $image_name = $rowa["test_namepic"];
                      if(empty( $image_name )) {
                      } else {
                        echo "<br /><td>" . "<img src='img/".$rowa["test_namepic"]."' width='500' align='center'>" . "</td> <br />";
                      }
                      echo "<br /><td>" . " &nbsp;&nbsp;1. " . $choices[0] .  "</td> ";
                      echo "<br /><td>" . " &nbsp;&nbsp;2. " . $choices[1] .  "</td> ";
                      echo "<br /><td>" . " &nbsp;&nbsp;3. " . $choices[2] .  "</td> ";
                      echo "<br /><td>" . " &nbsp;&nbsp;4. " . $choices[3] .  "</td> ";
                      echo "<br />";
                      $ans = "<td>" . "เฉลย <u>" . $Answer[0] . ". " . $Answer[1] . "</u></td></br>";
                      echo $ans;
                      echo "<br />";
                    } // inner loop
                    shuffle($data);
                    for($i = 0; $i < count($data); $i++) {
                      $Answer = [];
                      for($j=3;$j<=6;$j++) {
                        // echo $data[$i][$j] . " / ";
                        // echo $data[$i][test_ans] . " # ";
                        $col = $data[$i][test_ans] + 2;
                        $thisAns = $data[$i][$col];
                        if(!strcmp($data[$i][$j], $thisAns)) {
                          $Answer[0] = $j - 2;
                          $Answer[1] = $data[$i][$j];
                        }
                      }

                      // $num = $i+1;
                      //
                      // echo "<td>" . $num . "." .  "</td> ";
                      // echo "<td>" . $data[$i][test_name] .  "</td> ";
                      // $image_name = $rowa["test_namepic"];
                      // if(empty( $image_name )) {
                      // } else {
                      //   echo "<td>" . "<img src='/img/".$rowa["test_namepic"]."' width='500' align='center'>" . "</td> <br />";
                      // }
                      // echo "<br /><td>" . " &nbsp;&nbsp;1. " . $data[$i][choiceA] .  "</td> ";
                      // echo "<br /><td>" . " &nbsp;&nbsp;2. " . $data[$i][choiceB] .  "</td> ";
                      // echo "<br /><td>" . " &nbsp;&nbsp;3. " . $data[$i][choiceC] .  "</td> ";
                      // echo "<br /><td>" . " &nbsp;&nbsp;4. " . $data[$i][choiceD] .  "</td> ";
                      // echo "<br />";
                      // echo "<td>" . "เฉลย <u>" . $Answer[0] . ". " . $Answer[1] . "</u></td></br>";
                      // echo "<br />";
                    }

                    // echo print_r($data[0]);

                    // print_r($data[0][0]);

                    // echo count($data[0][0]);

                    // echo count($data); // #5

                  }// outer loop
                  ?>

                  <?php
                  $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
                  ob_end_flush();
                  $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
                  $pdf->SetAutoFont();
                  $pdf->SetDisplayMode('fullpage');
                  $pdf->WriteHTML($html, 2);
                  $pdf->Output("MyPDF.pdf");
                  // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด
                  ?>

                  เฉลย <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a><br />
                  ข้อสอบ1 <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a><br />
                  ข้อสอบ2 <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="container w3-padding-16 w3-animate-opacity">
        <div class="container-fluid">
          <div class="col-sm-offset-1 col-sm-10">
            <div class="panel">
              <div class="panel-heading w3-green">
                ตารางแสดงรายการข้อสอบที่เลือก
              </div>
              <div class="panel-body">
                <?php
                ob_start();
                ?>
                <div class=header>
                  <table align="center" cellpadding="4" cellspacing="0">
                    <tr>
                      <td align="center"><span style="font-size: 14pt; font-weight: bold; text-decoration: underline;">
                        แบบทดสอบประมวลความรอบรู้นักวิทยาการคอมพิวเตอร์</span>
                      </td>
                    </tr>
                    <tr>
                      <td align="center"><span
                        style="font-size: 12pt;">
                        <?php echo "วันที่ออกข้อสอบ " . thai_date($eng_date); ?></span>
                      </td>
                    </tr>
                    <tr>
                      <td align="center"><span
                        style="font-size: 12pt;">
                        ภาควิชาวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์</span>
                      </td>
                    </tr>
                    <tr>
                      <td align="center"><span
                        style="font-size: 12pt;">
                        มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตหาดใหญ่</span>
                      </td>
                    </tr>
                  </table>
                  <hr />
                </div>
                <div class=body>
                  <span style="font-size: 11pt; font-weight: bold; text-decoration: underline;">
                    รายวิชา 344-493 ประมวลความรอบรู้เชิงวิชาชีพ</span>
                    <?php
                    for($k = 0; $k < count($datb); $k++) {

                      shuffle($data);
                      for($i = 0; $i < count($data); $i++) { // i is number of topic
                        $Answer = [];
                        for($j=3;$j<=6;$j++) { // j is number of choice
                          // echo $data[$i][$j] . " / ";
                          // echo $data[$i][test_ans] . " # ";
                          $col = $data[$i][test_ans] + 2;
                          $thisAns = $data[$i][$col];
                          if(!strcmp($data[$i][$j], $thisAns)) {
                            $Answer[0] = $j - 2;
                            $Answer[1] = $data[$i][$j];
                          }
                        }

                        $num = $i+1;

                        echo "<td>" . $num . "." .  "</td> ";
                        echo "<td>" . $data[$i][test_name] .  "</td> ";
                        if(empty( $image_name )) {
                        } else {
                          echo "<br /><td>" . "<img src='img/".$data[$i][test_namepic]."' width='500' align='center'>" . "</td> <br />";
                        }
                        echo "<br /><td>" . " &nbsp;&nbsp;1. " . $data[$i][choiceA] .  "</td> ";
                        echo "<br /><td>" . " &nbsp;&nbsp;2. " . $data[$i][choiceB] .  "</td> ";
                        echo "<br /><td>" . " &nbsp;&nbsp;3. " . $data[$i][choiceC] .  "</td> ";
                        echo "<br /><td>" . " &nbsp;&nbsp;4. " . $data[$i][choiceD] .  "</td> ";
                        echo "<br />";
                        echo "<td>" . "เฉลย <u>" . $Answer[0] . ". " . $Answer[1] . "</u></td></br>";
                        echo "<br />";
                      } // for any question ask github.com/simulaterz #####
                    }

                    // for($j = 0; $j < count($data[0]) / 2; $j++) {
                    //   echo " Number " . $i . " " . $data[$i][$j] . " / ";
                    // }

                    // shuffle($data); // compt
                    //
                    // for($i = 0; $i < count($data[0]) / 2; $i++) {
                    //   echo $data[0][$i];
                    // } // compt

                    // foreach($data[0] as $topic ){
                    //   echo $topic[0];
                    // }

                    // foreach($data as $rowa){
                    //do events
                    // echo ($data[0][0]) . " // ";

                    // echo $data[0][2] . " / ";
                    // print_r($data);
                    // print_r($rowa);
                    // }
                    // outer loop
                    ?>
                    <?php
                    $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
                    ob_end_flush();
                    $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
                    $pdf->SetAutoFont();
                    $pdf->SetDisplayMode('fullpage');
                    $pdf->WriteHTML($html, 2);
                    $pdf->Output("MyPDF.pdf");
                    // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสด
                    ?>
                    เฉลย <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a><br />
                    ข้อสอบ1 <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a><br />
                    ข้อสอบ2 <a target="_blank" href="MyPDF.pdf">คลิกที่นี้</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </body>
      </html>
