$( document ).ready(function() {
   //alert('test');
   //$('.alert').hide();
	
	setInterval(function(){
		$('.alert').delay(1000).fadeOut("slow");
		},1000);
	
	$('.val_select li a').click(function(){
		  $('.item_val .val_selected').text($(this).text());
		  $('#orderBy').val($(this).attr("value"));
		  
	});
	
	
	
	$('#plus').click(function(){
		add_item_table();
	});
	
	$('#txt_name_table').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	    	add_item_table();
	    }
	});
	
	function add_item_table(){
		var data_header_table= $('#txt_name_table').val();
		var data_field=$('#txt_data_field').val();
		var p_from="<p>";
		
		var p_end=" <a href='#' class='icon-trash'></a> </p>";
		var txt= p_from+'<span class="txtheader">'+data_field+'</span>'+';'+data_header_table+p_end;
		
		//set_val_textbox(data_header_table);	
		//var val_textboxId=$("#txt_header").val();
		
		//var val_it=$('#txt_header').val();
		//$('#txt_header').val(val_it+data_header_table+';');
		load_data();
		
		$("#value_tbl").append(txt);
		$(".frm_table_data input").val('');
	}
	
	
	function load_data(){
		//$(".txtheader").each(function( index ) {
		
			$(document).on("each", ".txtheader", function(e) {
			
			var val_it=$('#txt_header').val();
			var data= $(this).val();
			$('#txt_header').val(val_it+data+';');
			//alert('test');
		});
	}
	
	function set_val_textbox(txtboxVal){
		//alert('test');
		//alert(textboxId);
		alert(txtboxVal);
		//textboxId= textboxId."'";
		//$( "li" ).each(function( index ) {
			  //console.log( index + ": " + $( this ).text() );
			var val_textboxId=$("#txt_header").val();
			$('#txt_header').val(txtboxVal);
		//});
	}
	
		$(document).on("click", "#value_tbl a", function(e) {
		$(this).parent().remove();
		load_data();
		
	});
	
	$('#main-nav .navigation .nav-stacked li').each(function() {
	    var href = $(this).find('a').attr('href');
	    var url= document.URL;
	    if (href == url || (href+'/') == url || (href+'#') == url) {
	      $(this).addClass('active');
	      $(this).parent().parent().find('a:first,ul:first').addClass("in");
	    }
	  });
	
	
});