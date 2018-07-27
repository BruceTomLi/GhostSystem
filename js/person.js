/**
 * 关注用户的函数
 */
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
					var cancelFollowUserHtml="<button class='btn btn-warning' id='cancelfollowTa' onclick='cancelFollowUser(this)' value='"+userId+"'>取消关注Ta</button>";
					$(obj).parent().html(cancelFollowUserHtml);
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


/**
 * 取消关注用户的函数
 */
function cancelFollowUser(obj){
	var userId=$(obj).attr("value");
	$.get(
		"../Controller/SelfFollowedController.php",
		{action:"cancelFollowUser",userId:userId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				alert("取消关注了该用户");
				var followUserHtml="<button class='btn btn-success' id='followTa' onclick='followUser(this)' value='"+userId+"'>关注Ta</button>";
				$(obj).parent().html(followUserHtml);
			}
			else if(result.affectRow==0){
				alert("你已经取消关注了该用户，不用重复操作");
			}
			else{
				alert(result.affectRow);
			}
		}
	);
}