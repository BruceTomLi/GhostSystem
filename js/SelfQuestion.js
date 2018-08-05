$(function(){
	//将菜单项的当前页菜单增加选中样式
	$("#menuUl>li>a[href='selfQuestion.php']").parent().addClass("active");
	
	$("#createQuestionBtn").on("click",function(){
		createNewQuestion();
	});
		
	//getSelfQuestionList();//为了方便显示分页，使用下面的函数。但是在添加问题成功之后还会调用它
	
	searchQuestionListByContentOrDescription();
	
	loadKeyword();//分页的搜索信息加载时，要在输入框中写入关键字
		
	//点击“返回问题列表时”返回
	$("#returnListBtn").on("click",function(){
		$(".detailsDiv").hide();
		$(".queryDiv").show();
		$(".editDiv").hide();
		$(".createDiv").hide();
	});
	
	//加载问题分类，用于用户在创建问题时选择
	loadQuestionTypes();
	
});

function loadKeyword(){
	var keyword=$("#keywordHidden").attr("value");
	$("#keyword").val(keyword);
}

function createNewQuestion(){
	var inputQuestionType=$("#inputQuestionType").val();
	var inputQuestionContent=$("#inputQuestionContent").val();
	var questionDescription=$("#editor").html();
	$.post(
		"../Controller/SelfQuestionController.php",
		{action:"createNewQuestion",questionType:inputQuestionType,
			questionContent:inputQuestionContent,questionDescription:questionDescription},
		function(data){
			var result=$.trim(data);
			if(result==1){
				alert("问题添加成功");
				getSelfQuestionList();
			}
			else{
				alert("问题添加失败，请检查是否为重复问题"+result);
			}
		}
	);
}

/**
 * 下面的函数是用来获取用户个人问题列表的，但是为了方便使用分页，在实际中没有使用到下面的函数
 * 而是在所有时候都使用的searchQuestionListByContentOrDescription()
 */
function getSelfQuestionList(){
	//现将值转化成一个合理的页数值
	var page=$.trim($("#pageHidden").attr("value"));
	page=$.isNumeric(page)?page:1;//不是数字时设为1
	page=page<1?1:page;//小于1时设为1
	$.post(
		"../Controller/SelfQuestionController.php",
		{action:"getSelfQuestionList",page:page},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var questionList="";
			result.questions.forEach(function(value,index){
				questionList+="<tr>";
				questionList+="<td>"+value.asker+"</td>";
				questionList+="<td>"+value.askDate+"</td>";
				questionList+="<td>"+value.questionType+"</td>";
				questionList+="<td><a target='_blank' href='../forum/questionDetails.php?questionId="+value.questionId+"'>"+value.content+"</a></td>";

				if(value.enable=="1"){
					questionList+="<td><button class='btn btn-warning' onClick='disableSelfQuestion(this)' value='"+value.questionId+"'>不公开</button></td>";
				}
				else{
					questionList+="<td><button class='btn btn-success' onClick='enableSelfQuestion(this)' value='"+value.questionId+"'>公开</button></td>";
				}
				questionList+="<td><button class='btn btn-danger' onClick='deleteSelfQuestion(this)' value='"+value.questionId+"'>删除</button></td>";
				questionList+="</tr>";
			});
			$("#questionsTable tbody").html(questionList);
			//调用MyPager.js中定义的写分页信息
			writePager(result,page,"selfQuestion.php");
		}
	);
	$(".detailsDiv").hide();
	$(".queryDiv").show();
	$(".editDiv").hide();
	$(".createDiv").hide();
}

function searchQuestion(){
	var keyword=$.trim($("#keyword").val());
	$("#keywordHidden").attr("value",keyword);
	searchQuestionListByContentOrDescription();
}

function searchQuestionListByContentOrDescription(){
	var keyword=$.trim($("#keywordHidden").attr("value"));
	//现将值转化成一个合理的页数值
	var page=$.trim($("#pageHidden").attr("value"));
	page=$.isNumeric(page)?page:1;//不是数字时设为1
	page=page<1?1:page;//小于1时设为1
	$.get(
		"../Controller/SelfQuestionController.php",
		{action:"searchQuestionListByContentOrDescription",keyword:keyword,page:page},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var questionList="";
			result.questions.forEach(function(value,index){
				questionList+="<tr>";
				questionList+="<td>"+value.asker+"</td>";
				questionList+="<td>"+value.askDate+"</td>";
				questionList+="<td>"+value.questionType+"</td>";
				questionList+="<td><a target='_blank' href='../forum/questionDetails.php?questionId="+value.questionId+"'>"+value.content+"</a></td>";

				if(value.enable=="1"){
					questionList+="<td><button class='btn btn-warning' onClick='disableSelfQuestion(this)' value='"+value.questionId+"'>不公开</button></td>";
				}
				else{
					questionList+="<td><button class='btn btn-success' onClick='enableSelfQuestion(this)' value='"+value.questionId+"'>公开</button></td>";
				}
				questionList+="<td><button class='btn btn-danger' onClick='deleteSelfQuestion(this)' value='"+value.questionId+"'>删除</button></td>";
				questionList+="</tr>";
			});
			$("#questionsTable tbody").html(questionList);
			
			var paras=(keyword=="")?"":("&keyword="+keyword);//如果关键字为空，就让参数为空
			writePager(result,page,"selfQuestion.php",paras);
		}
	);
}

function disableSelfQuestion(obj){
	var questionId=$(obj).attr("value");
	$.post(		
		"../Controller/SelfQuestionController.php",
		{action:"disableSelfQuestion",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				//将原本的禁用连接改为启用连接
				var enableBtnHtml="<button class='btn btn-success' onClick='enableSelfQuestion(this)' value='"+questionId+"'>公开</button>";
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
		"../Controller/SelfQuestionController.php",
		{action:"enableSelfQuestion",questionId:questionId},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				//将原本的启用连接改为禁用连接
				var disableBtnHtml="<button class='btn btn-warning' onClick='disableSelfQuestion(this)' value='"+questionId+"'>不公开</button>";
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

/**
 * 删除自己的问题
 */
function deleteSelfQuestion(obj){
	if(confirm("确定要删除该问题吗？")){
		var questionId=$(obj).attr("value");
		$.post(
			"../Controller/SelfQuestionController.php",
			{action:"deleteSelfQuestion",questionId:questionId},
			function(data){
				var result=$.trim(data);
				result=$.parseJSON(result);
				if(result.deleteRow==1){
					$(obj).parent().parent().remove();
				}
				else if(result.deleteRow==0){
					alert("问题删除失败");
				}
				else{
					alert(result.affectRow);
				}
			}
		);
	}
}

/**
 * 加载用户问题
 */
function loadQuestionTypes(){
	$.get(
		"../Controller/SelfQuestionController.php",
		{action:"loadQuestionTypes"},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var typeHtml="";
			result.types.forEach(function(value,index){
				typeHtml+="<option value='"+value.name+"'>"+value.name+"</option>";
			});
			$("#inputQuestionType").html(typeHtml);
		}
	);
}
