//注册页面加载时的起始事件
$(function(){
	$("#priceDetail").on("click",function(){
		getArticleDetail();
	});
});

//下面是加载文章详情的函数
function getArticleDetail(){
	$("#articleDetail").load("View/article.html #articleContent");
}
