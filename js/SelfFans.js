$(function(){
	//将菜单项的当前页菜单增加选中样式
	$("#menuUl>li>a[href='selfFans.php']").parent().addClass("active");
	
	//加载出粉丝信息
	loadUserFans();
});

/**
 * 加载用户的粉丝信息
 */
function loadUserFans(){
	$.get(
		"../Controller/SelfFansController.php",
		{action:"loadUserFans"},
		function(data){
			var fans=$.trim(data);
			fans=$.parseJSON(fans);
			var fansHtml="";
			fans.fans.forEach(function(value,index){
				fansHtml+="<tr>";
				fansHtml+="<td><img src='"+value.heading+"'></td>";
				fansHtml+="<td><a href='../forum/person.php?userId="+value.userId+"' target='_blank'>"+value.username+"</a>";
				var fansSex=value.sex==1?"男":"女";
				fansHtml+="<td>"+fansSex+"</td>";
				fansHtml+="<td>"+value.email+"</td>";
				fansHtml+="</tr>";
			});
			$("#fansTable tbody").html(fansHtml);			
		}
	);
}
