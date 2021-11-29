$(document).ready(function () {
    loadData();
});
function loadData(){
    var userid = $('#userid').val();
    var action = 'getInforUser';
    $.ajax({
        url:'action.php',
        method:"POST",
        data:{userid:userid, action:action},
        dataType:"json",
        success:function(data){
            $('#email').val(data.email);
            $('#name').val(data.name);
            $('#mobile').val(data.mobile);				
            
        }
    })
}
$(document).on('click', '#updateData', function(){
    var userid = $('#userid').val();
    var action = 'updateInforUser';
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    var email = $('#email').val();
    $.ajax({
        url:'action.php',
        method:"POST",
        data:{
            userid:userid, 
            action:action,
            name:name,
            mobile:mobile,
            email:email,
        },
        dataType:"json",
        success: function(data){
            alert(data);
            loadData();
        }
    });
    
});	
