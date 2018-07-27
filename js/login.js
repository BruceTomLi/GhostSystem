function login(){
	var password=$('#inputPassword').val();
	var emailOrUsername=$('#inputAccount').val();
	$.post(
		"Controller/LoginController.php",
		{password:password,emailOrUsername:emailOrUsername},
		function(data){
			var loginInfo=$.trim(data);
			loginInfo=$.parseJSON(loginInfo);
			if(loginInfo.username!=""){
				alert(`欢迎你，${loginInfo.username}`);
				location="forum/question.php";
			}
			else{
				alert("登录失败！");
			}
		}
	);
}

$(function(){
	$('#loginBtn').on("click",function(){
		login();
	});
});
