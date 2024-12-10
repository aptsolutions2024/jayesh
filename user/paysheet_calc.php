<?php 

$sqltab = "DROP TABLE IF EXISTS $tab" ;
$rowtab= mysql_query($sqltab);
$i = 0;
$days[]=0;
$sql = "create table $tab (  `client_id` int not null, `desg_id` int not null, `dept_id` int not null, `qualif_id` int not null, `bank_id` int not null, `loc_id` int not null, `paycode_id` int not null,  `pay_mode` varchar(1) not null ,bankacno varchar(30) not null,emp_id int not null, `client_name` VARCHAR(50), `sal_month` DATE NOT NULL, `emp_name` VARCHAR(50)";


 $sql_days = "select  sum(`fullpay`) as fullpay, sum(`halfpay`) as halfpay, sum(`leavewop`) as leavewop, sum(`present`) as present, sum(`absent`) as absent, sum(`weeklyoff`) as weeklyoff, sum(`pl`) as pl, sum(`sl`) as sl, sum(`cl`) as cl, sum(`otherleave`) as otherleave, sum(`paidholiday`) as paidholiday, sum(`additional`) as additional, sum(`othours`) as othours, sum(`nightshifts`)as nightshifts, sum(`extra_inc1`) as extra_inc1, sum(`extra_inc2`) as extra_inc2, sum(`extra_ded1`) as extra_ded1, sum(`extra_ded2`) as extra_ded2, sum(`wagediff`) as wagediff, sum(`Allow_arrears`) as allow_arrears , sum(`Ot_arrears`) as ot_arrears from $tab_days where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt' ";
$rowtab= mysql_query($sql_days);
while($rowtab1 = mysql_fetch_array($rowtab)){
	
	if ($rowtab1['present'] >0){$sql=$sql.",`present` float not null";$days[$i]='present';$i++;}
	if ($rowtab1['weeklyoff'] >0){$sql=$sql.",`weeklyoff` float not null";$days[$i]='weeklyoff';$i++;}
	if ($rowtab1['absent'] >0){$sql=$sql.",`absent` float not null";$days[$i]='absent';$i++;}
	if ($rowtab1['paidholiday'] >0){$sql=$sql.",`paidholiday` float not null";$days[$i]='paidholiday';$i++;}
	if ($rowtab1['pl'] >0){$sql=$sql.",`pl` float not null";$days[$i]='pl';$i++;}
	if ($rowtab1['sl'] >0){$sql=$sql.",`sl` float not null";$days[$i]='sl';$i++;}
	if ($rowtab1['cl'] >0){$sql=$sql.",`cl` float not null";$days[$i]='cl';$i++;}
	if ($rowtab1['additional'] >0){$sql=$sql.",`additional` float not null";$days[$i]='additional';$i++;}
	if ($rowtab1['othours'] >0){$sql=$sql.",`othours` float not null";$days[$i]='othours';$i++;}
	if ($rowtab1['nightshifts'] >0){$sql=$sql.",`nightshifts` float not null";$days[$i]='nightshifts';$i++;}
	if ($rowtab1['fullpay'] >0){$sql=$sql.",`fullpay` float not null";$days[$i]='fullpay';$i++;}
	if ($rowtab1['halfpay'] >0){$sql=$sql.",`halfpay` float not null";$days[$i]='halfpay';$i++;}
	if ($rowtab1['leavewop'] >0){$sql=$sql.",`leavewop` float not null";$days[$i]='leavewop';$i++;}
	if ($rowtab1['otherleave'] >0){$sql=$sql.",`otherleave` float not null";$days[$i]='otherleave';$i++;}
	break;
}
$sql=$sql.",`payabledays` float not null";

$sql_inc = "select distinct ti.head_id,trim(mi.income_heads_name) as income_heads_name from $tab_inc  ti inner join mast_income_heads mi on ti.head_id = mi.mast_income_heads_id  inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt'"; 
$rowtab= mysql_query($sql_inc);


while($rowtab1 = mysql_fetch_array($rowtab)){
	$sql=$sql.",`".strtolower($rowtab1['income_heads_name'])."` float not null";
	$inhdar[$inhd] = $rowtab1['income_heads_name'];
	$inhd++;
}
$sql=$sql.",`gross_salary` float not null";



 $sql_ded = "select distinct tdd.head_id,trim(md.deduct_heads_name) as deduct_heads_name from $tab_empded  tdd inner join mast_deduct_heads md on tdd.head_id = md.mast_deduct_heads_id  inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt'";   
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	$sql=$sql.",`".strtolower($rowtabd1['deduct_heads_name'])."` float not null";
	
	$dedhdar[$dedhd] = $rowtabd1['deduct_heads_name'];
	$dedhd++;
}

  $sql_adv = "select distinct tadv.head_id,trim(madv.advance_type_name) as advance_type_name from $tab_adv  tadv inner join mast_advance_type madv on tadv.head_id = madv.mast_advance_type_id    where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt'";   

$rowtaba= mysql_query($sql_adv);

while($rowtaba1 = mysql_fetch_array($rowtaba)){

	$sql=$sql.",`".strtolower($rowtaba1['advance_type_name'])."` float not null";
	
	$advhdar[$advhd] = $rowtaba1['advance_type_name'];
	$advhd++;
}




$sql=$sql.",`tot_deduct` float not null";
$sql=$sql.",`netsalary` float not null";

$sql=$sql.",`bankname` varchar(150) not null";

