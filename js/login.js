$(function(){
	$('#loginBtn').on("click",function(){
		login();
	});
});

function login(){
	var password=$('#inputPassword').val();
	var emailOrUsername=$('#inputAccount').val();
	$.post(
		"Controller/LoginController.php",
		{action:"login",password:password,emailOrUsername:emailOrUsername},
		function(data){
			var loginInfo=$.trim(data);
			loginInfo=$.parseJSON(loginInfo);
			if(loginInfo.isSuccess=="success"){
				//alert(`欢迎你，${loginInfo.username}`);
				//location="forum/question.php";
				location=loginInfo.visitUrl;
			}
			else{
				alert("登录失败");
			}
		}
	);
}

//判断一个字符串是否为json
function isJsonString(str) {
    try {
        if (typeof JSON.parse(str) == "object") {
	        return true;
	    }
    }catch(e) {
    	
    }
    return false;
}