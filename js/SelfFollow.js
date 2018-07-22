$(function(){
	//页面加载时加载出用户关注的人的列表
	
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
