$(document).ready(function(){
	getSession(1);
	$('#search').click(function(){
		getSession(1);
    });
    $('#reset').click(function(){
    	$('#keyword').val('');
    	getSession(1);
    });
	$('#keyword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
        	getSession(1); return false;
        }
 });
}); 

function deleteSession(sessionId){
	if(confirm('Bạn có chắc chắn muốn xóa dữ liệu này không? Dữ liệu sẽ bị xóa và không thể phục hồi!')){
		$('#loading').show();
		$('#'+sessionId).hide("slow");
		$.ajax({
            url: $("#sessionUrl").val(),
            cache: false,
            type: "POST",
            data: "do=delete&id="+sessionId,           
            success: function(serverData){
            	$('#loading').hide();
            }
        });
	}
}

function getSession(page){
	var ajaxData = $('#frmList').serialize()+"&do=list&page="+page;
	$('#loading').show();
	$.ajax({
        url: $("#sessionUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	$('#loading').hide();
        	$('#sessionArea').html(serverData);
        }
      });
}
function buildNavigator(page,currentForm){
	getSession(page);
}
