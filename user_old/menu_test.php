<?php
$page=basename($_SERVER['PHP_SELF']);
//print_r($_SESSION);
/*echo "<pre>";
print_r($_SERVER['REDIRECT_URL']);
echo "</pre>";*/
//print_r($_SESSION);
$user = $_SESSION['log_id'];
$ltype =$_SESSION['log_type'];
 $company = $_SESSION['comp_id'];
include_once("../lib/class/admin-class.php");
$adminObj=new admin();

$menues = $adminObj->getAllParentMenus1($company,$user);
//print_r($menues);
$rowsmenu = mysqli_num_rows($menues);
$showpages =$adminObj->showPages();
$remainmenues = $adminObj->getRemainMenus($company,$user);
$firstpage = $showpages;
?>
<style>
#cssmenus > ul > li > a.active{
color: #fff;
background: linear-gradient(#7D1A15,#D02E2B);
border: 1px solid #7D1A15 !important;
}
#cssmenus ul ul li:last-child > a {
    border-bottom:0;
}
</style>
<!--Menu starts here-->
<div class="twelve nav" >
<div class="row" >
    <div  class="contenttext dynamicmenues"  id='cssmenus'>
    <ul>
<?php while($row1 = $menues->fetch_assoc()){?>
<?php $pagedtl = $adminObj->getPageDetails($row1['model_id']); //print_r($pagedtl);?>
                        <li class='<?php if($pagedtl['page_name']==""){echo "has-sub";}?>'>
                            
                        <a href="<?php if($pagedtl['page_name']!=""){echo $pagedtl['page_name'];}else{echo "javascript:void(0)";}?>" <?php if($_SERVER['REDIRECT_URL']=="/".$pagedtl['page_name']){echo "class='active'";}?>><?php echo $pagedtl['title'];?></a>
                        <?php $child1 = $adminObj->getChildMenus($company,$row1['model_id'],$user);
                        if(mysqli_num_rows($child1) >0){?>
                            <ul>
                          <?php while($row2 = $child1->fetch_assoc()){
                          $pagedtl = $adminObj->getPageDetails($row2['model_id']);
                          ?>
                            <li class='<?php if($pagedtl['page_name']==""){echo "has-sub";}?>'>
                                <a href="<?php if($pagedtl['page_name']!=""){echo $pagedtl['page_name'];}else{echo "javascript:void(0)";}?>" <?php if($_SERVER['REDIRECT_URL']=="/".$pagedtl['page_name']){echo "class='active'";}?>><?php echo $pagedtl['title'];?></a>
                                <?php 
                                $child2 = $adminObj->getChildMenus($company,$row2['model_id'],$user);
                                if(mysqli_num_rows($child2) >0){ ?>
                                    <ul>
                                    <?php while($row3 = $child2->fetch_assoc()){
                                         $pagedtl = $adminObj->getPageDetails($row3['model_id']);
                                    ?>
                                    <li class='<?php if($pagedtl['page_name']==""){echo "has-sub";}?>'>
                                    <a href="<?php if($pagedtl['page_name']!=""){echo $pagedtl['page_name'];}else{echo "javascript:void(0)";}?>" <?php if($_SERVER['REDIRECT_URL']=="/".$pagedtl['page_name']){echo "class='active'";}?>><?php echo $pagedtl['title'];?></a>
                                    </li>
                                    <?php } ?>
                                    </ul>
                                <?php } ?>
                            </li>
                        <?php } ?>
                         </ul>
                        <?php }?>
                    </li> 
                   <?php } ?>
    </ul> 
	<ul>
		<?php
		if($ltype !=3){?>

            <li  <?php if($page=='index.php'){ ?>class='active'<?php } ?>><a href='/index'><span>Home</span></a></li>
              
            <li class='has-sub <?php 	if($page=='add-mast-client.php' || $page=='edit-mast-client.php'){ ?>active<?php } ?>'  ><a href="javascript:void()"><span>master's</span></a>
            <ul>
            <li <?php if($page=='add-mast-client.php' || $page=='edit-mast-client.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-department.php' || $page=='edit-mast-department.php'){ ?>class='noborder'<?php } ?> href='/add_mast_client'><span>Client</span></a></li>
            <li <?php if($page=='add-mast-department.php' || $page=='edit-mast-department.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-qualification.php' || $page=='edit-mast-qualification.php'){ ?>class='noborder'<?php } ?> href='/add_mast_department'><span>Department</span></a></li>
            <li <?php if($page=='add-mast-qualification.php' || $page=='edit-mast-qualification.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-designation.php' || $page=='edit-mast-designation.php'){ ?>class='noborder'<?php } ?> href='/add_mast_qualification'><span>Qualification</span></a></li>
            <li <?php if($page=='add-mast-designation.php' || $page=='edit-mast-designation.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='noborder'<?php } ?> href='/add_mast_designation'><span>Designation</span></a></li>
            <li <?php if($page=='add-mast-location.php' || $page=='edit-mast-location.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='add-mast-payscalecode.php' || $page=='edit-mast-payscalecode.php'){ ?>class='noborder'<?php } ?> href='/add_mast_location'><span>Location</span></a></li>
            <li <?php if($page=='add-mast-payscalecode.php' || $page=='edit-mast-payscalecode.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-bank.php' || $page=='edit-mast-bank.php'){ ?>class='noborder'<?php } ?> href='/add_mast_payscalecode'><span>Pay Scale Code</span></a></li>
            <li <?php if($page=='add-mast-bank.php' || $page=='edit-mast-bank.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-incomehead.php' || $page=='edit-mast-incomehead.php'){ ?>class='noborder'<?php } ?> href='/add_mast_bank'><span>Bank</span></a></li>
            <li <?php if($page=='add-mast-incomehead.php' || $page=='edit-mast-incomehead.php'){ ?>class='active'<?php } ?>><a <?php if($page=='add-mast-deductionheads.php' || $page=='edit-mast-deductionheads.php'){ ?>class='noborder'<?php } ?> href='/add_mast_incomehead'><span>Income Heads</span></a></li>
            <li <?php if($page=='add-mast-deductionheads.php' || $page=='edit-mast-deductionheads.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='add-mast-leavetype.php' || $page=='edit-mast-leavetype.php'){ ?>class='noborder'<?php } ?> href='/add_mast_deductionheads'><span>Deduction Heads</span></a></li>
            <li <?php if($page=='add-mast-leavetype.php' || $page=='edit-mast-leavetype.php'){ ?>class='active'<?php } ?>><a href='/add_mast_leavetype'  <?php if($page=='add-mast-advancetype.php' || $page=='edit-mast-advancetype.php'){ ?>class='noborder'<?php } ?>><span>Leave Type</span></a></li>
            <li <?php if($page=='add-mast-advancetype.php' || $page=='edit-mast-advancetype.php'){ ?>class='active'<?php } ?>><a href='/add_mast_advancetype' <?php if($page=='add-mast-advancetype.php'){ ?>class='noborder'<?php } ?>><span>Advance Type</span></a></li>

            </ul>
            </li>
            <li class='has-sub <?php if($page=='add-employee.php' || $page=='edit-employee.php' || $page=='edit-all-employee.php'){ ?>active<?php } ?>'><a href="javascript:void()"><span>Employee</span></a>
                <ul>
                    <li <?php if($page=='add-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='edit-employee.php'){ ?>class='noborder'<?php } ?> href='/add_employee'><span>Add Employee</span></a></li>
                    <li <?php if($page=='edit-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='edit-all-employee.php'){ ?>class='noborder'<?php } ?> href='/edit_employee'><span>Edit Employee</span></a></li>
                    <li <?php if($page=='edit-all-employee.php'){ ?>class='active'<?php } ?>><a href='/edit_all_employee' <?php if($page=='export-emp.php'){ ?>class='noborder'<?php } ?>><span>Edit All Employee</span></a></li>
                    <li class="has-sub">
                        <a href="javascript:void()">Export</a>
                        <ul>
                            <li <?php if($page=='export-emp.php'){ ?>class='active'<?php } ?>><a href='/export_emp_page'><span>Master Employee</span></a></li>
                            <li <?php if($page=='export-emp-income-page.php'){ ?>class='active'<?php } ?>><a href='/export_emp_income_page'><span>Income</span></a></li>
                            <li <?php if($page=='export-emp-deduct-page.php'){ ?>class='active'<?php } ?>><a href='/export_emp_deduct_page'><span>Deduct</span></a></li>
                            <li <?php if ($comp_id !='11'){if($page=='export-leave.php'){ ?>class='active'<?php } ?>><a href='/export_leave'><span>Leave</span></a><?php  } ?></li>
                            <li <?php if ($comp_id !='11'){ if($page=='export-advance.php'){ ?>class='active'<?php } ?>><a href='/export_advance' class="noborder" ><span>Advance</span></a><?php  } ?></li>
							<li <?php if($page=='export-active-employee.php'){ ?>class='active'<?php } ?>><a href='/export_active_employee' class="noborder" ><span>Active Employee</span></a></li>
                        </ul>
                    </li>
                    <li class="has-sub">
                        <a href="javascript:void()" class="noborder">Import</a>
                        <ul>
                            <li <?php if($page=='import-emp.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='import-income.php'){ ?>class='noborder'<?php } ?> href='/import_emp'><span>Master Employee</span></a></li>
                            <li <?php if($page=='import-income.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='import-deduct.php'){ ?>class='noborder'<?php } ?> href='/import_income'><span>Income</span></a></li>
                            <li <?php if($page=='import-deduct.php'){ ?>class='active'<?php } ?>><a href='/import_deduct' class="noborder"><span>Deduct</span></a></li>
                        </ul>
                   </li>
                </ul>
            </li>
		
            <li class="has-sub"><a href="javascript:void()"><span>Salary</span></a>
                <ul>
                    <li  <?php if($page=='tran-day.php'){ ?>class='active'<?php } ?>><a  <?php if($page=='tran-calculation.php'){ ?>class='noborder'<?php } ?> href='/tran_day'><span>Input Days</span></a></li>
                    <li <?php if($page=='tran-calculation.php'){ ?>class='active'<?php } ?>><a href='/tran_calculation' <?php if($page=='import-transactions.php'){ ?>class='noborder'<?php } ?>  ><span>Calculation</span></a></li>
                       <!--                 <li><a href='export.php'><span>Export</span></a></li>-->
                    <li <?php if($page=='import-transactions.php'){ ?>class='active'<?php } ?>><a href='/import_transactions'  <?php if($page=='tran-leave.php'){ ?>class='noborder'<?php } ?> ><span>Import & Export </span></a></li>
					 <li <?php if($page=='/import-transactions-days.php'){ ?>class='active'<?php } ?>><a href='/import-transactions-days'  <?php if($page=='import-transactions-days.php'){ ?>class='noborder'<?php } ?> ><span>Import & Export DayWise</span></a></li>
				
				
					
                </ul>
            </li>
			<?php }
		if($ltype ==3){ if($_SESSION['comp_id']==2) {$_SESSION['log_id']=3;}else {$_SESSION['log_id']=2;}}?>

			
            <li >
            <li class='has-sub <?php if($page=='report-salary.php' || $page=='report-bank.php'){ ?>active<?php } ?>'><a href='javascript:void(0);' ><span>Reports</span></a>
                <ul>
                    <li <?php if($page=='report-salary.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?> href='/report_salary'  <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?>><span>Salary</span></a></li>
                    <li <?php if($page=='report-bank.php'  ){ ?>class='active'<?php } ?>><a <?php if($page=='report-pf.php'){ ?>class='noborder'<?php } ?> href='/report_bank'><span>Bank</span></a></li>
                    <li <?php if($page=='report-pf.php'    ){ ?>class='active'<?php } ?>><a <?php if($page=='report-esi.php'){ ?>class='noborder'<?php } ?> href='/report_pf'><span>P.F</span></a></li>
                    <li <?php if($page=='report-esi.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-profession-tax.php'){ ?>class='noborder'<?php } ?> href='/report_esi'><span>E.S.I</span></a></li>
                    <li <?php if($page=='report-profession-tax.php'){ ?>class='active'<?php } ?>><a <?php if($page=='report-lws.php'){ ?>class='noborder'<?php } ?> href='/report_profession_tax'><span>Profession Tax</span></a></li>
                    <li <?php if($page=='report-lws.php'   ){ ?>class='active'<?php } ?>><a <?php if($page=='report-leave.php'){ ?>class='noborder'<?php } ?> href='/report_lws'><span>L.W.F.</span></a></li>
                    <li <?php if($page=='report-advances.php'){ ?>class='active'<?php } ?>> <a <?php if($page=='report-advances.php'){ ?>class='noborder'<?php } ?>  href='/report_advances' ><span>Advances</span></a></li>
                    <li <?php if($page=='report-mis.php'){ ?>class='active'<?php } ?>><a href='/report_mis' <?php if($page=='report-mis.php'){ ?>class='noborder'<?php } ?>><span>MISC. Reports</span></a></li>
					
					<li <?php if($page=='letters.php'){ ?>class='active'<?php } ?>><a href='/letters' <?php if($page=='letters.php'){ ?>class='noborder'<?php } ?> ><span>Letter</span></a></li>
					
					<li <?php if($page=='report-gst-bill.php'){ ?>class='active'<?php } ?>><a href='/report_gst_bill'  <?php if($page=='report-gst-bill.php'){ ?>class='noborder'<?php } ?>><span>GST BILL </span></a></li>
					
                </ul>
            </li>

			
		<?php if($ltype !=3){?>
			
			<li class="has-sub">  <a href="javascript:void()"><span>Leave</span></a>
			<ul>
				<!-- <li <?php //if($page=='opening-balance.php'){ ?>class='active'<?php// } ?>><a href="opening-balance.php"><span>Opening Balance</span></a></li> -->
				<li <?php if($page=='leave-encashment.php'){ ?>class='active'<?php } ?>><a href="/leave_encashment" class=<?php if($page=='leave-encashment.php'){ ?>class='noborder'<?php } ?>><span>Encashment</span></a></li>
				<li <?php if($page=='leave-reports.php'){ ?>class='active'<?php } ?>><a href="/leave_reports" class='noborder'><span>Bank Reports</span></a></li>
				<li <?php if($page=='leave-detail_reports.php'){ ?>class='active'<?php } ?>><a href="/leave_detail_reports" class='noborder'><span>Reports</span></a></li>
				
			</ul>
			</li>

			
			            <li class='has-sub'><a href='javascript:void(0);' ><span>Income  Tax</span></a>
                <ul>
                    <li <?php if($page=='add-financial-year.php'){ ?>class='active'<?php } ?>><a href='/add_financial_year'><span>financial year</span></a></li>
                    <li <?php if($page=='edit-intax-employee.php'){ ?>class='active'<?php } ?>><a <?php if($page=='income-calculation.php'){ ?>class='noborder'<?php } ?> href='/edit_intax_employee'  <?php if($page=='report-bank.php'){ ?>class='noborder'<?php } ?>><span>Enter /Edit Details</span></a></li>
                    <li  <?php if($page=='income-calculation.php'){ ?>class='active'<?php } ?>><a href='/income_calculation' <?php if($page=='add-comp-details.php'){ ?>class='noborder'<?php } ?>><span>Calculation</span></a></li>
                    <li <?php if($page=='add-comp-details.php'){ ?>class='active'<?php } ?>><a href='/add_comp_details' <?php if($page=='add-it-deposit-details.php'){ ?>class='noborder'<?php } ?> ><span>Company Details</span></a></li>
                    <li <?php if($page=='add-it-deposit-details.php'){ ?>class='active'<?php } ?>><a href='/add_it_deposit_details' <?php if($page=='report-form16.php'){ ?>class='noborder'<?php } ?> ><span>IT Deposit Details</span></a></li>
                    <li <?php if($page=='report-form16.php'){ ?>class='active'<?php } ?>><a href='/report_form16'  class="noborder"><span>Form 16 </span></a></li>

                </ul>
            </li>

			<li class='has-sub'><a href='javascript:void(0);' ><span>Bonus</span></a>
			<ul>
			<li <?php if($page=='select_current_bonus_year.php'){ ?>class='active'<?php } ?>><a href='/select_current_bonus_year'><span>Select Year</span></a></li>
				<li <?php if($page=='bonus.php'){ ?>class='active'<?php } ?>><a href='/bonus'><span>Bonus Calculation</span></a></li>
				
                <li <?php if($page=='statememt-bonus-calculation.php'){ ?>class='active'<?php } ?>><a href='/statememt_bonus_calculation'  ><span>Export Bonus</span></a></li>
				<li <?php if($page=='bonus-statement.php'){ ?>class='active'<?php } ?>><a href='/bonus_statement'  ><span>Statement</span></a></li>
				<li <?php if($page=='bonus-reports.php'){ ?>class='active'<?php } ?>><a href='/bonus_reports'  class="noborder"><span>Bank Reports</span></a></li>
			</ul>
			</li>			
            <li class='has-sub'><a href='javascript:void(0);' ><span>Activity</span></a>
                <ul>
                    <li <?php if($page=='tran_monthly_closing.php'){ ?>class='active'<?php } ?>><a href='/tran_monthly_closing'  class='noborder' ><span>Misc. Activities</span></a></li>
                </ul>
            </li>
		<?php }?>
        </ul>
    </div>
</div>
</div>
<!--Menu ends here-->