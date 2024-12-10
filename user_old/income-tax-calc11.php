<?php
session_start();
set_time_limit(0);
include("../lib/connection/db-config.php");
include("../lib/class/user-class.php");
$userObj=new user();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$comp_id=$_SESSION['comp_id'];
$user_id=$_SESSION['log_id'];
$year=$_SESSION['yr'];

if ($year== "")
{echo "Please select  Year.";
 exit;
}
$stryr=explode(" - ",$year);
$fromdate=$stryr[0]."-04-01";
$todate="20".$stryr[1]."-03-31";


$sqlimit = "SELECT `limit_80c` FROM `it_slabs` WHERE `year`='".$year."'";
$rowlimit= mysql_query($sqlimit);
$reslimit= mysql_fetch_array($rowlimit);

$limit_80c=$reslimit['limit_80c'];

$sqlb = "SELECT  `current_month` FROM `mast_client` WHERE comp_id='".$comp_id."'";
$rowb= mysql_query($sqlb);
$resb= mysql_fetch_array($rowb);

$salmounth=$resb['current_month'];
$salm=date('m', strtotime($salmounth));
$emp=$_POST['emp'];


$inEmpidval='';
$Empidval='';
$Empidval1="";
if($emp!='all'){
   $empid=$_POST['empid'];
    $inEmpidval=" AND ti.emp_id=".$empid;
    $Empidval=" AND emp_id=".$empid;
    $Empidval1=" Where emp_id=".$empid;
}

if($salmounth>=$fromdate && $salmounth<=$todate){

    if($salm>3){
        $mfactor=12-($salm-3);
    }
    else{
        $mfactor=3-$salm;
    }

}
else{
    $mfactor=0;
}


//temp tables creation
$sqltab = "DROP TABLE IF EXISTS tab_itcalc".$user_id ;
$rowtab= mysql_query($sqltab);



$sqltab = "create table tab_itcalc".$user_id ."  (select * from  itcalc where 1=2)";
$rowtab= mysql_query($sqltab);


//history and tran employee 
 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `gross_salary`,`proj_months`,`sal_month`,`year`) select emp_id,gross_salary,'$mfactor',sal_month,'$year' from hist_employee where sal_month>='$fromdate' AND sal_month<='$todate'   AND comp_id='".$comp_id."' AND user_id='".$user_id."'".$Empidval;
$rowt= mysql_query($sql);

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `gross_salary`,`proj_months`,sal_month,`year`) select emp_id,gross_salary,'$mfactor',sal_month,'$year' from tran_employee where sal_month>='$fromdate' AND sal_month<='$todate'  AND comp_id='".$comp_id."' AND user_id='".$user_id."' ".$Empidval;
$rowt= mysql_query($sql);

//history and tran conveyance 

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `conveyance`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_income where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%Conveyance%'  AND comp_id='$comp_id'))  " .$Empidval;
$rowt= mysql_query($sql);

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `conveyance`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_income where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%Conveyance%'  AND comp_id='$comp_id'))  " .$Empidval;
$rowt= mysql_query($sql);


//history and tran hra 
 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `hra`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_income where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%H.R.A.%'  AND comp_id='$comp_id'))  " .$Empidval;
$rowt= mysql_query($sql);

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `hra`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_income where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%H.R.A.%'  AND comp_id='$comp_id'))  " .$Empidval;
$rowt= mysql_query($sql);



//history and tran incometax
  $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `prof_tax`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%INCOME TAX%'  and comp_id = '".$comp_id."')".$Empidval;
$rowt= mysql_query($sql);

  $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `prof_tax`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%INCOME TAX%'  and comp_id = '".$comp_id."') ".$Empidval;
$rowt= mysql_query($sql);


//history and tran prof. tax.
  $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `prof_tax`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."')".$Empidval;
$rowt= mysql_query($sql);

  $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `prof_tax`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%PROF. TAX%'  and comp_id = '".$comp_id."') ".$Empidval;
$rowt= mysql_query($sql);


//history and tran pf
$sql="insert into tab_itcalc".$user_id ."( `emp_id`, `pf`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%P.F.%'  and comp_id = '".$comp_id."') ".$Empidval;
$rowt= mysql_query($sql);

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `pf`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%P.F.%'  and comp_id = '".$comp_id."')".$Empidval;
$rowt= mysql_query($sql);

