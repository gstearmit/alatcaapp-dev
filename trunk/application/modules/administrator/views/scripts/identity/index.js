$(document).ready(function(){
	getUrl(1);
	$('#search').click(function(){
		getUrl(1);
    });
    $('#reset').click(function(){
    	$('#keyword').val('');
    	getUrl(1);
    });
	$('#keyword').keypress(function(event){
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
        	getUrl(1); return false;
        }
 });
}); 

function deleteIdentity(UrlId){
	if(confirm('Bạn có chắc chắn muốn xóa dữ liệu này không? Dữ liệu sẽ bị xóa và không thể phục hồi !'))
	{
		//alert(UrlId);
		$('#loading').show();
		$('#'+UrlId).hide("slow");
		$.ajax({
            url: $("#UrlUrl").val(),
            cache: false,
            type: "POST",
            data: "do=delete&id="+UrlId,           
            success: function(serverData){
            	$('#loading').hide();
            	var mes = "<div class='alert alert-success alert-dismissable'>" +
            			"<a href='#' data-dismiss='alert' class='close'>×" +
                        "</a><i class='icon-ok-sign'></i>"+
                         "  <strong> Xoá </strong> Thành công"+
                        "</div>";
            	$('.box_message').html(mes);
            }
        });
	}
}

function getUrl(page){
	var ajaxData = $('#frmList').serialize()+"&do=list&page="+page;
	$('#loading').show();
	$.ajax({
        url: $("#UrlUrl").val(),
        cache: false,
        type: "POST",
        data: ajaxData,           
        success: function(serverData){
        	$('#loading').hide();
        	$('#UrlArea').html(serverData);
        }
      });
}
function buildNavigator(page,currentForm){
	getUrl(page);
}
