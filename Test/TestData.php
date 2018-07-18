<?php
	/**
	 * 这个文件用来设置一些测试用的数据
	 * 因为测试时需要对数据库中的数据进行增删改查，可能导致测试进行完第一次之后就测试失败
	 */
	 
	define("UserName", "王五");
	define("Password","wangwu@123");
	define("RepeatName","tomtom");
	define("RepeatEmail","fasdfa@qq.com");
	define("Province","湖北省");
	define("QuestionType","IT");
	define("QuestionContent","这是单元测试里面用来测试创建一个新的问题的测试内容");
	define("QuestionDescription","这里是问题描述，实际情况中可以填写超文本信息");
	define("QuestionId","5b4aef6c45e9e6.45739237");
	define("ExampleComment","这里测试给问题增加一条评论");
	define("CommentId","5b4dd0a4ebafb1.55621100");
	define("ReplyId","5b4dbb8b045832.31629494");
	define("ReplyContent","这里测试给一条评论添加一条回复");
	define("FatherReplyId","5b4dbb8b045832.31629494");
?>