//history and tran esi
 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `esi`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from hist_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%'  and comp_id = '".$comp_id."')".$Empidval;
$rowt= mysql_query($sql);

 $sql="insert into tab_itcalc".$user_id ."( `emp_id`, `esi`,`proj_months`,sal_month,`year`) select emp_id,amount,'$mfactor',sal_month,'$year' from tran_deduct where sal_month>='$fromdate' AND sal_month<='$todate' AND head_id in(select mast_deduct_heads_id from mast_deduct_heads  where  `deduct_heads_name` LIKE '%E.S.I.%'  and comp_id = '".$comp_id."')".$Empidval;
$rowt= mysql_query($sql);

//temp tables creation
$sqltab = "DROP TABLE IF EXISTS tab_itcalc1".$user_id ;
$rowtab= mysql_query($sqltab);

// total in tab itcalc user_id
$sqltab = "create table tab_itcalc1".$user_id ."  (select year,emp_id,sum(gross_salary) as gross_salary,sum(conveyance) as conveyance,sum(hra) as hra ,sum(prof_tax) as prof_tax,sum(pf) as pf,sum(esi) as esi,proj_months,sal_month,sal_count ,sum(incometax) as incometax from  tab_itcalc".$user_id ." group by year,emp_id)";
$rowtab= mysql_query($sqltab);

// calc for projection
if($salmounth>=$fromdate && $salmounth<=$todate){

    if($salm>3){
    //    $mfactor=12-($salm-3);


   $sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set proj_months=(12-$salm+3)) where e.joindate<='$fromdate' AND (e.leftdate>'$todate' OR e.leftdate!='0000-00-00') ".$Empidval;
        $rowb= mysql_query($sql);

      $sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set proj_months=((12-Ssalm+3)) where e.joindate>'$fromdate' AND (e.leftdate>'$todate' OR e.leftdate!='0000-00-00') ".$Empidval;
        $rowb= mysql_query($sql);


        $sql="update tab_itcalc1".$user_id ." set gross_salary=gross_salary+(gross_salary*proj_months/($salm-month(e.joindate))),conveyance=conveyance+(conveyance*proj_months/(12-proj_months)),hra=hra+(hra*proj_months/(12-proj_months)),prof_tax=prof_tax+(prof_tax*proj_months/(12-proj_months)),pf=pf+(pf*proj_months/(12-proj_months)),esi=esi+(esi*proj_months/(12-proj_months))".$Empidval;
        $rowt= mysql_query($sql);

    }
    else{
      //  $mfactor=3-$salm;
        $sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set proj_months=(3-$salm) where e.joindate<='$fromdate' AND (e.leftdate>'$todate' OR e.leftdate!='0000-00-00') ".$Empidval;
        $rowb= mysql_query($sql);

        $sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set proj_months=((3-$salm)) where e.joindate>'$fromdate' AND (e.leftdate>'$todate' OR e.leftdate!='0000-00-00') ".$Empidval;
        $rowb= mysql_query($sql);
    }

}
else{
  //  $mfactor=0;
    $sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set ti.proj_months=0 ".$Empidval1;
    $rowb= mysql_query($sql);
}

$sql="update tab_itcalc1".$user_id ." ti inner join employee e on  e.emp_id=ti.emp_id set ti.proj_months=0 Where  e.job_status='L' ".$Empidval;
$rowb= mysql_query($sql);



 $sql="update tab_itcalc1".$user_id ." ti INNER JOIN (SELECT  count(DISTINCT sal_month) as count,emp_id FROM tab_itcalc".$user_id ." group by emp_id) tc on ti.emp_id=tc.emp_id set ti.sal_count=tc.count";
$rowt= mysql_query($sql);



 $sql="update tab_itcalc1".$user_id ." set gross_salary=gross_salary+(gross_salary*proj_months/sal_count),conveyance=conveyance+(conveyance*proj_months/sal_count),hra=hra+(hra*proj_months/sal_count),prof_tax=prof_tax+(prof_tax*proj_months/sal_count),pf=pf+(pf*proj_months/sal_count),esi=esi+(esi*proj_months/sal_count)".$Empidval;
$rowt= mysql_query($sql);


$sql="update tab_itcalc1".$user_id ." set conveyance=19200 where conveyance>19200 ".$Empidval;
$rowt= mysql_query($sql);

