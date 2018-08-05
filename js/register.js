var isNameOk=false,isEmailOk=false,isPwdOk=false,isValcodeOk=false,isAgree=false;
$(function(){
	var isShow = false;//没显示	
	
	/**
	 * 单击“更多资料”时显示或者隐藏
	 */
	$('.moreInfo').on('click',function(){
		$('.moreForm').toggle();
		if(!isShow) {
			$('.moreInfo').html('收起');
		}else {
			$('.moreInfo').html('更多资料');
		}
		isShow = !isShow;
	});	
	/**
	 * 单击注册按钮时注册
	 */
	$("#registerBtn").on('click',function(){	
		var canRegister=chkAllInput();
		if(canRegister){		
			register();
		}
	});
	/**
	 * 当名称输入框焦点离开时检测名字是否可用
	 */
	$('#inputUsername').on('blur',function(){
		chkInputUserName();
	});
	/**
	 * 当邮箱输入按键抬起时检测邮箱是否可用
	 */
	$('#inputEmail').on('keyup',function(){
		chkInputEmail();
	});
	$('#inputEmail').on('blur',function(){
		chkInputEmail();
	});
	/**
	 * 当密码输入按键抬起时检测密码强度
	 */
	$('#inputPassword').on('keyup',function(){
		chkInputPassword();
	});
	$('#inputPassword').on('blur',function(){
		chkInputPassword();
	});
	/**
	 * 页面加载和点击验证码图片时更新验证码
	 */
	showValcode();
	$('#valcodeId').on('click',function(){
		showValcode();
	});
	
	$('#inputValcode').on('keyup',function(){
		chkInputValcode();
	});
	
	$('#isAgree').on('click',function(){
		chkIsUserAgree();
	});
	
	getJobList();
	getProvinceList();
	
	$('#province').on('change',function(){
		getCityList();
	});
});

/**
 * 检测用户是否同意了合同
 */
function chkIsUserAgree(){
	if($('#isAgree').is(':checked')){
		isAgree=true;
	}
	else{
		isAgree=false;
	}	
}
/**
 * 检测所有输入的信息
 */
function chkAllInput(){
	chkInputValcode();
	chkIsUserAgree();
	var flag = isNameOk && isEmailOk && isPwdOk && isValcodeOk && isAgree;
	if(flag) {			
		$('#regChk').text("你的信息可以提交了").removeClass().addClass('chkSuccess');
	}else {	
		$('#regChk').text("您的信息未通过校验").removeClass().addClass('chkWarning');
		chkInputUserName();
		chkInputEmail();
		chkInputPassword();
	}
	return flag;
}
/**
 * 显示验证码
 */
function showValcode(){
	num='';
	for($i=0;$i<4;$i++){
		type=Math.random()*3;
		if(type<=1){
			num+=(Math.floor(Math.random()*10)).toString();//随机的0-9的整数
		}
		else if(type>1 && type<=2){
			num+=String.fromCharCode(Math.ceil(Math.random()*25)+65);//随机小写字母
		}
		else{
			num+=String.fromCharCode(Math.ceil(Math.random()*25)+97);//随机大写字母
		}
	}
	$('#valcodeId').attr("src","classes/valcode.php?num="+num);
	$('#valcodeValue').val(num);
}
/**
 * 检测输入的username信息
 */
function chkInputUserName(){
	var username=$.trim($('#inputUsername').val());
	if(username==''){
		$('#userNameChk').text("用户名不能为空").removeClass().addClass("chkError");	
		isNameOk=false;
	}
	else if(username.length<2 || username.length>20){
		$('#userNameChk').text("2<用户名长度<20").removeClass().addClass("chkError");	
		isNameOk=false;
	}
	else{
		chkUsername();		
	}
}
/**
 * 检测输入的email信息
 */
function chkInputEmail(){
	var emailreg=/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;
	var email=$.trim($('#inputEmail').val());
	email.match(emailreg);
	if(email==''){
		$('#emailChk').text("邮箱不能为空").removeClass().addClass("chkError");	
		isEmailOk=false;
	}
	else if(email.match(emailreg)==null){
		$('#emailChk').text("邮箱格式不正确").removeClass().addClass("chkError");	
		isEmailOk=false;
	}
	else{
		chkEmail();
	}
}

