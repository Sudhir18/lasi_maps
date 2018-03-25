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

	<div class="msg-box success-box alert alert-success alert-dismissable fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<span class="success-msg"></span>
	</div>

<div class="row text-right">
		<a href="index.php">>>Go TO Login</a>
</div>
<form id="AddUserForm" method="POST">
	<input type="hidden" name="operation" value="add_user" />	
  <div class="form-group">
    <label for="email">Username:</label>
    <input type="text" class="form-control" id="username" name="username">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>
 <div class="form-group">
    <label for="pwd">Confirm Password:</label>
    <input type="password" class="form-control" id="cnf_password" name="cnf_password">
  </div> 
  <button type="button" id="btnSubmit" class="btn btn-info">Add</button>
</form>
</div>
<script type="text/javascript">
	
	$(document).ready(function(){

		$("#AddUserForm").validate({
				rules:{
						username:"required",
						password:"required",
						cnf_password:{required:true,equalTo:'#password'}	
				},
				messages:{
					username:"required",
					password:"required",
					cnf_password:{
						required:"required",
						equalTo:"Not matching password"
					}
				},
				errorClass:"sms-error-cls"
		});

		$("#btnSubmit").click(function(){
				if($("#AddUserForm").valid()){
					var postdata = $("#AddUserForm").serialize();
					$.ajax({
						url:'controller/UserController.php',
						data:postdata,
						method:'POST',
						success:function(data){
							var response = $.parseJSON(data);
							if(response.status == "success"){
								showSuccessBox(response.message);
								document.getElementById('AddUserForm').reset();
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