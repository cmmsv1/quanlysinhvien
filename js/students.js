$(document).ready(function(){
	var studentData = $('#studentList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listStudent'},
			dataType:"json"
		},
		 
	});	
	
	$(document).on('click', '.delete', function(){
		var studentid = $(this).attr("id");		
		var action = "deleteStudent";
		if(confirm("Bạn chắc chắn muốn xoá sinh viên này ?")) {
			$.ajax({
				url:"admin/action.php",
				method:"POST",
				data:{studentid:studentid, action:action},
				success:function(data) {					
					studentData.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});	
	
	
	
});