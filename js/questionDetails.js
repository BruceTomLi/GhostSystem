// 由于需要在几个不同的地方显示问题详情,现在把它抽象到
//questionDetails.php 和questionDetails.js 和questionDetails.css 三个文件中
$(function(){
	//点击“返回问题列表时”返回
	$("#questionListBtn").on("click",function(){
		$(".detailsDiv").hide();
		$(".questionDetailsDiv").hide();
		$(".queryDiv").show();
		$(".editDiv").hide();
		$(".createDiv").hide();
		//为了让取消问题关注的用户看到取消后的效果，这里使用一个页面刷新
		window.location.reload();
	});
	
	//页面加载时检测用户是否登录了系统
	isUserLogon();
});

/**
 * 获取用户是否登录了系统，在页面load的时候调用，如果登录了，就在html中写入一个hidden的标记元素
 * 以便chkUserLogonByWelcome()函数可以获取到相应值
 */
function isUserLogon(){
	$.get(
		"../Controller/QuestionController.php",
		{action:"isUserLogon"},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.isUserLogon==1){
				var isUserLogonHtml="<input type='hidden' id='isUserLogonId'>";
				$("#questionDetails").after(isUserLogonHtml);
			}
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
				//问题是可用状态下显示添加评论
				if(value.enable==1){
					questionList+="<p><button class='btn-link' id='addCommentBtn' value='"+value.questionId+"' onClick='showCommentDiv(this)'>添加评论</button>";
				}
				//用户是否关注了问题，有为0和为1的情况，也有用户没登录的情况，用户没登录时不显示
				if(result.hasUserFollowedQuestion==0){
					questionList+="<button class='btn-link' id='addFollowBtn' value='"+value.questionId+"' onClick='addQuestionFollow(this)'>添加关注</button></p>";
				}
				if(result.hasUserFollowedQuestion==1){
					questionList+="<button class='btn-link' id='deleteFollowBtn' value='"+value.questionId+"' onClick='deleteQuestionFollow(this)'>取消关注</button></p>";
				}
				else{
					questionList+="</p>";
				}
				
			});
			$("#questionDetails").html(questionList);
			
			var questionAnswers="<h4><span id='commentCount'>"+result.commentCount+"</span>个回复</h4>";
			questionAnswers+="<hr><ul>";
			result.questionComments.forEach(function(value,index){
				questionAnswers+="<li><ul><li>";
				questionAnswers+="<span><a target='_blank' href='../forum/person.php?userId="+value.commenterId+"'>"+value.commenter+"</a>：</span>";
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
			
			$(".detailsDiv").show();
			$(".questionDetailsDiv").show();
			$(".queryDiv").hide();
			$(".editDiv").hide();
			$(".createDiv").hide();
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
				newComment+="<span><a target='_blank' href='../forum/person.php?userId="+result.createdComment[0].commenterId+"'>"+result.createdComment[0].commenter+"</a>：</span>";
				
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
					replyList+="<span><a target='_blank' href='../forum/person.php?userId="+value.replyerId+"'>"+value.replyer+"</a>&nbsp;";
					replyList+="回复&nbsp;<a target='_blank' href='../forum/person.php?userId="+value.fatherReplyerId+"'>"+value.fatherReplyer+"</a>：</span>";
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
				var replyContentHtml="<li><span><a target='_blank' href='../forum/person.php?userId="+result.replyContent[0].replyerId+"'>"+result.replyContent[0].replyer+"</a>&nbsp;";
				replyContentHtml+="回复&nbsp;<a target='_blank' href='../forum/person.php?userId="+result.replyContent[0].fatherReplyerId+"'>"+result.replyContent[0].fatherReplyer+"</a>：</span>";
					
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
				alert("评论失败，发生未知错误，请联系管理员"+result.isLogon);
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
				var replyContentHtml="<li><span><a target='_blank' href='../forum/person.php?userId="+result.replyContent[0].replyerId+"'>"+result.replyContent[0].replyer+"</a>&nbsp;";
				replyContentHtml+="回复&nbsp;<a target='_blank' href='../forum/person.php?userId="+result.replyContent[0].fatherReplyerId+"'>"+result.replyContent[0].fatherReplyer+"</a>：</span>";
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
				alert("评论失败，发生未知错误，请联系管理员"+result.isLogon);
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
 * 由于将问题详情页抽象出来了，而用到问题详情页的地方并非都在论坛中，在个人问题管理中也有
 * 所以不能再淡出通过欢迎信息判断用户是否登录。为了让这个函数在不同情况下都正常工作，
 * 这里在欢迎信息中没检测到的情况下到后台session中进行检测
 * 原本打算用ajax，但是ajax里面修改函数外的值的时间存在延迟，得不到正确结果
 * 所以这里针对不同页面的元素进行判断。在manage页中也加入一个#welcomInfo的hidden元素
 * 后来发现这样也不行，php的include中的js无法检测到include之外的页面元素，所以只好把这个判断逻辑放在各自的页面中
 * 后来发现放在各自的页面中，下面的函数也捕捉不到相应的元素，而且也降低了这个问题详情页的内聚性
 * 于是设置了一个isUserLogon的函数，在页面加载时运行，并向页面中写入一个#isUserLogonId的标签，用来指示用户登录状态
 */
function chkUserLogonByWelcome(){
	var welcome="";
	var isLogon="false";
	if($("#isUserLogonId").length>0){
		isLogon="true";
	}
	return isLogon;	
}

/**
 * 下面的函数添加用户对问题的关注
 */
function addQuestionFollow(obj){
	//用户已经登录的情况下才能关注问题
	if(chkUserLogonByWelcome()=="true"){
		var questionId=$(obj).attr("value");
		$.post(
			"../Controller/QuestionController.php",
			{action:"addFollow",starId:questionId,followType:"question"},
			function(data){
				var result=$.trim(data);
				result=$.parseJSON(result);
				if(result.affectRow==1){
					alert("关注成功");
					var deleteFollowHtml="<button class='btn-link' id='deleteFollowBtn' value='"+questionId+"' onClick='deleteQuestionFollow(this)'>取消关注</button>";
					$(obj).parent().append(deleteFollowHtml);
					$(obj).remove();
				}
				else if(result.affectRow==0){
					alert("你已经关注了该问题，不必重复关注");
				}
				else{
					alert(result.affectRow);
				}
			}
		);
	}
	else{
		alert("请在登录之后关注问题");
	}
}

/**
 * 用户取消关注一个问题
 */
function deleteQuestionFollow(obj){
	var questionId=$(obj).attr("value");
	$.post(
		"../Controller/QuestionController.php",
		{action:"deleteQuestionFollow",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				alert("取消关注成功");
				var addFollowHtml="<button class='btn-link' id='addFollowBtn' value='"+questionId+"' onClick='addQuestionFollow(this)'>添加关注</button>";
				$(obj).parent().append(addFollowHtml);
				$(obj).remove();
			}
			else if(result.affectRow==0){
				alert("你已经取消关注了该问题，不必重复取消");
			}
			else{
				alert(result.affectRow);
			}
		}
	);
}