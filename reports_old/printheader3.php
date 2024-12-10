
<!--Header starts here-->
<div style="clear: both;"></div>
	<style>
        header,.header_bg{
            background-color:#fff !important;
			
            padding: 0;
			background: linear-gradient(#fff,#fff) !important;
        }
		.head11{font-size:12px;color: #000; font-family:arial;}
		.head12{margin-left:12px;margin-top:0px;font-size:14px;color: #000; font-family:arial;}
		.head13{font-size:12px;color: #000; font-family:arial;}
		.margin_right_10{margin-right:10px}
	
	@media print
{
    .btnprnt{display:none}
        header,.header_bg{
            background-color:#fff !important;
			background: linear-gradient(#fff,#fff) !important;
        }
		.head11,.head12,.head13{color:#000 !important}
}
	</style>

<header class="twelve header_bg">
    <div class="row body" >
        <div class="twelve padd0 columns" >
            <div class="twelve padd0 columns mobicenter  " id="container1">
                <!-- Modify top header1 start here -->
                <div class="heade head12 body" >
				<center>
                    <?php
                    $co_id=$_SESSION['comp_id'];
                    $rowcomp=$adminObj->displayCompany($co_id);?>
                    <?php echo $rowcomp['comp_name'];?> <br>
					<?php echo $_SESSION['client_name']; ?><br>
					<?php echo $_SESSION['reporttitle']; ?>
				</center>		
				<div align="right" class = " body" style = "margin-right:120px"> <?php echo date("d-m-Y");?> </div>
            </div>
			<div class="clearFix"></div>
			</div>
        
        </div></div>
</header>
<!--Header end here-->