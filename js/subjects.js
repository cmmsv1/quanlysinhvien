$(document).ready(function(){
	var subjectData = $('#subjectList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listSubject'},
			dataType:"json"
		},
	});	

	$('#addSubject').click(function(){
		$('#subjectModal').modal('show');
		$('#subjectForm')[0].reset();		
		$('.modal-title').html("<i class='fa fa-plus'></i> Thêm học phần");
		$('#action').val('addSubject');
		$('#save').val('Save');
	});	
	
	$(document).on('submit','#subjectForm', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"action.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#subjectForm')[0].reset();
				$('#subjectModal').modal('hide');				
				$('#save').attr('disabled', false);
				subjectData.ajax.reload();
			}
		})
	});	
	
	$(document).on('click', '.update', function(){
		var subjectid = $(this).attr("id");
		var action = 'getSubject';
		$.ajax({
			url:'action.php',
			method:"POST",
			data:{subjectid:subjectid, action:action},
			dataType:"json",
			success:function(data){
				$('#subjectModal').modal('show');
				$('#subjectid').val(data.id);
				$('#subject').val(data.subject);	
				if(data.type == 'Lý thuyết') {
					$('#theory').prop("checked", true);
				} else if(data.type == 'Thực tế') {
					$('#practical').prop("checked", true);
				}
				$('#code').val(data.code);	
				$('.modal-title').html("<i class='fa fa-plus'></i> Sửa học phần");
				$('#action').val('updateSubject');
				$('#save').val('Save');
			}
		})
	});	
	
	$(document).on('click', '.delete', function(){
		var subjectid = $(this).attr("id");		
		var action = "deleteSubject";
		if(confirm("Bạn chắc chắn muốn xoá học phần này ?")) {
			$.ajax({
				url:"action.php",
				method:"POST",
				data:{subjectid:subjectid, action:action},
				success:function(data) {					
					subjectData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
	
	
});