/**
 * 检测输入的密码信息,验证密码强度
 */
function chkInputPassword2(){
	var pwd=$('#inputPassword').val();
	if(pwd.length<6 || pwd.length>18){
		$('#passwordChk').html("6<密码长度<18").removeClass().addClass("chkError");
	}
	else{
		if(pwd.match(/[\S]*[\s]+[\S]*/)){
			$('#passwordChk').html("密码中不能含有空白字符").removeClass().addClass("chkError");
		}
		//下面是用来验证密码强度的正则表达式和代码，思路要清晰，密码等级是从弱到强，所以相应的判断也是嵌套的
		else if(pwd.match(/\d+/) || 
			pwd.match(/[a-zA-Z]+/) ||
			pwd.match(/[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+/)){
			$('#passwordChk').html("密码等级：弱").removeClass().addClass("chkWarning");
			
			//弱强度密码是数字，大小写字母，特殊字符的两两组合
			if(pwd.match(/[a-zA-Z]+\d+/) || pwd.match(/\d+[a-zA-Z]+/) ||
				pwd.match(/[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+\d+/) ||
				pwd.match(/\d+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+/) ||
				pwd.match(/[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+[a-zA-Z]+/) ||
				pwd.match(/[a-zA-Z]+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+/))
			{
				$('#passwordChk').html("密码等级：中").removeClass().addClass("chkWarning");		
				
				if(pwd.match(/([\s\S]*)\d+[a-zA-Z]+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+([\s\S]*)/)||
				pwd.match(/([\s\S]*)\d+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+[a-zA-Z]+([\s\S]*)/)||
				pwd.match(/([\s\S]*)[a-zA-Z]+\d+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+([\s\S]*)/)||
				pwd.match(/([\s\S]*)[a-zA-Z]+[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+\d+([\s\S]*)/)||
				pwd.match(/([\s\S]*)[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+\d+[a-zA-Z]+([\s\S]*)/)||
				pwd.match(/([\s\S]*)[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]+[a-zA-Z]+\d+([\s\S]*)/))
				{
					$('#passwordChk').html("密码等级：强").removeClass().addClass("chkSuccess");	
				}
			}
			return true;
		}			
	}
	return false;
}

function chkInputPassword(){
	
	var reNum = new RegExp(/\d/);
	
	var reLetter = new RegExp(/[a-zA-Z]/);
	
	var reSpecialLetter = new RegExp(/[-`=\\\[\];',./~!@#$%^&*()_+|{}:"<>?]/);
	
	var pwd=$('#inputPassword').val();
	
	var hasNum = reNum.test(pwd)?1:0;
	
	var hasLetter = reLetter.test(pwd)?1:0;
	
	var hasSpecialLetter = reSpecialLetter.test(pwd)?1:0;
	
	var status = hasNum +hasLetter +hasSpecialLetter;
	
	if(pwd.length<6 || pwd.length>18){
		$('#passwordChk').html("6<密码长度<18").removeClass().addClass("chkError");
		isPwdOk=false;
	}
	else{
		switch(status) {
			case 1:
				$('#passwordChk').html("密码等级：弱").removeClass().addClass("chkWarning");
				break;
			case 2:
				$('#passwordChk').html("密码等级：中").removeClass().addClass("chkWarning");	
				break;
			case 3:
				$('#passwordChk').html("密码等级：强").removeClass().addClass("chkSuccess");	
				break;
			default:
				$('#passwordChk').html("密码强度未知").removeClass().addClass("chkError");	
				break;
		}
		isPwdOk=true;
	}
}
/**
 * 检测验证码是否正确
 */
function chkInputValcode(){
	if($('#inputValcode').val().toLowerCase()==$('#valcodeValue').val().toLowerCase()){
		$('#valcodeChk').html('验证码输入正确').removeClass().addClass("chkSuccess");
		isValcodeOk=true;
	}
	else{
		$('#valcodeChk').html('验证码输入错误').removeClass().addClass("chkError");
		isValcodeOk=false;
	}	
}
/**
 * 加载职业列表
 */
function getJobList (){
	$.ajax({
		url:'Controller/RegisterController.php',
		data:{action:"getJobList"},
		success: function(data) {
			data = $.trim(data);
			//$('#inputJob').html(data);
			//alert(data);
			data=$.parseJSON(data);
			var jobLists="<option value='empty'>--</option>";
			data.forEach(function(value,index){
				// alert(value.job);
				//jobLists+="<option value='"+value.job"'>"+value.job+"</option>";
				jobLists=jobLists+"<option value='"+value.job+"'>"+value.job+"</option>";
				//jobLists=jobLists+"abc"+value.job;
			});
			//alert("<select>"+jobLists+"</select>");
			$('#inputJob').html(jobLists);
		}		
	});
}

/**
 * 加载省
 */
function getProvinceList (){
	$.ajax({
		url:'Controller/RegisterController.php',
		data:{action:"getProvinceList"},
		success: function(data) {
			data = $.trim(data);
			data = $.parseJSON(data);
			var provinceLists="<option value='empty'>--</option>";
			data.forEach(function(item,index) {
				provinceLists += `<option value='${item.province}'>${item.province}</option>`;
			});
			
			$('#province').html(provinceLists);
		}		
	});	
}
/**
 * 加载城市
 */
function getCityList (){
	var province = $('#province').val();
	$.ajax({
		url:'Controller/RegisterController.php',
		data:{action:"getCityList",province:province},
		success: function(data) {			
			data = $.trim(data);
			data = $.parseJSON(data);
			var cityLists="<option value='empty'>--</option>";
			data.forEach(function(item,index) {
				cityLists += `<option value='${item.city}'>${item.city}</option>`;
			});
			
			$('#city').html(cityLists);
		}		
	});
}
/**
 * 下面的函数获取用户填写的信息并提交
 */
function register(){
	var username=$('#inputUsername').val();
	var email=$('#inputEmail').val();
	var password=$('#inputPassword').val();
	var sex=$("input[name='sexRadios']:checked").val()=="man"?1:0;
	var job=$('#inputJob').val();
	var province=$('#province').val();
	var city=$('#city').val();
	var oneWord=$('#inputOneWord').val();
	var heading='';
	$.post(
		'Controller/RegisterController.php',
		{action:"register",username:username,email:email,password:password,sex:sex,
			job:job,province:province,city:city,oneWord:oneWord,heading:heading},
		function(data){
			var result=$.trim(data);
			result=$.parseJSON(result);
			if(result.affectRow==1){
				alert("注册成功,请登录");
				location="login.php";
			}
			else{
				alert(result.affectRow);
				chkAllInput();
			}
		}
	);
}

/**
 * 下面的函数检测用户名是否重名
 */
function chkUsername(){
	//去除用户名前后的空格
	var username=$.trim($('#inputUsername').val());
	$.get(
		'Controller/RegisterController.php',
		{action:"chkUsername",username:username},
		function(data){
			data=$.trim(data);
			if(data==1){
				$('#userNameChk').html("用户名重复").removeClass().addClass("chkError");
				isNameOk=false;
			}
			else{
				$('#userNameChk').html("用户名可用").removeClass().addClass("chkSuccess");	
				isNameOk=true;
			}
		}		
	);
}


function chkUsername2(){
	isUserNameOk=false;
	//去除用户名前后的空格
	var username=$.trim($('#inputUsername').val());
	var data =$.ajax({
		url:'Controller/RegisterController.php',
		data:{action:"chkUsername",username:username},
		success:function(data){
			return data;
		}
	}
	);
	console.log(data);
	data=$.trim(data);
			if(data==1){
				$('#userNameChk').html("用户名重复").removeClass().addClass("chkError");
			}
			else{
				$('#userNameChk').html("用户名可用").removeClass().addClass("chkSuccess");				
	}
	//console.log(a)
}

/**
 * 下面的函数检测邮箱是否重复，因为用户可以通过邮箱登录系统，所以用户邮箱也应当是唯一的
 */
function chkEmail(){
	isEmailOk=false;
	//去除用户名前后的空格
	var email=$.trim($('#inputEmail').val());
	$.get(
		'Controller/RegisterController.php',
		{action:"chkEmail",email:email},
		function(data){
			data=$.trim(data);
			if(data==1){
				$('#emailChk').html("邮箱已被使用").removeClass().addClass("chkError");
				isEmailOk=false;
			}
			else{
				$('#emailChk').html("邮箱格式可用").removeClass().addClass("chkSuccess");
				isEmailOk=true;
			}
		}
	);
}
