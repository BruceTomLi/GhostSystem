/**
 * 用jquery在页面加载时给元素注册的事件，对于后来在页面中添加的元素该事件无效
 * 所以以后在编写页面动态生成的元素事件时，好的做法是直接在元素中添加onClick方法，可以将this
 * 作为参数传递
 */
$(function(){
	//页面加载时加载所有问题的列表
	getAllQuestion();
});

/**
 * 获取所有问题的函数
 * 不需要传入参数
 */
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
/**
 * 获取问题详情的函数
 * 需要通过元素的value传入questionId值，以便问题详情页可以显示问题的详细信息
 */
function getQuestionDetails(obj){
	//通过问题列表页进入问题详情页的时候，使用记录在按钮中的value来记录questionId比用hidden类型的input记录更好一点
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
				questionList+="<p><button class='btn-link' id='addCommentBtn' value='"+value.questionId+"' onClick='showCommentDiv(this)'>添加评论</button></p>";
			});
			$("#questionDetails").html(questionList);
			
			var questionAnswers="<h4><span id='commentCount'>"+result.commentCount+"</span>个回复</h4>";
			questionAnswers+="<hr><ul>";
			result.questionComments.forEach(function(value,index){
				questionAnswers+="<li><ul><li>";
				questionAnswers+="<span>"+value.commenter+"：</span>";
				questionAnswers+="<span>"+value.content+"</span>";
				if(value.isCommenter=="true"){//如果登录者是评论者，就加上删除按钮					
					questionAnswers+="<button class='btn-link disableBtn' value='"+value.commentId+"' onClick='disableCommentForQuestion(this)'>删除</button>";
				}
				if(value.replyCount>0){
					questionAnswers+="<button class='btn-link detailsBtn' value='"+value.commentId+"' onClick='getReplysForComment(this)'>";
					questionAnswers+="<span class='replyCountBtn'>"+value.replyCount+"</span>条回复</button>";
				}				
				questionAnswers+="<button class='btn-link replyBtn' value='"+value.commentId+"' onClick='showReplyCommentDiv(this)'>回复</button>";
				questionAnswers+="<div class='replysForComment'></div></li></ul></li>";
			});
			questionAnswers+="</ul>";
			$("#questionAnswers").html(questionAnswers);
			
			$(".queryDiv").hide();
			$(".detailsDiv").show();
		}
	);	
}


//显示评论问题的div
function showCommentDiv(obj){
	$("#addCommentDiv #submitCommentBtn").attr("value",$(obj).attr("value"));
	if(chkUserLogonByWelcome()=="true"){
		$("#addCommentDiv").show();
	}
	else{
		alert("请先登录系统");
	}
	
}
//隐藏评论问题的div
function cancelAddComment(obj){
	$(obj).siblings("textarea").val("");
	$("#addCommentDiv").hide();
}
/**
 * 评论问题的函数
 * 需要获取questionId，content
 */
function commentQuestion(obj){
	var questionId=$(obj).attr("value");
	var content=$(obj).siblings("textarea").val();
	$.post(
		"../Controller/QuestionController.php",
		{action:"commentQuestion",questionId:questionId,content:content},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);			
			if(result.isLogon=="true" && result.affectRow==1){
				alert("评论成功");
				//动态增加评论信息
				var newComment="<li><ul><li>";
				newComment+="<span>"+result.createdComment[0].commenter+"：</span>";
				newComment+="<span>"+result.createdComment[0].content+"</span>";
				newComment+="<button class='btn-link disableBtn' value='"+result.createdComment[0].commentId+"' onClick='disableCommentForQuestion(this)'>删除</button>";
				newComment+="<button class='btn-link replyBtn' value='"+result.createdComment[0].commentId+"' onClick='showReplyCommentDiv(this)'>回复</button>";
				newComment+="<div class='replysForComment'></div></li></ul></li>";
				$("#questionAnswers>ul").append(newComment);
				//动态增加评论数
				var commentCount=parseInt($("#commentCount").text());
				$("#commentCount").html(commentCount+1);
				//动态隐藏评论框
				$(obj).siblings("textarea").val("");
				$(obj).parent().hide();
			}
			else if(result.isLogon=="false"){
				alert("您没有登录，请在登录之后进行评论");
			}
			else{
				alert("发生了未知错误，请联系管理员");
			}
		}
	);	
}
/**
 * 取消回复评论div的函数
 * 由于评论div是动态生成的，所以这里用这个函数动态删除
 */
function cancelReplyComment(obj){
	$(obj).parent().remove();
}

/**
 * 删除问题的相关评论的函数
 * 需要使用元素的value传入commentId
 */
