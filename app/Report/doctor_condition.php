﻿<?php
// 厂商 医生情况统计表
  //header("Content-Type:text/html;charset=utf-8");
  $mysqli = new mysqli('118.244.197.36','root','HWVosvmGYP6knCjp6Ihx','robot');
  
  /* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
  /*解决字符编码*/
  $query="set names 'utf8'";
  $mysqli->query($query);

  $provinceid=$_POST['provinceid'];
  $cityid=$_POST['cityid'];
  $starttime=$_POST['starttime'];
  $endtime=$_POST['endtime'];
  $hospitalid=$_POST['hospitalid'];
 /*
  $starttime="2015-07-01 00:00:00";
  $endtime="2015-09-01 00:00:00";
  $provinceid=30;
  $cityid=8;
  $hospitalid=390;  //agency_id=905   hospital_id=390
*/
  if(! filter_var($starttime, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s"))))
  {
     die("invalid starttime");
  }
  
  if(! filter_var($endtime, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>"/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/s"))))
  {
     die("invalid endtime");
  }
  
  if(! filter_var($provinceid, FILTER_VALIDATE_INT))
  {
     die("invalid provinceid");
  }
  
  if(! filter_var($cityid, FILTER_VALIDATE_INT))
  {
     die("invalid cityid");
  }
  if(! filter_var($hospitalid, FILTER_VALIDATE_INT))
  {
     die("invalid hospitalid");
  }
  
  /**********医生信息表********/
  $query="DROP VIEW IF EXISTS `hospital_doctor`;";
  $mysqli->query($query);
  $query="create view hospital_doctor 
  (province_id,city_id,hospital_id,hospital_name,doctor_id,doctor_name,doctor_phone,doctor_email,doctor_level,doctor_title) as 
  select province_id,city_id,i_hospital.id,i_hospital.name,i_doctor.id,i_doctor.name,i_doctor.phone,i_doctor.email,i_doctor.level,i_doctor.title
  from i_hospital,i_doctor
  where province_id=$provinceid and city_id= $cityid and i_hospital.id=$hospitalid and i_hospital.id=i_doctor.hospital_id order by i_doctor.name ;";  
  $viewresult = $mysqli->query($query);

  //地区、医院、医生、手机、邮箱、等级、职位
  $query = "select province_id,city_id,hospital_name,doctor_name,doctor_phone,doctor_email,doctor_level,doctor_title from hospital_doctor;";
  $doctorresult = $mysqli->query($query);
  
  //使用Mark数量  受到时间限制
  $query = " select ifnull(num,0) as usenum from hospital_doctor as maintable left join 
  (select doctor_id,count(id) as num   from i_mark where hospital_id=$hospitalid and used_at>='$starttime' and used_at<='$endtime' group by doctor_id ) as subtable
  on maintable.doctor_id=subtable.doctor_id;";
  $useresult = $mysqli->query($query);
  
  //历史Mark数
  $query = " select ifnull(num,0) as historyusenum from hospital_doctor as maintable left join 
  (select doctor_id,count(id) as num   from i_mark where hospital_id=$hospitalid group by doctor_id ) as subtable on maintable.doctor_id=subtable.doctor_id;";
  $historyuseresult = $mysqli->query($query);
  
  
  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html>
		<head>
		 <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		  <style type="text/css">
              @media print
			  {
			     #show{
				   width:100%;
				   margin:0;
				   padding:0	 
				 }
				 table.gridtable {
				 font-size:8px  !important;
				 }
			  }  
			   table.gridtable {
			         
					  font-family: verdana,arial,sans-serif;
					  font-size:11px;
					  color:#333333;
					  border-width: 1px;
					  border-color: #666666;
					  border-collapse: collapse;
				  }
				  table.gridtable th {
					  border-width: 1px;
					  padding: 8px;
					  border-style: solid;
					  border-color: #666666;
					  background-color: #dedede;
					  text-align:center;
				  }
				  table.gridtable td {
				      text-align:center;
					  border-width: 1px;
					  padding: 8px;
					  border-style: solid;
					  border-color: #888888;
					  background-color: #fff;
				  }
		  </style>
		</head>
		<body>
    
		  <table id="show" class="gridtable" >
			<caption style="font-family:Arial, Helvetica;text-align:left;font-size:30px;text-align:center">医生情况统计表</caption>
			<thead>
				<tr style="background: #FFF"><th>省份id </th><th>城市id </th><th>医院 </th><th>医生 </th><th>使用Mark数量 </th><th>历史Mark数 </th><th>手机 </th>
				<th>邮箱 </th><th>等级 </th><th>职位 </th> </tr>
			</thead>
			<tbody>  ';
			
			
  $num=0; //初始化为0
  $i=0;
  
  while($doctorrow = $doctorresult->fetch_array()
		and $userow = $useresult->fetch_array()  
		and $historyuserow = $historyuseresult->fetch_array()
		)
		
	{//$s代表show
	  $sprovinceid = $doctorrow['province_id'];
	  $scityid = $doctorrow['city_id'];
	  $shospitalname = $doctorrow['hospital_name'];
      $sdoctorname = $doctorrow['doctor_name'];
	  $susenum[$num] = $userow['usenum'];
	  $shistoryusenum[$num] = $historyuserow['historyusenum'];
	  $sphone = $doctorrow['doctor_phone'];
	  $semail = $doctorrow['doctor_email'];
	  $slevel = $doctorrow['doctor_level'];
	  $stitle = $doctorrow['doctor_title'];
	  
	//按行显示至表格
	  echo "<tr><td> $sprovinceid </td><td> $scityid </td> <td>$shospitalname </td><td> $sdoctorname</td>
	       <td> $susenum[$num]</td> <td>$shistoryusenum[$num] </td> <td>$sphone</td> <td>$semail </td>
		   <td> $slevel </td>  <td>$stitle  </td>  
	  </tr>";
	  $num++;
	}
	
		$tsusenum=0;
		$tshistoryusenum=0;

	for($i=0;$i<$num;$i++)
	{
	   //算出各num总数,变量名前加ts，t代表total  s代表show
	    $tsusenum+=$susenum[$i];
		$tshistoryusenum+=$shistoryusenum[$i];
		
	}
	
		//将总数显示出来
		echo "<tr><td>总数 </td> <td style='border-right-width:0'> </td>
		    <td style='border-left-width:0;border-right-width:0'> </td>
			<td style='border-left-width:0'>  </td>
	       <td>$tsusenum </td> <td>$tshistoryusenum </td> <td style='border-right-width:0'> </td> 
		   <td style='border-left-width:0;border-right-width:0'> </td>
		   <td style='border-left-width:0;border-right-width:0'> </td>  
		   <td style='border-left-width:0;'> </td> 
	  </tr>";
		
	echo '</tbody>
		  </table> 
		</body>
		</html>';

  $mysqli->close();
?>