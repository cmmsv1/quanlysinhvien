$(document).ready(function(){
	var classesData = $('#classList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listClasses'},
			dataType:"json"
		},
	});	

	$('#addClass').click(function(){
		$('#classModal').modal('show');
		$('#classForm')[0].reset();		
		$('.modal-title').html("<i class='fa fa-plus'></i> Thêm lớp");
		$('#action').val('addClass');
		$('#save').val('Add Class');
	});	
	
	$(document).on('submit','#classForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#classForm')[0].reset();
				$('#classModal').modal('hide');				
				$('#save').attr('disabled', false);
				classesData.ajax.reload();
			}
		})
	});	
	
	$(document).on('click', '.update', function(){
		var classid = $(this).attr("id");
		var action = 'getClass';
		$.ajax({
			url:'action.php',
			method:"POST",
			data:{classid:classid, action:action},
			dataType:"json",
			success:function(data){
				$('#classModal').modal('show');
				$('#classid').val(data.id);
				$('#cname').val(data.class);
				$('#subjectid').val(data.subject_id);				
				$('.modal-title').html("<i class='fa fa-plus'></i> Sửa lớp");
				$('#action').val('updateClass');
				$('#save').val('Save');
			}
		})
	});	
	
	$(document).on('click', '.delete', function(){
		var classid = $(this).attr("id");		
		var action = "deleteClass";
		if(confirm("Bạn chắc chắn muốn xoá lớp này ?")) {
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{classid:classid, action:action},
				success:function(data) {					
					classesData.ajax.reload();
				}
			});
		} else {
			return false;
		}
	});	
	
	
	
});