function disableCommentForQuestion(obj){
	var commentId=$(obj).attr("value");
	$.post(
		"../Controller/QuestionController.php",
		{action:"disableCommentForQuestion",commentId:commentId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				alert("删除评论成功!");
				//删除成功后直接使用jquery移除网页上的评论，有利于整体优化网站响应速度（比重新加载评论要快）
				$(obj).parent().parent().parent().remove();
				//动态减小评论数
				var commentCount=parseInt($("#commentCount").text());
				$("#commentCount").html(commentCount-1);
			}
			else{
				alert("删除评论失败!");
			}
		}
	);
}
/**
 * 获取评论的所有回复信息的函数
 * 需要通过元素value传入commentId
 */
function getReplysForComment(obj){
	//第一次没有加载的时候就加载，之后就直接显示或者隐藏div就可以了，是通过该div有没有子元素来进行判断的
	//因为是通过class而不是id来进行选择，所以选择的逻辑要复杂一点
	if(!($(obj).siblings(".replysForComment").children().length>0)){
		//通过当前元素的兄弟节点获取值，让表达式更有通用性一点
		var commentId=$(obj).attr("value");
		$.get(
			"../Controller/QuestionController.php",
			{action:"getReplysForComment",commentId:commentId},
			function(data){
				var result=$.trim(data);
				result=$.parseJSON(result);
				var replyList="";
				result.replys.forEach(function(value,index){
					replyList+="<li>";
					replyList+="<span>"+value.replyer+"&nbsp;回复&nbsp;"+value.fatherReplyer+"：</span>";
					replyList+="<span>"+value.content+"</span>";
					//传递commentId到它的回复信息的div中，否则回复信息的div中的元素将不方便获取commentId的值
					replyList+="<input type='hidden' class='commentIdForReplys' value='"+commentId+"' />";
					if(value.replyer==result.logonUser){
						replyList+="<button class='btn-link disableReplyBtn' value='"+value.replyId+"' onClick='disableReply(this)'>删除</button>";
					}
					replyList+="<button class='btn-link replyBtn' value='"+value.replyId+"' onClick='showReplyReplyDiv(this)'>回复</button>";
				});
				$(obj).siblings(".replysForComment").html(replyList);
			}
		);
	}
	else{
		$(obj).siblings(".replysForComment").toggle();
	}	
}
/**
 * 显示回复评论的div
 */
function showReplyCommentDiv(obj){
	var commentId=$(obj).attr("value");
	if(chkUserLogonByWelcome()=="true"){
		if($(".replyCommnetOrReplyDiv").length>0){
			alert("您还有其他打开的评论未评论且未取消，请评论或取消后再点击评论");			
		}
		else{
			var replyHtml="<div class='replyCommnetOrReplyDiv'><textarea></textarea><br />";
			replyHtml+="<button class='btn btn-success' value='"+commentId+"' onClick='replyComment(this)'>回复</button>";
			replyHtml+="<button class='btn btn-warning' onclick='cancelReplyComment(this)'>取消</button></div>";
			$(obj).after(replyHtml);
		}
	}
	else{
		alert("请先登录系统");
	}
	
}
/**
 * 显示回复回复的div
 */
function showReplyReplyDiv(obj){
	var fatherReplyId=$(obj).attr("value");
	if(chkUserLogonByWelcome()=="true"){
		if($(".replyCommnetOrReplyDiv").length>0){
			alert("您还有其他打开的评论未评论且未取消，请评论或取消后再点击评论");			
		}
		else{
			var replyHtml="<div class='replyCommnetOrReplyDiv'><textarea></textarea><br />";
			replyHtml+="<button class='btn btn-success' value='"+fatherReplyId+"' onClick='replyReply(this)'>回复</button>";
			replyHtml+="<button class='btn btn-warning' onclick='cancelReplyComment(this)'>取消</button></div>";
			$(obj).parent().append(replyHtml);
		}
	}
	else{
		alert("请先登录系统");
	}
}

/**
 * 原本打算将回复评论和回复回复写在同一个函数里面
 * 但是后来发现这样做加强了耦合，不方便代码修改调试，容易让代码陷入一团糟的处境
 */