$sql="update tab_itcalc1".$user_id ." set prof_tax=2500 where prof_tax=2400 ".$Empidval;
$rowt= mysql_query($sql);

$sql = "select * from tab_itcalc1".$user_id ;
$row1= mysql_query($sql);
while ($row11= mysql_fetch_array($row1))
{$mheaex1 = 0;
 $mhraex2 = 0;
 $mhraex3 = 0; 
   $mhraex1 = round($row11['hra'],0);
     $sql2= "select hrapaid from it_file2 where year = '".$year."' and emp_id = '".$row11['emp_id']."' and hrapaid > 0";
	$row2= mysql_query($sql2);
	$row21= mysql_fetch_array($row2);

    $mhrapaid_pm= round($row21['hrapaid']/12,0);
	 
	  $sql1= "SELECT std_amt as amount FROM emp_income WHERE   emp_id = '".$row11["emp_id"]."' and head_id in (select mast_income_heads_id from mast_income_heads  where  (`income_heads_name` LIKE '%BASIC%' or `income_heads_name` LIKE '%BASIC+DA%'   ) and comp_id = '".$comp_id."'  )";
	 
	 
   $row2= mysql_query($sql1);
	$row21= mysql_fetch_array($row2);
   
    $mbasic_10= round($row21['amount']*.1,0);
	$mhraex2 = ($mhrapaid_pm-$mbasic_10)*12;
	echo "<br>";
	//echo "gross_salary ". $row11['gross_salary']."   .5% - ";
	$mhraex3 = $row21['amount']*12*.5;
 	$sql3= "update tab_itcalc1".$user_id ." set hra =".min($mhraex1,$mhraex2,$mhraex3)." where emp_id = '".$row11['emp_id']."'";
	$row2= mysql_query($sql3);
	
}
$sql="update tab_itcalc1".$user_id ." set hra=0 where hra<0 ".$Empidval;
$rowt= mysql_query($sql);

 /*mhraex1 = hrapaid-(totgrsal*.1)
    mhraex2 = totgrsal*.4
    mhraex3 = hra
    repl hraex with min(mhraex1,mhraex2,mhraex3)
    if hraex < 0 
       repl hraex with 0 
    endif   
   */
 $sql1 = "insert into  tab_itcalc1".$user_id . "(`year`, `emp_id`, gross_salary) select  '$year',emp_id, tot_bonus_amt+tot_exgratia_amt  from bonus where updated>='$fromdate' AND updated<='$todate'  ".$Empidval;
 $row= mysql_query($sql1);
echo "<br>";

 $sql1 = "insert into  tab_itcalc1".$user_id . "(`year`, `emp_id`, gross_salary) select  '$year',emp_id, amount  from leave_details  where payment_date>='$fromdate' AND payment_date<='$todate'".$Empidval ;
 $row= mysql_query($sql1);

 
 
echo  $sql="select  `year`, `emp_id`, sum(`gross_salary`) as gross_salary , `conveyance`, `hra`, `prof_tax`, `pf`, `esi`, `proj_months`, `sal_month`, `sal_count`, `incometax` from tab_itcalc1".$user_id ." where year='".$year."' ".$Empidval . " group by emp_id";
 $row= mysql_query($sql);
	
			
//temp tables creation
$sqltab = "DROP TABLE IF EXISTS tab_it1_".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_it1_".$user_id ."  (select * from  it_file1 where 1=2)";
$rowtab= mysql_query($sqltab); 


$sqltab = "DROP TABLE IF EXISTS tab_it3_".$user_id ;
$rowtab= mysql_query($sqltab);

$sqltab = "create table   tab_it3_".$user_id ."  (select * from  it_file2 where year='".$year."'  AND comp_id='".$comp_id."' AND user_id='".$user_id."' $Empidval )";
$rowtab= mysql_query($sqltab);

