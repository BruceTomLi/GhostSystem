$(function(){
	//将菜单项的当前页菜单增加选中样式
	$("#menuUl>li>a[href='selfQuestion.php']").siblings().parent().removeClass();
	$("#menuUl>li>a[href='selfQuestion.php']").parent().addClass("active");
	
	$("#createQuestionBtn").on("click",function(){
		createNewQuestion();
	});
		
	getSelfQuestionList();
	
	$("#searchQuestionBtn").on("click",function(){
		var keyword=$("#keyword").val();
		searchQuestionListByContentOrDescription(keyword);
	});
	
	//点击“返回问题列表时”返回
	$("#returnListBtn").on("click",function(){
		$(".detailsDiv").hide();
		$(".queryDiv").show();
		$(".editDiv").hide();
		$(".createDiv").hide();
	});
	
});

function createNewQuestion(){
	var inputQuestionType=$("#inputQuestionType").val();
	var inputQuestionContent=$("#inputQuestionContent").val();
	var questionDescription=$("#editor").html();
	$.post(
		"../Controller/QuestionController.php",
		{action:"createNewQuestion",questionType:inputQuestionType,
			questionContent:inputQuestionContent,questionDescription:questionDescription},
		function(data){
			var result=$.trim(data);
			if(result==1){
				alert("问题添加成功");
				getSelfQuestionList();
			}
			else{
				alert("问题添加失败，请检查是否为重复问题");
			}
		}
	);
}

function getSelfQuestionList(){
	$.post(
		"../Controller/QuestionController.php",
		{action:"getSelfQuestionList"},
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

				if(value.enable=="1"){
					questionList+="<td><button class='btn-link' onClick='disableSelfQuestion(this)' value='"+value.questionId+"'>禁用</button></td>";
				}
				else{
					questionList+="<td><button class='btn-link' onClick='enableSelfQuestion(this)' value='"+value.questionId+"'>启用</button></td>";
				}
				
				questionList+="</tr>";
			});
			$(".selfTable tbody").html(questionList);
		}
	);
	$(".detailsDiv").hide();
	$(".queryDiv").show();
	$(".editDiv").hide();
	$(".createDiv").hide();
}


function searchQuestionListByContentOrDescription(keyword){
	$.get(
		"../Controller/QuestionController.php",
		{action:"searchQuestionListByContentOrDescription",keyword:keyword},
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

				if(value.enable=="1"){
					questionList+="<td><button class='btn-link' onClick='disableSelfQuestion(this)' value='"+value.questionId+"'>禁用</button></td>";
				}
				else{
					questionList+="<td><button class='btn-link' onClick='enableSelfQuestion(this)' value='"+value.questionId+"'>启用</button></td>";
				}
				questionList+="</tr>";
			});
			$(".selfTable tbody").html(questionList);
		}
	);
}

function disableSelfQuestion(obj){
	var questionId=$(obj).attr("value");
	$.post(		
		"../Controller/QuestionController.php",
		{action:"disableSelfQuestion",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				//将原本的禁用连接改为启用连接
				var enableBtnHtml="<button class='btn-link' onClick='enableSelfQuestion(this)' value='"+questionId+"'>启用</button>";
				$(obj).parent().html(enableBtnHtml);
			}
			else if(result.affectRow==0){
				alert("问题已经禁用，无需再次禁用");
			}
			else{
				alert(result.affectRow);
			}
		}
	);
}

/**
 * 下面是将问题改为启用状态的函数
 */
function enableSelfQuestion(obj){
	var questionId=$(obj).attr("value");
	$.post(		
		"../Controller/QuestionController.php",
		{action:"enableSelfQuestion",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				//将原本的启用连接改为禁用连接
				var disableBtnHtml="<button class='btn-link' onClick='disableSelfQuestion(this)' value='"+questionId+"'>禁用</button>";
				$(obj).parent().html(disableBtnHtml);
			}
			else if(result.affectRow==0){
				alert("问题已经启用，无需再次启用");
			}
			else{
				alert(result.affectRow);
			}
		}
	);
}