function replyComment(obj){
	var fatherReplyId=$(obj).attr("value");
	var commentId=fatherReplyId;	
	var content=$(obj).siblings("textarea").val();
	$.post(
		"../Controller/QuestionController.php",
		{action:"replyComment",fatherReplyId:fatherReplyId,commentId:commentId,content:content},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.isLogon=="true" && result.insertRow==1){
				alert("回复成功");
				//动态增加回复条数信息
				var replyCountBtn=$(obj).parent().parent().children("button.detailsBtn").first().children(".replyCountBtn");
				if(replyCountBtn.length>0){//如果按钮已经存在
					//获取该值，并将值增加1
					replyCount=parseInt(replyCountBtn.text());
					replyCountBtn.html(replyCount+1);
				}
				else{//不存在时，直接增加html代码
					replyCountHtml="<button class='btn-link detailsBtn' value='"+commentId+"' onClick='getReplysForComment(this)'>";
					replyCountHtml+="<span class='replyCountBtn'>1</span>条回复</button>";
					$(obj).parent().siblings(".replyBtn").first().before(replyCountHtml);
				}		
				//动态增加回复的信息
				var replyContentHtml="<li><span>"+result.replyContent[0].replyer+"&nbsp;回复&nbsp;";
				replyContentHtml+=result.replyContent[0].fatherReplyer+"：</span>";
				replyContentHtml+="<span>"+result.replyContent[0].content+"</span>";
				replyContentHtml+="<input type='hidden' class='commentIdForReplys' value='"+commentId+"'>";
				replyContentHtml+="<button class='btn-link disableReplyBtn' value='"+result.replyContent[0].replyId+"' onClick='disableReply(this)'>删除</button>";
				replyContentHtml+="<button class='btn-link replyBtn' value='"+result.replyContent[0].replyId+"' onclick='showReplyReplyDiv(this)'>回复</button>"
				replyContentHtml+="</li>";
				//将li增加到上一个li的后面，要注意层次关系
				$(obj).parent().next().append(replyContentHtml);
				//动态删除回复框
				$(obj).parent().remove();				
			}
			else if(result.isLogon=="false"){
				alert("您没有登录，请在登录之后进行回复");
			}
			else{
				alert("评论失败，发生未知错误，请联系管理员");
			}
		}
	);
}

/**
 * 原本打算将回复评论和回复回复写在同一个函数里面
 * 但是后来发现这样做加强了耦合，不方便代码修改调试，容易让代码陷入一团糟的处境
 */

function replyReply(obj){
	var fatherReplyId=$(obj).attr("value");
	var commentId=$(obj).parent().siblings(".commentIdForReplys").attr("value");	
	var content=$(obj).siblings("textarea").val();
	$.post(
		"../Controller/QuestionController.php",
		{action:"replyReply",fatherReplyId:fatherReplyId,commentId:commentId,content:content},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.isLogon=="true" && result.insertRow==1){
				alert("回复成功");
				//动态增加回复条数信息
				var replyCountBtn=$(obj).parent().parent().parent().siblings("button.detailsBtn").first().children(".replyCountBtn");
				// alert("回复条数"+replyCountBtn.text());
				//获取该值，并将值增加1
				replyCount=parseInt(replyCountBtn.text());
				replyCountBtn.html(replyCount+1);
				//动态增加回复的信息
				var replyContentHtml="<li><span>"+result.replyContent[0].replyer+"&nbsp;回复&nbsp;";
				replyContentHtml+=result.replyContent[0].fatherReplyer+"：</span>";
				replyContentHtml+="<span>"+result.replyContent[0].content+"</span>";
				replyContentHtml+="<input type='hidden' class='commentIdForReplys' value='"+commentId+"'>";
				replyContentHtml+="<button class='btn-link disableReplyBtn' value='"+result.replyContent[0].replyId+"' onClick='disableReply(this)'>删除</button>";
				replyContentHtml+="<button class='btn-link replyBtn' value='"+result.replyContent[0].replyId+"' onclick='showReplyReplyDiv(this)'>回复</button>"
				replyContentHtml+="</li>";
				//将li增加到上一个li的后面，要注意层次关系
				$(obj).parent().parent().after(replyContentHtml);
				//动态删除回复框
				$(obj).parent().remove();	
			}
			else if(result.isLogon=="false"){
				alert("您没有登录，请在登录之后进行回复");
			}
			else{
				alert("评论失败，发生未知错误，请联系管理员");
			}
		}
	);
}

/**
 * 删除一条回复评论的信息
 */
function disableReply(obj){
	var replyId=$(obj).attr("value");
	$.post(
		"../Controller/QuestionController.php",
		{action:"disableReplyForComment",replyId:replyId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.disableRow==1){
				alert("删除成功");
				//动态减少回复条数信息
				var replyCountBtn=$(obj).parent().parent().siblings("button.detailsBtn").first().children(".replyCountBtn");
				// alert("剩余评论条数"+replyCountBtn.text());
				if(replyCountBtn.length>0 && parseInt(replyCountBtn.text())>1){//如果按钮已经存在
					//获取该值，并将值减少1
					replyCount=parseInt(replyCountBtn.text());
					replyCountBtn.html(replyCount-1);
				}
				else{//值等于0时，删除该按钮
					replyCountBtn.parent().remove();
				}				
				//删除成功后直接使用jquery移除网页上的评论，有利于整体优化网站响应速度（比重新加载评论要快）
				$(obj).parent().remove();
			}
			else{
				alert("删除失败");
			}
		}
	);
}

/**
 * 下面的函数通过页面上是否有欢迎信息检测用户是否登录
 */
function chkUserLogonByWelcome(){
	var welcome="";
	var welcomeReg=/^欢迎你*$/;
	var isLogon="false";
	if($("#welcomeInfo").length>0){
		isLogon="true";
	}
	return isLogon;
}
