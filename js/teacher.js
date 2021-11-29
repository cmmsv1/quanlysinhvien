$(document).ready(function(){
	var teacherData = $('#teacherList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listTeacher'},
			dataType:"json"
		},
	});	

	$('#addTeacher').click(function(){
		$('#teacherModal').modal('show');
		$('#teacherForm')[0].reset();		
		$('.modal-title').html("<i class='fa fa-plus'></i> Thêm giảng viên");
		$('#action').val('addTeacher');
		$('#save').val('Save');
	});	
	
	$(document).on('submit','#teacherForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#teacherForm')[0].reset();
				$('#teacherModal').modal('hide');				
				$('#save').attr('disabled', false);
				teacherData.ajax.reload();
			}
		})
	});	
	
	$(document).on('click', '.update', function(){
		var teacherid = $(this).attr("id");
		var action = 'getTeacher';
		$.ajax({
			url:'action.php',
			method:"POST",
			data:{teacherid:teacherid, action:action},
			dataType:"json",
			success:function(data){
				$('#teacherModal').modal('show');
				$('#teacherid').val(data.id);
				$('#teacher_name').val(data.teacher);
				$('#classid').val(data.class_id);
				$('.modal-title').html("<i class='fa fa-plus'></i> Sửa tên giảng viên");
				$('#action').val('updateTeacher');
				$('#save').val('Save');
			}
		})
	});	
	
	$(document).on('click', '.delete', function(){
		var teacherid = $(this).attr("id");		
		var action = "deleteTeacher";
		if(confirm("Bạn chắc chắn muốn xoá giảng viên này ?")) {
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{teacherid:teacherid, action:action},
				success:function(data) {					
					teacherData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
	
	
});