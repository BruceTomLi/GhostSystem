$(function(){	
	$("#cancelAddComment").on("click",function(){
		cancelAddComment();
	});
	
	$(".replyBtn").on("click",function(){
		if($(".replyCommnetDiv").length>0){
			alert("您还有其他打开的评论未评论且未取消，请评论或取消后再点击评论");			
		}
		else{
			var replyHtml="<div class='replyCommnetDiv'><textarea></textarea><br />";
			replyHtml+="<button class='btn btn-success'>回复</button>";
			replyHtml+="<button class='btn btn-warning cancelReplyComment' onclick='cancelReplyComment(this)'>取消</button></div>";
			$(this).after(replyHtml);
		}		
	});
	
	getAllQuestion();
	
	$("#submitCommentBtn").on("click",function(){
		commentQuestion();
	});
});

function addComment(){
	$(".addCommentDiv").show();
}

function cancelAddComment(){
	$(".addCommentDiv").hide();
}

function commentQuestion(){
	var questionId=$("#addCommentBtn").attr("value");
	var content=$(".addCommentDiv textarea").val();
	
}

function cancelReplyComment(element){
	$(element).parent().remove();
}

function getAllQuestion(){
	$.get(
		"../Controller/QuestionController.php",
		{action:"getAllQuestion"},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var questionList="";
			result.forEach(function(value,index){
				questionList+="<tr>";
				questionList+="<td><img src='../img/wangsai.jpg'></td>";
				questionList+="<td><p><button class='btn-link' value='"+value.questionId+"' onClick='getQuestionDetails(this)'>"+value.content+"</button></p>";
				questionList+="<p><span>"+value.questionType+"</span></p></td>";
				questionList+="<td><p>贡献</p><p><img src='../img/liuchenghua.jpg'></p></td>";
				questionList+="</tr>";
			});
			$(".questionTable tbody").html(questionList);
		}
	);
}

function getQuestionDetails(obj){
	var questionId=$(obj).attr("value");
	$.get(
		"../Controller/QuestionController.php",
		{action:"getQuestionDetails",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var questionList="";			
			result.forEach(function(value,index){
				questionList+="<h4>"+value.content+"</h4><hr>";
				questionList+="<p><span>描述：</span>"+value.questionDescription+"</p>";
				questionList+="<p><span>时间：</span><span>"+value.askDate+"</span></p>";
				questionList+="<p><button class='btn-link' id='addCommentBtn' onClick='addComment()'>添加评论</button></p>";
			});
			$("#questionDetails").html(questionList);
			$(".queryDiv").hide();
			$(".detailsDiv").show();
		}
	);	
}

