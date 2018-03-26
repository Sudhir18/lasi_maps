<?php
		session_start();
		if(!isset($_SESSION)){
			header('location:logout.php');
			exit();
		}
		include_once(dirname(__FILE__).'/config/config.php');
		include_once(dirname(__FILE__).'/view/header.php');
		include_once(dirname(__FILE__).'/view/usernavbar.php');
?>
	<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="css/responsive.dataTables.min.css">
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.responsive.min.js"></script>
<div class="container">
	<h3>List of SSUs</h3>
	<table id="listMap" class="display" style="border:1px solid black">
			<thead>
			<tr>
			<th>SSU</th>
			<th>District</th>
			<th>State</th>
			<th></th>
			</tr>
		</thead>
	</table>
</div>
<script type="text/javascript">

$(document).ready(function(){
    $('#listMap').DataTable({
    	"ajax":"controller/getAllMaps.php",
    	columns:[
    				{"data":"ssu","width":"30%"},
					{"data":"district","width":"30%"},
					{"data":"state","width":"30%"},
					{"data":"id","width":"10%",
					 "render": function(data,type,row,meta){
					 			return '';
					 	}
					}
				]

    });
});

</script>
<?php

	include_once(dirname(__FILE__).'/view/footer.php');
?>
