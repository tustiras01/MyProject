<?php
require_once('mpdf/mpdf.php');
ob_start();
?>
<?php
include("jscss.php");
include("mysqlconnect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
  <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
  </head>
  <body>
    <?php
    session_start();
    //echo $_SESSION['name'];
    // echo "OK";
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
      <table align="left" cellpadding="6" cellspacing="6">
        <tr>
          <td align="left"><span style="font-size: 11pt; font-weight: bold; text-decoration: underline;">
            รายวิชา 344-493 ประมวลความรอบรู้เชิงวิชาชีพ</span>
          </td>
        </tr>
      </table>

      <?php
      //1. เชื่อมต่อ database:  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
      $ran = 'สุ่ม';
      //2. query ข้อมูลจากตาราง tb_member:
      $query = "SELECT * FROM create_exam WHERE send_random = '$ran'
      ORDER BY exam_id asc" or die("Error:" . mysqli_error());
      //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
      $result = mysqli_query($dbc, $query);

      while($row = mysqli_fetch_array($result)) { // outer loop ชุดข้อสอบ
        $no = $row["test_no"];
        echo "<h3>" . $row["exam_name"] . "</h3>";
        $exam_id = $row["exam_id"];
        $qu = "SELECT * FROM test_exam WHERE exam_id = $exam_id ORDER BY RAND() LIMIT 0,5";
        //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result .
        $resulta = mysqli_query($dbc, $qu);
        //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
        $num = 0;
        while($rowa = mysqli_fetch_array($resulta)) { // inner loop ข้อสอบแต่ละข้อ
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
          echo "Choice " . $Answer[0] . " Value = " . $Answer[1];


          // print_r($choices);


          ?>
          <table align="left" cellpadding="4" cellspacing="0">
            <tr>
              <td align="left"><span
                style="font-size: 11pt; font-weight: bold;">
                <?php echo $num; ?>.
                <?php echo $rowa["test_name"]; ?></span>
              </td>
            </tr>
            <tr>
              <?php  $image_name = $rowa["test_namepic"];
              if(empty( $image_name )) {
              } else {
                echo "<td>" . "<img src='img/".$rowa["test_namepic"]."' width='500' align='center'>" . "</td> <br />";
              }?>
            </tr>
            <tr>
              <td>

              </td>
            </tr>
            <tr>
              <td align="left"><label><span
                style="font-size: 11pt;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                1. <?php echo $choices[0];?></span></label>
              </td>

            </tr>
            <tr>
              <td align="left"><label><span
                style="font-size: 11pt;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                2. <?php echo $choices[1];?></span></label>
              </td>
            </tr>
            <tr>
              <td align="left"><label><span
                style="font-size: 11pt;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                3. <?php echo $choices[2];?></span></label>
              </td>
            </tr>
            <tr>
              <td align="left"><label><span
                style="font-size: 11pt;">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                4. <?php echo $choices[3];?></span></label>
              </td>
              <tr>
                <td>
                </td>
              </tr>
            </tr>
          </table>
        </div>
        <?php  } // inner loop
      } // outer loop
      ?>
    </div>
    <footer style="position: absolute; bottom: 10px; right: 16px;">
      รายวิชา 344-493 ประมวลความรอบรู้ทางวิทยาการคอมพิวเตอร์
    </footer>
  </body>
  </html>
  <?Php
  $html = ob_get_contents();
  ob_end_clean();
  $pdf = new mPDF('th', 'A4', '0', 'THSaraban');
  $pdf->SetAutoFont();
  $pdf->SetDisplayMode('fullpage');
  $pdf->WriteHTML($html, 2);
  $pdf->Output();
  ?>
  <!-- ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a> -->
