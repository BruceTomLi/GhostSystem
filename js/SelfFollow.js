$(function(){
	//页面载入时将菜单项改为active状态
	$("#menuUl>li>a[href='selfFollow.php']").parent().addClass("active");
	//页面加载时加载出用户关注的人的列表
	loadUserFollowedUsers();
	//页面加载时加载出用户关注的问题的列表
	loadUserFollowedQuestions();
	//页面加载时加载出用户关注的话题的列表
	
	//点击“返回问题列表时”返回
	$("#returnListBtn").on("click",function(){
		loadUserFollowedQuestions();
		$(".detailsDiv").hide();
		$(".questionDetailsDiv").hide();
		$(".queryDiv").show();
		$(".editDiv").hide();
		$(".createDiv").hide();		
	});
});

/**
 * 加载用户关注的问题
 */
function loadUserFollowedQuestions(){
	$.get(
		"../Controller/SelfFollowedController.php",
		{action:"loadUserFollowedQuestions"},		
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);			
			var questionList="";
			result.forEach(function(value,index){
				questionList+="<tr>";
				questionList+="<td>"+value.asker+"</td>";
				questionList+="<td>"+value.askDate+"</td>";
				questionList+="<td>"+value.questionType+"</td>";
				questionList+="<td>"+value.content+"</td>";
				questionList+="<td><button class='btn-link detailsBtn' onClick='getQuestionDetails(this)' value='"+value.questionId+"'>查看详情</button></td>";
				
				questionList+="</tr>";
			});
			$(".hasFollowedQuestion>.selfTable>tbody").html(questionList);
		}
	);
}

/**
 * 加载用户关注的人
 */
function loadUserFollowedUsers(){
	$.get(
		"../Controller/SelfFollowedController.php",
		{action:"loadUserFollowedUsers"},		
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);			
			var userList="";
			result.forEach(function(value,index){
				userList+="<tr>";
				userList+="<td>"+value.username+"</td>";
				var userSex=value.sex=='1'?'男':'女';
				userList+="<td>"+userSex+"</td>";
				userList+="<td>"+value.email+"</td>";
				userList+="<td><a target='_blank' href='../forum/person.php?userId="+value.userId+"'>查看详情</button></td>";	
				userList+="<td><button class='btn-link' onclick='cancelFollowUser(this)' value='"+value.userId+"'>取消关注</button></td>";
				userList+="</tr>";
			});
			$(".hasFollowedUser>.selfTable>tbody").html(userList);
		}
	);
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
				$(obj).parent().parent().remove();
				alert("取消关注了该用户");
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