$sql=$sql.",`deptname` varchar(100) not null";
$sql=$sql.",`designation` varchar(100) not null";
$sql=$sql.",`qualification` varchar(100) not null";
$sql=$sql.",`location` varchar(100) not null";
$sql=$sql.",`cc_code` varchar(100) not null";
$sql = $sql." ) ENGINE = InnoDB";
$row= mysql_query($sql);



//tran/hist employee

 $sql = "insert into $tab ( `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`, payabledays,`gross_salary`,`tot_deduct`, `netsalary`)  select `client_id`, `desg_id` , `dept_id` , `qualif_id` , `bank_id` , `loc_id`, `paycode_id` ,`pay_mode`,bankacno ,emp_id,`sal_month`,payabledays, `gross_salary`,`tot_deduct`, `netsalary`  from $tab_emp where client_id = '$client_id' and comp_id = '$comp_id' and user_id = '$user_id' and sal_month >= '$frdt' and sal_month <= '$todt'";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_client mc on mc.mast_client_id = t.client_id set t.client_name = mc.client_name";
$row= mysql_query($sql);
 
$sql= "update $tab t inner join mast_desg md on md.mast_desg_id = t.desg_id set  t.designation = md.mast_desg_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_dept md on md.mast_dept_id = t.dept_id set  t.deptname = md.mast_dept_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_qualif mq on mq.mast_qualif_id = t.qualif_id set  t.qualification = mq.mast_qualif_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join mast_location ml on ml.mast_location_id = t.loc_id set  t.location = ml.mast_location_name";
$row= mysql_query($sql);

$sql= "update $tab t inner join paycode mp on mp.mast_paycode_id = t.paycode_id set  t.cc_code = mp.mast_paycode_name";
$row= mysql_query($sql);

 $sql= "update $tab t inner join mast_bank mb on mb.mast_bank_id = t.bank_id set  t.bankname = concat(mb.bank_name,' ',mb.branch,' ',mb.ifsc_code)";

$row= mysql_query($sql);
$sql= "update $tab t inner join employee e on e.emp_id = t.emp_id set  t.emp_name =concat( e.first_name,' ',e.middle_name,' ' , e.last_name) ";
$row= mysql_query($sql);

//Tran/hist days
$sql= "update $tab t inner join $tab_days td on t.emp_id=td.emp_id and t.sal_month= td.sal_month set ";
for ($j =0;$j<$i;$j++){
	$sql = $sql. "t.`".$days[$j]."` = td.`".$days[$j]."`,";
}
$sql = $sql." t.present= td.present where td.client_id = '$client_id' and td.comp_id = '$comp_id' and td.user_id = '$user_id' and td.sal_month >= '$frdt' and td.sal_month <= '$todt'";

//echo $sql;

$row= mysql_query($sql);


//tran_hist income
$rowtab= mysql_query($sql_inc);
while($rowtab1 = mysql_fetch_array($rowtab)){
	
	 $sql = "update $tab t inner join (select ti.emp_id,ti.sal_month,ti.head_id,ti.amount,mih.income_heads_name as head_name from $tab_inc  ti inner join mast_income_heads mih on ti.head_id=mih.mast_income_heads_id   inner join $tab_emp  te on te.emp_id = ti.emp_id and te.sal_month = ti.sal_month  where ti.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and ti.sal_month >= '$frdt' and ti.sal_month <= '$todt' and  mih.income_heads_name like '%".strtolower($rowtab1['income_heads_name'])."%'  ) inc on t.emp_id = inc.emp_id and t.sal_month = inc.sal_month set t.`".strtolower($rowtab1['income_heads_name'])."` = inc.amount";
	$row= mysql_query($sql);
}
////tran_hist income deduction updation
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	$row= mysql_query($sql);
}



////tran_hist income deduction updation
$rowtabd= mysql_query($sql_ded);
while($rowtabd1 = mysql_fetch_array($rowtabd)){
	
	 $sql = "update $tab t inner join (select tdd.emp_id,tdd.sal_month,tdd.head_id,tdd.amount,mdh.deduct_heads_name as head_name from $tab_empded  tdd inner join mast_deduct_heads mdh on tdd.head_id=mdh.mast_deduct_heads_id   inner join $tab_emp  te on te.emp_id = tdd.emp_id and te.sal_month = tdd.sal_month  where tdd.amount > 0 and te.client_id = '$client_id' and te.comp_id = '$comp_id' and te.user_id = '$user_id' and tdd.sal_month >= '$frdt' and tdd.sal_month <= '$todt' and  mdh.deduct_heads_name like '%".strtolower($rowtabd1['deduct_heads_name'])."%'  ) ded on t.emp_id = ded.emp_id and t.sal_month = ded.sal_month set t.`".strtolower($rowtabd1['deduct_heads_name'])."` = ded.amount";
	$row= mysql_query($sql);
}


////tran_hist advance updation
$rowtaba= mysql_query($sql_adv);
while($rowtaba1 = mysql_fetch_array($rowtaba)){
	
	 $sql = "update $tab t inner join (select tadv.emp_id,tadv.sal_month,tadv.head_id,tadv.amount,mah.advance_type_name  as head_name from $tab_adv  tadv inner join mast_advance_type  mah on tadv.head_id=mah.mast_advance_type_id     where tadv.amount > 0 and tadv.client_id = '$client_id' and tadv.comp_id = '$comp_id'  and tadv.sal_month >= '$frdt' and tadv.sal_month <= '$todt' and  mah.advance_type_name  like '%".strtolower($rowtaba1['advance_type_name'])."%'  ) adv on t.emp_id = adv.emp_id and t.sal_month = adv.sal_month set t.`".strtolower($rowtaba1['advance_type_name'])."` = adv.amount";
	$row= mysql_query($sql);
}


?> 