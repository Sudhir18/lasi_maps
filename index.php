<?php
		include_once(dirname(__FILE__).'/config/config.php');
		include_once(dirname(__FILE__).'/view/header.php');
		include_once(dirname(__FILE__).'/view/plainnavbar.php');
?>

<style>
	.msg-box{
		display: none;
	}

</style>	
<div class="container">

	<div class="msg-box error-box alert alert-danger alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<span class="error-msg"></span>
	</div>


<form id="LoginUserForm" method="POST">
	<input type="hidden" name="operation" value="login" />	
  <div class="form-group">
    <label for="email">Username:</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div> 
  <button type="button" id="btnSubmit" class="btn btn-info">Login</button>
</form>
</div>
<script type="text/javascript">
	
	$(document).ready(function(){

		$("#LoginUserForm").validate({
				rules:{
						username:"required",
						password:"required"
				},
				messages:{

					username:"required",
					password:"required"
				},
				errorClass:"sms-error-cls"

		});


		$("#btnSubmit").click(function(){

				if($("#LoginUserForm").valid()){


					var postdata = $("#LoginUserForm").serialize();

					$.ajax({
						url:'controller/UserController.php',
						data:postdata,
						method:'POST',
						success:function(data){
							var response = $.parseJSON(data);
							if(response.status == "success"){
							//	showSuccessBox(response.message);
								//console.log(response.message);
								window.location.href='userdashboard.php';
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


	});


</script>

<?php 
	
	include_once(dirname(__FILE__).'/view/footer.php');
?>