while($res= mysql_fetch_array($row)){
    print_r($res);
    $tempempid=$res['emp_id'];
    $tempgross_salary=$res['gross_salary'];
  //  $tempconveyance=$res['conveyance'];
      $tempconveyance=0;
    $temphra=$res['hra'];
	$tempconveyancehra=$res['conveyance']+$res['hra'];
	
    $tempprof_tax=$res['prof_tax'];
    $tempesi=$res['esi'];
    $temppf=$res['pf'];
    $temppfesi=$res['pf']+$res['esi'];
	


 //   $sql2="INSERT INTO tab_it1_".$user_id ."(`year`,`from_date`,`to_date`, `emp_id`, `col_1`,`col_2_1`, `col_4c_1`,`col_9a_1`,comp_id,user_id) VALUES ('$year','$fromdate','$todate','$tempempid','$tempgross_salary','$tempconveyancehra','$tempprof_tax','$temppfesi','$comp_id','$user_id')";
   $sql2="INSERT INTO tab_it1_".$user_id ."(`year`,`from_date`,`to_date`, `emp_id`, `col_1`,`col_2_1`, `col_4c_1`,`col_9a_1`,comp_id,user_id) VALUES ('$year','$fromdate','$todate','$tempempid','$tempgross_salary','0','$tempprof_tax','$temppfesi','$comp_id','$user_id')";
    $row2= mysql_query($sql2);


    $sql2="INSERT INTO tab_it3_".$user_id ." ( `comp_id`, `user_id`, `year`, `emp_id`,`allow_name`, `allow_amt`) VALUES ('$comp_id','$user_id','$year','$tempempid','Conveyance','".$tempconveyance."')";
    $row2= mysql_query($sql2);

    if ($temphra > 0) 
	{		$sql2="INSERT INTO tab_it3_".$user_id ." ( `comp_id`, `user_id`, `year`, `emp_id`,`allow_name`, `allow_amt`) VALUES ('$comp_id','$user_id','$year','$tempempid','H.R.A.','".$temphra."')";
		$row2= mysql_query($sql2);
}
    $sql2="INSERT INTO  tab_it3_".$user_id ." (`comp_id`, `user_id`, `year`, `emp_id`,  `80C_desc`, `80c_amt`) VALUES ('$comp_id','$user_id','$year','$tempempid','P.F.','".$temppf."')";
    $row2= mysql_query($sql2);

    $sql2="INSERT INTO  tab_it3_".$user_id ." (`comp_id`, `user_id`, `year`, `emp_id`,  `80C_desc`, `80c_amt`) VALUES ('$comp_id','$user_id','$year','$tempempid','E.S.I.','".$tempesi."')";
    $row2= mysql_query($sql2);



}


 $sql4="update tab_it1_".$user_id ." ti  set ti.col_4a_1 =40000 where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);


 $sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(allow_amt) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_2_1=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);


 $sql4="update tab_it1_".$user_id ."  ti INNER JOIN (SELECT sum(income_amt) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_7_2=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(80c_amt) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_9a_1=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(80ccc) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_9b_2=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(80ccd) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_9b_3=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);


$sql4=="update tab_it1_".$user_id ." set col_9b_3 =col_9a_3+col_9b_2 where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);

$sql11="update tab_it1_".$user_id ." set col_9b_3 = ".$limit_80c." where  col_9b_3 > ".$limit_80c."  where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql11);




$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(deduct_amt) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.other_sections_6a=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);

/*
$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(80ccf) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_9b_3=tc.amount where ti.year='".$year."' ";
$row4= mysql_query($sql4);
*/


$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(relief_89) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_15_2=tc.amount where ti.year='".$year."' ".$inEmpidval;
$row4= mysql_query($sql4);
/*
$sql4="update tab_it1_".$user_id ." ti INNER JOIN (SELECT sum(taxbenefit_87) as amount,emp_id,year FROM tab_it3_".$user_id ." where year='".$year."' group by emp_id) tc on ti.emp_id=tc.emp_id AND ti.year=tc.year set ti.col_15_2=tc.amount where ti.year='".$year."' ";
$row4= mysql_query($sql4);
*/


$sql4="update tab_it1_".$user_id ." set col_2_2=col_2_1,col_1d_2=col_1+col_1a_1+col_1b_1+col_1c_1,col_3_1=col_1d_2-col_2_2, col_4a_1=40000,col_5_1=40000+col_4b_1+col_4c_1,col_6_2=col_3_1-col_5_1,col_8_2=col_6_2+col_7_2,col_9a_2=col_9a_1,col_9c_3 = col_9a_2+col_9b_2+col_9b_3 where year='".$year."' ".$Empidval;
$row4= mysql_query($sql4);



