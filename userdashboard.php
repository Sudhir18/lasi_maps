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
	<link rel="stylesheet" href="css/style.css">
<div class="container">
	<h3>List of SSUs</h3>
	<table id="listMap" class="display" style="border:1px solid black">
			<thead>
			<tr>
			<th>SSU</th>
			<th>District</th>
			<th>State</th>
			<th>Action</th>
			</tr>
		</thead>
	</table>

	<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- The Close Button -->
  <span class="close">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="modal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>

</div>
<script type="text/javascript">
var imageURL = 'http://localhost/lasi_maps/map_images';
$(document).ready(function(){
    $('#listMap').DataTable({
    	"ajax":"controller/getAllMaps.php",
    	"columnDefs": [ {"targets": 3,"data":"id", "render": function(data,type,row,meta){
					 			return "<a href='edit_ssu.php?mapid="+row.id+"''>Edit</a> | <a href='javascript:void(0);' onclick='showMap("+row.id+",\""+row.filename+"\")'>View</a>";
					 	} 
  } ],
    	columns:[
    				{"data":"ssu","width":"30%"},
					{"data":"district","width":"30%"},
					{"data":"state","width":"30%"},
					{"data":"id","width":"10%"}
					 
				]

    });
});

function showMap(fileid,filename){
/*	console.log(filename);
	console.log(fileid);*/
	if(filename && fileid){
		var modal = document.getElementById('myModal');
	// Get the image and insert it inside the modal - use its "alt" text as a caption
		var modalImg = document.getElementById("img01");
		var captionText = document.getElementById("caption");
	    modal.style.display = "block";
	    modalImg.src = imageURL+"/"+fileid+"/"+filename;
	    captionText.innerHTML = filename;
	// Get the <span> element that closes the modal
		var span = document.getElementsByClassName("close")[0];

	// When the user clicks on <span> (x), close the modal
		span.onclick = function() { 
	  		modal.style.display = "none";
		}		
	}

}
</script>
<?php

	include_once(dirname(__FILE__).'/view/footer.php');
?>
