<?php
	
	session_start();
	if(!isset($_SESSION)){
		header('location:index.php');
			exit();
	}

	include_once(dirname(__FILE__).'/model/MapModel.php');
	include_once(dirname(__FILE__).'/config/config.php');
	include_once(dirname(__FILE__).'/view/header.php');
	include_once(dirname(__FILE__).'/view/usernavbar.php');
		// all states and ssu_info
    $id = trim($_GET['mapid']);
    $ssu_map = MapModel::getMapById($id);
    $ssu = MapModel::getSSUById($ssu_map['ssuid']);
	$states = MapModel::getStates();
    $districts = MapModel::getDistricts($ssu['stateid'],$ssu['urbanrural']);
    $ssu_in_district = MapModel::getSSUByDistrict($ssu['regionid']);
?>
<style>
	.msg-box{
		display: none;
	}
</style>
<div class="container">
	<h3>Edit SSU</h3>
		<div class="msg-box error-box alert alert-danger alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<span class="error-msg"></span>
		</div>
		<div class="msg-box success-box alert alert-success alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<span class="success-msg"></span>
		</div>

		<div class="row text-right">
			<a href="userdashboard.php">>>Back</a>
		</div>

	<form id="EditSSU" method="POST">
		<input type="hidden" name="operation" value="edit_ssu" />
    	<input type="hidden" name="map_id" value="<?php echo $id ?>" />
  			<div class="form-group">
    			<label for="state">State:</label>
    			<select id="state" class="form-control" name="state">
    				<option value="">--Select State--</option>
    				<?php foreach ($states as $state) {?>
    				<option value="<?php echo $state['stateid']?>" <?php echo $state['stateid'] == $ssu['stateid'] ? 'selected': ''?>>
              <?php echo $state['state']?>
            </option>
    				<?php } ?>
    			</select>
  			</div>
			<div class="form-group">
    			<label for="region">Region:</label>
    			<select id="region" class="form-control" name="region">
    				<option value="">--Select Region--</option>
    				<option value="1" <?php echo $ssu['urbanrural'] == 1 ? 'selected':'' ?>>Urban</option>
    				<option value="2" <?php echo $ssu['urbanrural'] == 2 ? 'selected':'' ?>>Rural</option>
    			</select>
  			</div>

 			<div class="form-group">
    			<label for="district">District:</label>
          <select id="district" class="form-control" name="district">
          <?php foreach($districts as $district){?>
    			       <option value="<?php echo $district['regionid'] ?>" <?php echo $district['regionid'] == $ssu['regionid'] ? 'selected':''?>>
                   <?php echo $district['region']?>
                 </option>
          <?php } ?>
    			</select>
  			</div>

  			<div class="form-group">
    			<label for="ssu">SSU:</label>
    			<select id="ssu" class="form-control" name="ssu">
              <?php foreach($ssu_in_district as $sd) {?>
                <option value="<?php echo $sd['puid']?>" <?php echo $sd['puid'] == $ssu['puid'] ? 'selected' : ''?>>
                    <?php echo $sd['name'] ?>
                </option>
              <?php }?>
    			</select>
  			</div>

  			<div class="form-group">
    			<label for="ssu_file">SSU Map(scanned copy):</label>
    			<input type="file" id="ssu_file" class="form-control" name="ssu_file" />
  			</div>
  <button type="button" id="btnSubmit" class="btn btn-info">Upload</button>
</form>

</div>
<script type="text/javascript">

$(document).ready(function(){

var ssu_info = null;

$("#EditSSU").validate({
				rules:{
						state:"required",
						region:"required",
						district:"required",
						ssu:"required",
						ssu_file:"required"
				},
				messages:{
						state:"required",
						region:"required",
						district:"required",
						ssu:"required",
						ssu_file:"required"
				},
				errorClass:"sms-error-cls"
		});

		$("#btnSubmit").click(function(){
				if($("#EditSSU").valid()){
//					var postdata = $("#EditSSU").serialize();
					$.ajax({
						url:'controller/MapController.php',
						data:new FormData($("#EditSSU")[0]),
						method:'POST',
						cache : false,
						//dataType    : 'json',
						contentType: false,
						processData : false,
						success:function(data){
							var response = $.parseJSON(data);
							if(response.status == "success"){
								showSuccessBox(response.message);
								document.getElementById('AddSSU').reset();
							}else{
								showErrorBox(response.message);
							}
						},
						error:function(data){
								showErrorBox("Unable to connect!");
						}
					});
				}
		});

	$("#state").on('change',function(){
		$("#district").html('');
		$("#ssu").html('');
		var urbanrural = $("#region option:selected").val();
		if(urbanrural){
			getDistricts();
		}
	});

	$("#region").on('change',function(){
		getDistricts();
	});

	$("#district").on('change',function(){
		getSSU();
	});

    function getDistricts(){
    	var stateid = $("#state option:selected").val();
    	var urbanrural = $("#region option:selected").val();

		$.ajax({
			url:'controller/MapController.php',
			data:{operation:'get_districts',stateid:stateid,urbanrural:urbanrural},
			method:'POST',
			success:function(data){
					data = $.parseJSON(data);
					let dataHTML = "";
					if(data.status =="success"){
						districts = data.districts;
						for(let i=0;i<districts.length;i++){
							dataHTML += "<option value='"+districts[i].regionid+"'>"+districts[i].region+"</option>";
						}
						if(dataHTML !=""){
							dataHTML = "<option value=''>--Select District--</option>"+dataHTML;
						}
				    	$("#district").html(dataHTML);
					}else{
						alert(data.message);
					}

			},
			error:function(data){
					console.log(data);
			}
		});

    }

    function getSSU(){
    	var stateid = $("#state option:selected").val();
    	var urbanrural = $("#region option:selected").val();
    	var regionid = $("#district option:selected").val();
		$.ajax({
			url:'controller/MapController.php',
			data:{operation:'get_ssu',stateid:stateid,urbanrural:urbanrural,regionid:regionid},
			method:'POST',
			success:function(data){
					data = $.parseJSON(data);
					let dataHTML = "";
					if(data.status =="success"){
						ssu = data.ssu;
						for(let i=0;i<ssu.length;i++){
							dataHTML += "<option value='"+ssu[i].puid+"'>"+ssu[i].name+"</option>";
						}
						if(dataHTML !=""){
							dataHTML = "<option value=''>--Select SSU--</option>"+dataHTML;
						}
				    	$("#ssu").html(dataHTML);
					}else{
						alert(data.message);
					}

			},
			error:function(data){
					console.log(data);
			}
		});
    }
});

</script>
<?php

	include_once(dirname(__FILE__).'/view/footer.php');
?>