$sql4="update tab_it1_".$user_id ." set col_9c_3='".$limit_80c."' where year='".$year."' AND col_9a_2>'".$limit_80c."'".$Empidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." set col_10_2=col_9c_3+other_sections_6a where year='".$year."'".$Empidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." set col_11_2=col_8_2-col_10_2 where year='".$year."' ".$Empidval;
$row4= mysql_query($sql4);




$sql41="SELECT * FROM `it_slabs` where year='".$year."' order by amt_to";
$row41= mysql_query($sql41);
$ress[]='';
$i=0;
 while($resss=mysql_fetch_array($row41)){
     $ress[$i]=$resss;
     $i++;
 }

 $sql41="SELECT col_11_2,from_date,to_date,emp_id,year  FROM tab_it1_".$user_id ." where year='".$year."'".$Empidval;
$row41= mysql_query($sql41);
while($res=mysql_fetch_array($row41)){
    $amt=$res['col_11_2'];
    $tax_val=0;
    foreach($ress as $rs){

        if($amt>$rs['amt_to']){
            $tax_val=$tax_val+($rs['amt_to']-$rs['amt_from'])*$rs['tax_percent']/100;
        }
        else{
            $tax_val=$tax_val+($amt-$rs['amt_from'])*$rs['tax_percent']/100;
         break;
        }

    }
    $sql44 = "update tab_it1_".$user_id ." set col_122_2 =".$tax_val." ,col_12_2=".$tax_val." where  year = '".$res['year'] ."' and emp_id = '". $res['emp_id']."' ";
    $row44 = mysql_query($sql44);
	
	

}


 $sql4="update tab_it1_".$user_id  ."  set col_121_2=col_12_2,col_122_2 =0 where  col_12_2 <= 2500  and  col_11_2 <=350000 and  year='".$year."'".$Empidval;
$row4= mysql_query($sql4);

 $sql4="update tab_it1_".$user_id  ."  set  col_121_2=2500,   col_122_2=col_12_2-2500 where col_12_2 > 2500  and col_11_2 <=350000 and   year='".$year."'".$Empidval;
$row4= mysql_query($sql4); 



 $sql4="update tab_it1_".$user_id  ."  set col_13_2=col_122_2*0.04 where year='".$year."'".$Empidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ."  set col_14_2=col_122_2+col_13_2 where year='".$year."'".$Empidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." set col_16_2=col_14_2-col_15_2 where year='".$year."'".$Empidval;
$row4= mysql_query($sql4);

$sql4="update tab_it1_".$user_id ." i INNER JOIN employee e on e.emp_id=i.emp_id set i.`comp_id`=e.comp_id, i.`user_id`=e.user_id where year='".$year."'".$Empidval;
$row4= mysql_query($sql4);



    $sql1="DELETE FROM `it_file1` WHERE year='".$year."'  AND comp_id='".$comp_id."' AND user_id='".$user_id."' ".$Empidval;
    $row1= mysql_query($sql1);
	
	$sql1= "insert into it_file1 select * from tab_it1_".$user_id ;
	$row1= mysql_query($sql1);
	

    $sql1="DELETE FROM `it_file3` WHERE year='".$year."' and comp_id='".$comp_id."' AND user_id='".$user_id."' ".$Empidval;
    $row1= mysql_query($sql1);
	$sql = "INSERT INTO `it_file3`( `comp_id`, `user_id`, `year`, `emp_id`, `col_name`, `allow_name`, `allow_amt`, `income_desc`, `income_amt`, `80C_desc`, `80c_amt`, `section_name`, `gross_amt`, `qual_amt`, `deduct_amt`, `hsg_intrest`, `80ccc`, `80ccd`, `80ccf`, `relief_89`, `taxbenefit_87`)
	        select  `comp_id`, `user_id`, `year`, `emp_id`, `col_name`, `allow_name`, `allow_amt`, `income_desc`, `income_amt`, `80C_desc`, `80c_amt`, `section_name`, `gross_amt`, `qual_amt`, `deduct_amt`, `hsg_intrest`, `80ccc`, `80ccd`, `80ccf`, `relief_89`, `taxbenefit_87` from  `tab_it3_".$user_id."`";
	//$sql1= "insert into it_file3 select * from tab_it3_".$user_id ;
	$row1= mysql_query($sql);
  



echo "**********";
exit;
echo "<script type=\"text/javascript\">
				alert(\"Income Tax Calculation has been successfully Calculated.\");
				window.location = \"income-calculation.php\"
		</script>";

?>

