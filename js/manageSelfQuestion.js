$(function(){
	$("#createQuestionBtn").on("click",function(){
		createNewQuestion();
	});
		
	getSelfQuestionList();
	
	$("#searchQuestionBtn").on("click",function(){
		var keyword=$("#keyword").val();
		searchQuestionListByContentOrDescription(keyword);
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
				questionList+="<td><button class='btn-link' onClick='deleteSelfQuestion(this)' value='"+value.questionId+"'>删除</button></td>";
				questionList+="</tr>";
			});
			$(".selfTable tbody").html(questionList);
		}
	);
}

function getQuestionDetails(obj){
	var questionId=$(obj).attr("value");
	$.post(		
		"../Controller/QuestionController.php",
		{action:"getSelfQuestionDetails",questionId:questionId},
		function(data){
			var questionDetails="";
			var result=$.trim(data);
			result=$.parseJSON(result);
			result.forEach(function(value,index){
				questionDetails+="<h4>"+value.content+"</h4>";
				questionDetails+="<p><span>提问者："+value.asker+"</span></p>";
				questionDetails+="<p><span>提问时间："+value.askDate+"</span></p>";
				questionDetails+="<section>描述："+value.questionDescription+"</section>";
			});
			
			$(".questionDetails").html(questionDetails);
		}
	);
	$(".detailsDiv").show();
	$(".queryDiv").hide();
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
				questionList+="<td><button class='btn-link' onClick='deleteSelfQuestion(this)' value='"+value.questionId+"'>删除</button></td>";
				questionList+="</tr>";
			});
			$(".selfTable tbody").html(questionList);
		}
	);
}

function deleteSelfQuestion(obj){
	var questionId=$(obj).attr("value");
	$.post(		
		"../Controller/QuestionController.php",
		{action:"deleteSelfQuestion",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				//当删除信息成功时，可以重新加载个人问题列表；但是这里如果使用直接通过jquery函数，
				//remove当前行的html代码效率明显会更高，对服务器性能整体优化比较有好处
				//getSelfQuestionList();
				$(obj).parent().parent().remove();
			}
			else{
				alert("删除问题出现故障，请联系管理员");
			}
		}
	);
}
