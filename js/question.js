/**
 * 用jquery在页面加载时给元素注册的事件，对于后来在页面中添加的元素该事件无效
 * 所以以后在编写页面动态生成的元素事件时，好的做法是直接在元素中添加onClick方法，可以将this
 * 作为参数传递
 */
$(function(){
	//页面加载时加载所有问题的列表
	getAllQuestion();
	
	//点击“返回问题列表时”返回
	$("#returnListBtn").on("click",function(){
		$(".detailsDiv").hide();
		$(".queryDiv").show();
		$(".editDiv").hide();
		$(".createDiv").hide();
	});
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

