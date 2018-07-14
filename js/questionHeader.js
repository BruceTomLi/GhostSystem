function logout(){
	$.get(
		"../Controller/LogoutController.php",
		function(data){
			var isLogout=$.trim(data);
			if(isLogout){
				window.location.reload();
			}
			else{
				alert("注销失败");
			}
		}
	);
}
