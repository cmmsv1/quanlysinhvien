$(document).ready(function(){
	var classesData = $('#classList').DataTable({
		"lengthChange": false,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listClassesRegister'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets": 'nosort',
				"orderable":false,
			},
		],
		"pageLength": 10
	});	

	
	$(document).on('click', '.register', function(){
		var userid = $("#userid").val();
		var action = 'insertStudentRegister';
        var classid = $(this).attr("id");
		$.ajax({
			url:'action.php',
			method:"POST",
			data:{userid:userid, action:action, classid:classid},
			dataType:"json",
			success:function(data){
				alert(data);
                classesData.ajax.reload();
			},
            // error: function(XMLHttpRequest, textStatus, errorThrown) {
            //     console.log(data);
            //  }
		})
	});	
	
	
	
	
});