<?php
$page=basename($_SERVER['PHP_SELF']);
?>
<!--Menu starts here-->

<div class="twelve nav" >

<div class="row" >

    <div  class="contenttext"  id='cssmenus'>

        <ul>

            <li   <?php if($page=='index.php'){ ?>class='active'<?php } ?>><a href='index.php'><span>Home</span></a></li>
            <li <?php if($page=='add-company.php' || $page=='edit-company.php'){ ?>class='active'<?php } ?>><a href='add-company.php'><span>Company</span></a></li>
            <li <?php if($page=='add-user.php' || $page=='edit-user.php'){ ?>class='active'<?php } ?>><a href='add-user.php'><span>User</span></a></li>
            <li <?php if($page=='import_salmast_imc.php' || $page=='import_salmast.php'){ ?>class='active'<?php } ?>><a href='import_salmast_imc.php'><span>Import Salmast</span></a></li>
            <li <?php if($page=='import_employee_imc.php' || $page=='import_employee.php'){ ?>class='active'<?php } ?>><a href='import_employee_imc.php'><span>Import Employee </span></a></li>
            <li <?php if($page=='display_pages.php' || $page=='display_pages.php'){ ?>class='active'<?php } ?>><a href='display_pages.php'><span>Display Pages </span></a></li>
			<li <?php if($page=='display_menues.php' || $page=='display_menues.php'){ ?>class='active'<?php } ?>><a href='display_menues.php'><span>Display Menues </span></a></li>
			
        </ul>

    </div>

</div>

</div>

<!--Menu ends here-->