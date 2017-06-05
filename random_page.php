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
  ?>
  <nav class="navbar navbar-default">
    <div class="container-fluid ">
      <div class="navbar-header navbar-right">
        <a class="navbar-brand" href="#">CES</a>
      </div>
      <ul class="nav navbar-nav">
        <li class=""><a href="coordinatorIndex.php">หน้าหลัก</a></li>
        <li class="active"><a href="randomPage.php">สุ่มข้อสอบ</a></li>

      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="#" style="color:orange;">
            <span class="glyphicon glyphicon-credit-card"></span> <u><?php echo $_SESSION['type'];?></u>
          </a>
        </li>
        <li>
          <a href="#" style="color:#6699CC;">
            <span class="glyphicon glyphicon-book"></span> <u><?php echo $_SESSION['class'];?></u>&nbsp;
            <span class="glyphicon glyphicon-user"></span> <u><?php echo $_SESSION['name'];?></u>
          </a>
        </li>
        <li>
          <a href="../index.php" style="color:#990033;" class="w3-hover-red">
            <span class="glyphicon glyphicon-log-out"></span> Logout &nbsp;
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- function convert time -->
  <?php
  $thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์");
  $thai_month_arr=array(
    "0"=>"", "1"=>"มกราคม", "2"=>"กุมภาพันธ์", "3"=>"มีนาคม", "4"=>"เมษายน",
    "5"=>"พฤษภาคม", "6"=>"มิถุนายน", "7"=>"กรกฎาคม", "8"=>"สิงหาคม",
    "9"=>"กันยายน", "10"=>"ตุลาคม", "11"=>"พฤศจิกายน", "12"=>"ธันวาคม"
  );

  function thai_date($time) {
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
  $roundrandom = $_GET["roundrandom"];

  $ran = 'สุ่ม';
  $query = "SELECT * FROM create_exam WHERE send_random = '$ran' ORDER BY exam_id asc" or die("Error:" . mysqli_error());
  $result = mysqli_query($dbc, $query);

  $data_Subj = array(); // all Subj = วิชา
  $data_Topic = array(); // all Topic = ข้อ
  $data_Ans = array(); // all Ans = รวมเฉลย

  $setDefault_Subj = 0;
  $setDefault_Topic = 0;

  while ($row_Subj = mysqli_fetch_array($result)) { // all Subj = วิชา
    $data_Subj[$setDefault_Subj] = $row_Subj;
    //จำนวนรอบสุ่ม
    // Query Topic
    $exam_id = $row_Subj["exam_id"];
    $qu = "SELECT * FROM test_exam WHERE exam_id = $exam_id ORDER BY RAND() LIMIT 0,$roundrandom";
    $result_Topic = mysqli_query($dbc, $qu);

    while ($row_Topic = mysqli_fetch_array($result_Topic)) { // inner loop ข้อสอบแต่ละข้อ
      $data_Topic[$setDefault_Subj][$setDefault_Topic] = $row_Topic;

      for($choiceNum = 0; $choiceNum <= 3; $choiceNum++){
        $choices[$setDefault_Subj][$setDefault_Topic][$choiceNum] =
        $data_Topic[$setDefault_Subj][$setDefault_Topic][$choiceNum+3];
      }

      $setDefault_Topic++;
    } // end inner loop ข้อสอบแต่ละข้อ
    $setDefault_Subj++;
    $setDefault_Topic = 0;
  } // end all Subj

  $setDefault_Subj = 0;

  for($numExam = 0; $numExam < 2; $numExam++) { // วนตามชุด
    ?>
    <div class="container w3-padding-16 w3-animate-opacity">
      <div class="container-fluid">
        <div class="col-sm-offset-1 col-sm-10">
          <div class="panel">
            <div class="panel-heading w3-green">
              รายการข้อสอบสุ่ม ชุดที่ <?php echo $numExam+1; ?>
              <button type="button" class="btn btn-default navbar-right"
              data-toggle="collapse" style="padding: 2px 9px; margin-right: 9px;" data-target="#demo<?php echo $numExam+1; ?>">-</button>
            </div>
            <div class="panel-body collapse in" id="demo<?php echo $numExam+1; ?>">
              <?php
              ob_start();
              ?>
              <!-- heaader main exam -->
              <div class=header>
                <table align="center" cellpadding="4" cellspacing="0">
                  <tr>
                    <td align="center"><span style="font-size: 14pt; font-weight: bold; text-decoration: underline;">
                      แบบทดสอบประมวลความรอบรู้นักวิทยาการคอมพิวเตอร์</span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <span style="font-size: 12pt;">
                        <?php
                        $eng_date = time(); // แสดงวันที่ปัจจุบัน
                        echo "วันที่ออกข้อสอบ " . thai_date($eng_date);
                        ?>
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <span style="font-size: 12pt;">
                        ภาควิชาวิทยาการคอมพิวเตอร์ คณะวิทยาศาสตร์
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <span style="font-size: 12pt;">
                        มหาวิทยาลัยสงขลานครินทร์ วิทยาเขตหาดใหญ่
                      </span>
                    </td>
                  </tr>
                </table>
                <hr />
              </div>

              <div class=body>
                <span style="font-size: 11pt; font-weight: bold; text-decoration: underline;">
                  รายวิชา 344-493 ประมวลความรอบรู้เชิงวิชาชีพ
                </span>
                <br />
                <?php

                // --function create by github.com/simulaterz (ronnakorn suwanchatree)
                for($numSub = 0; $numSub < count($data_Subj); $numSub++) {
                  $numsub = $numSub+1;// for -> วนตามวิชา
                  $nameSubj = $data_Subj[$numSub][1];
                  echo "<td><h3>(". $numsub . ")&nbsp;" .$nameSubj . "</h3></td>";
                  for($numTopi = 0; $numTopi < count($data_Topic[$numSub]); $numTopi++) { // วนตามข้อ

                    $head = $data_Topic[$numSub][$numTopi][2];

                    // $ans = $data_Topic[$numSub][$numTopi][7];//คำตอบในดาต้าเบส

                    $noTest = $numTopi+1;
                    echo "<td>" . $noTest . ". " . $head . "</td>";

                    shuffle($choices[$numSub][$numTopi]);
                    $image_name = $data_Topic[$numSub][$numTopi][11];
                    // print_r($choices[$numSub][$numTopi]);
                    if(empty( $image_name )) {
                    } else {
                      echo "<br /><td>" . "<img src='../img/".$data_Topic[$numSub][$numTopi][11].
                      "' width='500' align='center'>" . "</td> <br />";
                    }


                    $ansChoice = array();

                    for($numCho = 0; $numCho <= 3; $numCho++) { // วนตามตัวเลือก
                      $number = $numCho+1;
                      echo "<br /><td>" . " &nbsp;&nbsp;". $number . " " . $choices[$numSub][$numTopi][$numCho] .  "</td> ";

                      $col = $data_Topic[$numSub][$numTopi][7] + 2;
                      $oldAns = $data_Topic[$numSub][$numTopi][$col];
                      $nowAns = $choices[$numSub][$numTopi][$numCho];

                      if(!strcmp($oldAns, $nowAns)) {
                        $ansChoice[0] = $numCho + 1;
                        $ansChoice[1] = $nowAns;
                        //[ชุด][ข้อ][ุคำตอบ] =
                      }

                      // echo "numexam = $numExam <br />";
                      // echo "numsub = $numSub <br />";
                      // echo "numtopic = $numTopi <br />";
                      // echo "ansChoice = " . $ansChoice[0] . "<br />";

                      // ชุด / วิชา / ข้อ / [เฉลย] [0 ข้อ][1 คำตอบ]
                      $data_Ans[$numExam+1][$numSub+1][$numTopi+1] = $ansChoice;
                    }// จบวนตามตัวเลือก

                    echo "<br />";
                    //เฉลย echo "<td> เฉลย " . $ansChoice[0] . ". " . $ansChoice[1] . "</td>" ;
                    echo "<br>";
                  }
                  echo "<hr>";
                } // end for -> วนตามวิชา
                // $data_Ans[$numSub+1][$numTopi+1] = $ansChoice;

                // --------------- Sum of Ans ----------------------
                // print_r($data_Ans);
                // ชุด / วิชา / ข้อ / [เฉลย]
                // echo "Ans 1 1 1  = " . $data_Ans[$numExam+1][1][1][0];
                // $data_Ans[ชุด 1][วิชา 1][ข้อ 1][[เฉลย][0][1]];

                $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
                ob_end_flush();
                $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
                $pdf->SetAutoFont();
                $pdf->SetDisplayMode('fullpage');
                $pdf->WriteHTML($html, 2);
                // $pdf->Output("MyPDF.pdf");

                $nameFile = "PDF" . $numExam . ".pdf";

                $pdf->Output($nameFile);
                // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง
                ?>
                <!-- echo"<td><label></label><a href='testVeiw_pdf.php?exam_id=$row[0]'
                title='ออกข้อสอบ'><img src = 'icon/pdf.png' width=30 px></label></span>
              </td>"; -->

              <label class="col-sm-offset-9 col-sm-3">
                <a target="_blank" href="<?=$nameFile?>"><img src = "icon/pdf.png" width=30 px />พิมพ์ข้อสอบ ชุดที่ <?php echo $numExam+1; ?></a>
                <br />
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
  <div class="container w3-padding-16 w3-animate-opacity">
    <div class="container-fluid">
      <div class="col-sm-offset-1 col-sm-10">
        <div class="panel">
          <div class="panel-heading w3-red">
            ตารางแสดงรายการข้อสอบที่เลือก
          </div>
          <div class="panel-body">
            <?php

            // print_r($data_Ans); // all ans
            for($i = 1; $i<=count($data_Ans); $i++){
              ob_start();
              echo "<p><span style='font-size: 14pt; font-weight: bold;'>
              เฉลยข้อสอบ ชุดที่". $i ." <button type='button' class='btn btn-danger'
              data-toggle='collapse' style='padding: 2px 9px; margin-right: 9px;' data-target='#ans$i'>-</button></span></p>";

              echo "<div class='panel-body collapse' id='ans$i'>";
              for($j = 1; $j<=count($data_Ans[$i]); $j++){
                echo "วิชาที่ ". $j;
                echo "<table class='table table-hover'>";
                //หัวข้อตาราง
                echo "
                <thead>
                <tr>
                </tr>
                </thead>
                ";
                //echo $data_Ans[$i][$j][1][0];
                echo "<tbody>";
                for($k = 1; $k<=count($data_Ans[$i][$j]); $k++){

                  echo "<tr>";
                  echo "<td width='10%' style='text-align: left;'>" . $k . ")</td> ";
                  echo "<td style='text-align: left;'>". $data_Ans[$i][$j][$k][0] . ". ";
                  echo $data_Ans[$i][$j][$k][1];
                  echo "</td><tr />";

                }
                echo "</tbody>";
                echo "</table>";
              }
              // echo "Ans 1 1 1  = " . $data_Ans[$numExam+1][1][1][0];
              // echo $data_Ans[i][i][i][$ansChoice[0][1]];
              $html = ob_get_contents();        //เก็บค่า html ไว้ใน $html
              ob_end_flush();
              $pdf = new mPDF('th', 'A4', '0', '');   //การตั้งค่ากระดาษถ้าต้องการแนวตั้ง ก็ A4 เฉยๆครับ ถ้าต้องการแนวนอนเท่ากับ A4-L
              $pdf->SetAutoFont();
              $pdf->SetDisplayMode('fullpage');
              $pdf->WriteHTML($html, 2);
              // $pdf->Output("MyPDF.pdf");

              $nameFile = "PDFans" . $i . ".pdf";

              $pdf->Output($i);
              // เก็บไฟล์ html ที่แปลงแล้วไว้ใน MyPDF/MyPDF.pdf ถ้าต้องการให้แสดง
              ?>
              <label class="col-sm-offset-9 col-sm-3">
                <a target="_blank" href="<?=$i?>"><img src = "icon/pdf.png" width=30 px />พิมพ์เฉลย ชุดที่ <?php echo $i; ?></a>
                <br />
              </label>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!--
for i = 1; i<=count($data_Ans)
#ชุดที่
for j ; j<=count($data_Ans[$i])
-->

<!-- end div -->

</body>
</html>
