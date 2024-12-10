
<!--Header starts here-->


<header class="twelve header_bg">

    <div class="row body" >

        <div class="twelve padd0 columns" >

            <div class="seven padd0 columns mobicenter text-left " id="container1">

                <!-- Modify top header1 start here -->

              <!--  <div class="logo" ><img src="../images/JSM-logo.jpg" width="50px" height="50px" align="absmiddle">-->
                    <div class="logo" ><?php
                    $co_id=$_SESSION['comp_id'];
                    $rowcomp=$adminObj->displayCompany($co_id);
                    echo ' <span class="heade head1" style="font-size:20px;color: #fff;float:"right">&nbsp;'.$rowcomp['comp_name'].' </span>'; ?><br />
                    <span class="heade head2" style="margin-left:10px;margin-top:0px;position:absolute;font-size:20px;color: #fff;"> <?php echo $_SESSION['reporttitle']; ?></span><br />
					
					</div>
                    
					<div class="four padd0 columns mobicenter text-left " id="container1">
					    <span class="heade head2" style="margin-left:10px;margin-top:0px;position:absolute;font-size:20px;color: #fff;"><?php echo $_REQUEST['paymentdate']; ?></span>
					</div>
					

                <!-- Modify top header1 ends here -->

            </div>









            <div class="eleven padd0 columns text-right text-center" id="container3">

                <!-- Modify top header3  Navigation start here -->


                <div class="mobicenter text-right"  >
                    <span  class="heade" style="font-size:14px;color: #fff;float:'right';"><?php echo $_SESSION['client_name']; ?> &nbsp;&nbsp;&nbsp;&nbsp;<br/></span><span  class="heade" style="font-size:20px;color: #fff;"> <?php// echo date('d-m-Y');?>&nbsp;&nbsp;&nbsp;&nbsp;</span>

                </div>



                <!-- Modify top header3 Navigation start here -->

            </div>




        </div>
        </div>

</header>


<!--Header end here-->
<div style="clear: both;"></div>
	<style>
        header,.header_bg{
            background-color:#7D1A15;
            padding: 5px 0;
        }
	@media print
{
    .btnprnt{display:none}
        header,.header_bg{
            background-color:#7D1A15!important;



        }
}
	</style>