function validateData(){
	if($('#url').val()==''){
		alert('Vui lòng nhập url');
		$('#url').focus();
		return false;
	}else if($('#name').val()==''){
		alert('Vui lòng nhập name');
		$('#name').focus();
		return false;
	}else{
		$('#frmUpdate').submit();
	}
	return false;		
}
