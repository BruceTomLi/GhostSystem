//注册页面加载时的起始事件
$(function(){
	getArticleList();
});
//获取文章信息
function getArticleList(){
	//现将值转化成一个合理的页数值
	var page=$.trim($("#pageHidden").attr("value"));
	page=$.isNumeric(page)?page:1;//不是数字时设为1
	page=page<1?1:page;//小于1时设为1
	$.get(
		"Controller/IndexController.php",
		{action:"getArticleList",page:page},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			var articlesHtml="";
			result.articles.forEach(function(value,index){
				articlesHtml+="<div class='hero-unit'>";
				articlesHtml+="<h1 class='artilceTitle'>"+value.title+"</h1>";
				articlesHtml+="<span>作者："+value.author+" - "+value.publishDate+"</span>";
				var onlyText="";//要先过滤掉特殊的html代码，只留下纯文本
				var sourceHtml=value.content;
				var reg=new RegExp("<[^<]*>", "gi");  
				onlyText=sourceHtml.replace(reg,"");
				articlesHtml+="<p>"+onlyText.substr(0,100)+"</p>";
				articlesHtml+="<p><a class='btn btn-primary' target='_blank' href='forum/articleDetails.php?articleId="+value.articleId+"'>阅读全文</a></p>";
				articlesHtml+="</div>";
			});
			$("#articleDetail").html(articlesHtml);
			writePager(result,page,"index.php");
		}
	);
}
