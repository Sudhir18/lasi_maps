function showErrorBox(msg){
	$('.msg-box').hide();
	$('.error-msg').html(msg);
	$('.error-box').show();
}

function showSuccessBox(msg){
	$('.msg-box').hide();
	$('.success-msg').html(msg);
	$('.success-box').show();
}