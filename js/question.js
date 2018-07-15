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
	$.post(
		"../Controller/QuestionController.php",
		{action:"commentQuestion",questionId:questionId,content:content},
		function(data){
			var result=$.trim(data);
			if(result.affectRow==1){
				alert("评论成功");
			}
			else{
				alert("评论失败");
			}
		}
	);
	
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
			result.questionDetails.forEach(function(value,index){
				questionList+="<h4>"+value.content+"</h4><hr>";
				questionList+="<p><span>描述：</span>"+value.questionDescription+"</p>";
				questionList+="<p><span>时间：</span><span>"+value.askDate+"</span></p>";
				questionList+="<p><button class='btn-link' id='addCommentBtn' onClick='addComment()' value='"+value.questionId+"'>添加评论</button></p>";
			});
			$("#questionDetails").html(questionList);
			
			var questionAnswers="<h4>"+result.commentCount+"个回复</h4>";
			questionAnswers+="<hr><ul>";
			result.questionComments.forEach(function(value,index){
				questionAnswers+="<li><ul><li>";
				questionAnswers+="<span>"+value.commenter+"：</span>";
				questionAnswers+="<span>"+value.content+"</span>";
				if(value.isCommenter=="true"){//如果登录者是评论者，就加上删除按钮					
					questionAnswers+="<button class='btn-link deleteBtn' onClick='deleteCommentForQuestion(this)' value='"+value.commentId+"'>删除</button>";
				}				
				questionAnswers+="<button class='btn-link replyBtn' onClick='showReplyDiv(this)' value='"+value.commentId+"'>回复</button>";
				questionAnswers+="<button class='btn-link detailsBtn' onClick='getReplysForComment(this)' value='"+value.commentId+"'>详情</button>";
				questionAnswers+="</li><div class='replysForComment'></div></ul></li>";
			});
			questionAnswers+="</ul>";
			$("#questionAnswers").html(questionAnswers);
			
			$(".queryDiv").hide();
			$(".detailsDiv").show();
		}
	);	
}

function deleteCommentForQuestion(obj){
	var commentId=$(obj).attr("value");
	$.post(
		"../Controller/QuestionController.php",
		{action:"deleteCommentForQuestion",commentId:commentId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				alert("删除评论成功!");
				//删除成功后直接使用jquery移除网页上的评论，有利于整体优化网站响应速度（比重新加载评论要快）
				$(obj).parent().parent().parent().remove();
			}
			else{
				alert("删除评论失败!");
			}
		}
	);
}

function getReplysForComment(obj){
	//第一次没有加载的时候就加载，之后就直接显示或者隐藏div就可以了，是通过该div有没有子元素来进行判断的
	if(!($(obj).parent().siblings().last().children().length>0)){
		var commentId=$(obj).attr("value");
		var commenter=$(obj).siblings(":first").text();
		$.get(
			"../Controller/QuestionController.php",
			{action:"getReplysForComment",commentId:commentId},
			function(data){
				var result=$.trim(data);
				result=$.parseJSON(result);
				var replyList="";
				result.forEach(function(value,index){
					replyList+="<li>";
					replyList+="<span>"+value.replyer+"&nbsp;回复&nbsp;"+commenter+"</span>";
					replyList+="<span>"+value.content+"</span>";
					replyList+="<button class='btn-link replyBtn'>回复</button>";
					replyList+="</li>";
				});
				$(obj).parent().siblings().last().html(replyList);
			}
		);
	}
	else{
		$(obj).parent().siblings().last().toggle();
	}
	
}

function showReplyDiv(obj){
	if($(".replyCommnetDiv").length>0){
		alert("您还有其他打开的评论未评论且未取消，请评论或取消后再点击评论");			
	}
	else{
		var replyHtml="<div class='replyCommnetDiv'><textarea></textarea><br />";
		replyHtml+="<button class='btn btn-success' onClick='replyComment(this)'>回复</button>";
		replyHtml+="<button class='btn btn-warning cancelReplyComment' onclick='cancelReplyComment(this)'>取消</button></div>";
		$(obj).parent().after(replyHtml);
	}
}

function replyComment(obj){
	//通过元素之间关系获取到相应的评论号
	var commentId=$(obj).parent().prev().children(".replyBtn").attr("value");
	var content=$(obj).siblings("textarea").text();
	$.post(
		"../Controller/QuestionController.php",
		{action:"replyComment",commentId:commentId,content:content},
		function(data){
			var result=$.trim(data);
		}
	);
}
