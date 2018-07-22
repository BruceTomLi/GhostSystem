function followUser(obj){
	var userId=$(obj).attr("value");
	if(userId!=""){
		$.get(
			"../Controller/QuestionController.php",
			{action:"addFollow",starId:userId,followType:"user"},
			function(data){
				var result=$.trim(data);
				result=$.parseJSON(result);
				if(result.affectRow==1){
					alert("成功关注了该用户");
				}
				else if(result.affectRow==0){
					alert("你已经关注了该用户，不需要重新关注");
				}
				else{
					alert(result.affectRow);
				}
			}
		);
	}
	else{
		alert("未获取到用户信息，无法进行关注");
	}
}
