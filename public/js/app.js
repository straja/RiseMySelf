$(document).ready(function(){

	$(document).on('click', '.deleteUser', function(e){
		e.preventDefault();
		var yes = confirm('Are you sure that you want to delete this user?');
		if(yes) {
		  $(this).parent().submit();
		}
	});
	
	//Edit Category
	var tmpCategoryTitle = "";
	$('.save').hide();
	$('.close').hide();
	$(document).on('click', '.edit', function(e){
		e.preventDefault();
		
		tmpCategoryTitle = $(this).parent().find('.name').text();
		
		$(this).parent().find('.edit').hide();
		$(this).parent().find('.trash').hide();
		$(this).parent().find('.save').show();
		$(this).parent().find('.close').show();
		
		$(this).parent().find('.name').attr('contenteditable', true);
	});
	$(document).on('click', '.close', function(e){
		e.preventDefault();
		
		$(this).parent().find('.name').text(tmpCategoryTitle);
		
		$(this).parent().find('.edit').show();
		$(this).parent().find('.trash').show();
		$(this).parent().find('.save').hide();
		$(this).parent().find('.close').hide();
		
		$(this).parent().find('.name').attr('contenteditable', false);
	});
	$(document).on('click', '.save', function(e){
		e.preventDefault();
		
		$(this).parent().find('.edit').show();
		$(this).parent().find('.trash').show();
		$(this).parent().find('.save').hide();
		$(this).parent().find('.close').hide();
		
		
		var  title = $(this).parent().find('.name').text();
		$(this).parent().parent().find('input[name="title"]').val(title);
		$(this).parent().find('.name').attr('contenteditable', false);
	
		$(this).parent().parent().submit();
	});
	
	// Statistics
	if($('#statistictype').val() != 'posibilities' &&  $('#statistictype').val() != '') {
		$('#categorytype').show()
	} else {
		$('#categorytype').hide()
	}
	$(document).on('change', '#statistictype', function(e){
		e.preventDefault();
		if($(this).val() != 'posibilities' &&  $(this).val() != '') {
			$('#categorytype').show()
		} else {
			$('#categorytype').hide()
		}
	});

});