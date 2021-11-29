$(document).ready(function(){
    var userid = $("#userid").val();
	var classesData = $('#classList').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,
		"bFilter": false,
		"order":[],
		"ajax":{
			url:"action.php",
			type:"POST",
			data:{action:'listClassesStudent', userid:userid},
			dataType:"json"
		},
	});	
	
});