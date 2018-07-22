<section class="questionDescription">
	<div id="questionDetails">
		<h4>Ghost是什么</h4>
		<hr>
		<p><span>描述：</span>不太明白ghost是做什么用的</p>
		<p><span>时间：</span><span>2018/7/10</span></p>
		<p>
			<button class="btn-link" id="addCommentBtn">添加评论</button>
			<button class="btn-link" id="addFollowBtn">添加关注</button>
		</p>
		<input type="hidden" id="questionIdHidden" value="这里记录questionId"  />	
	</div>													
	<div id="addCommentDiv">
		<textarea></textarea><br />
		<button class="btn btn-success" value="" id="submitCommentBtn" onClick='commentQuestion(this)'>评论</button>
		<button class="btn btn-warning" id="cancelAddComment" onClick='cancelAddComment(this)'>取消</button>
	</div>
</section>	
<section id="questionAnswers">
	<h4>2个回复</h4>
	<hr>
	<ul>
		<li>
			<ul>
				<li>
					<span>天外天：</span>
					<span>
						不是，软件的bug往往难以全部修复，可以在容许几个不影响主要业务的bug
					的情况下让软件运行下去
					</span>
					<button class='btn-link disableBtn' value='传入questionId' onClick='disableCommentForQuestion(this)'>删除</button>
					<button class='btn-link replyBtn' value='传入questionId' onClick='showReplyDiv(this)'>回复</button>
					<button class='btn-link detailsBtn' value='传入questionId' onClick='getReplysForComment(this)'>详情</button>
					<div class='replyCommnetDiv'><textarea></textarea>
						<br />
						<button class='btn btn-success replyCommentBtn' value='传入commentId' onClick='replyComment(this)'>回复</button>
						<button class='btn btn-warning cancelReplyComment' onclick='cancelReplyComment(this)'>取消</button>
					</div>
				</li>									
				<div class="replysForComment">
					<li>
						<span>水中水&nbsp;回复&nbsp;天外天：</span>
						<span>
							是的，我也觉得可以在软件没有修复所有bug的时候上线
						</span>
						<button class='btn-link disableBtn' value='传入replyId' onClick='disableReplyForReply(this)'>删除</button>
						<button class='btn-link replyBtn showReplyReplyBtn' value='传入replyId' onClick='showReplyDiv(this)'>回复</button>
						<div class='replyReplyDiv'><textarea></textarea>
							<br />
							<button class='btn btn-success replyReplyBtn' onClick='replyReply(this)'>回复</button>
							<button class='btn btn-warning cancelReplyReply' onclick='cancelReplyReply(this)'>取消</button>
						</div>
					</li>
				</div>										
			</ul>
		</li>									
	</ul>	
</section>
<link href="../css/questionDetails.css" rel="stylesheet" type="text/css">
<script src="../js/questionDetails.js"></script>