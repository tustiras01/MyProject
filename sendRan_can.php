<?php
//1. เชื่อมต่อ database:
include('mysqlconnect.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้าน้ี
//สร้างตัวแปรสำหรับรับค่าที่นำมาแก้ไขจากฟอร์ม
$exam_id = $_REQUEST["exam_id"];
$exam_name = $_REQUEST["exam_name"];
$send_random = $_REQUEST["send_random"];

//ทำการปรับปรุงข้อมูลที่จะแก้ไขลงใน database

$sql = "UPDATE create_exam SET
exam_name='$exam_name',
send_random='$send_random'
WHERE exam_id='$exam_id' ";

$result = mysqli_query($dbc, $sql) or die ("Error in query: $dbc " . mysqli_error());

mysqli_close($dbc); //ปิดการเชื่อมต่อ database

//จาวาสคริปแสดงข้อความเมื่อบันทึกเสร็จและกระโดดกลับไปหน้าฟอร์ม

if($result){
  echo "<script type='text/javascript'>";
  echo "alert('นำข้อสอบออกสำเร็จ');";
  echo "window.location = 'testRandom.php'; ";
  echo "</script>";
}
else{
  echo "<script type='text/javascript'>";
  echo "alert('Error back to Update again');";
  echo "</script>";
}
?>
