<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ghost 快捷手册</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="./bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" type="text/css" href="css/handbook.css" />
		<script src="js/jquery-1.9.1.js"></script>
		<script src="./bootstrap/js/bootstrap.min.js"></script>
		<script src="js/loadHeaderFooter.js"></script>
		<script src="js/loadRightNav.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<header id="header">
				<?php include("View/header.php"); ?>
			</header>
		
			<div class="row-fluid mainContent">
				<div class="span12">
					<div class="row-fluid">
						<div class="span8" id="articleContent">
							<article class="post page">		
							    <header class="post-head">
							        <h1 class="post-title">Ghost 快捷手册</h1>
							    </header>
							
							    <section class="post-content">
							    	<table class="table">
							    		<tbody>
							    			<tr>
								    			<td>
							                    	<a href="http://www.ghostchina.com/download/">下载</a>
								                </td>
								            </tr>
								            <tr>
								                <td>安装指令</td>
								                <td>npm install --production</td>
								            </tr>
								            <tr>
								                <td>启动 Ghost</td>
								                <td>npm start</td>
								            </tr>
								            <tr>
								                <td>停止 Ghost</td>
								                <td>Ctrl+C</td>
								            </tr>
								        </tbody>
								    </table>
								</section>
									
								<hr class="contentHr">
								
								<section style="border-bottom: 1xp solid #ccc;margin-bottom: 1.8em;">  
								    <h2>文件路径</h2>
								    <table class="table">
								        <tbody>
								            <tr>
								                <td>配置文件</td>
								                <td>/config.js</td>
								            </tr>
								            <tr>
								                <td>主题</td>
								                <td>/content/themes</td>
								            </tr>
								            <tr>
								                <td>插件</td>
								                <td>/content/apps</td>
								            </tr>
								            <tr>
								                <td>图片</td>
								                <td>/content/images</td>
								            </tr>
								            <tr>
								                <td>导航（默认）</td>
								                <td>/core/server/helpers/tpl/navigation.hbs</td>
								            </tr>
								            <tr>
								                <td>分页（默认）</td>
								                <td>core/server/helpers/tpl/pagination.hbs</td>
								            </tr>
								        </tbody>
								    </table>
								</section>
									
								<hr class="contentHr">
								
								<section>  
								    <h2>
								        <a href="http://www.ghostchina.com/markdown-syntax/">MarkDown</a>/快捷键</h2>
								    <table class="table">
								        <tbody>
								            <tr>
								                <td>Save</td>
								                <td>-</td>
								                <td>Ctrl + S</td>
								            </tr>
								            <tr>
								                <td>Bold</td>
								                <td>**text**</td>
								                <td>Ctrl / Cmd + B</td>
								            </tr>
								            <tr>
								                <td>Emphasize</td>
								                <td>__text__</td>
								                <td>Ctrl / Cmd + I</td>
								            </tr>
								            <tr>
								                <td>Inline Code</td>
								                <td>`code`</td>
								                <td>Cmd + K / Ctrl + Shift + K</td>
								            </tr>
								            <tr>
								                <td>Link</td>
								                <td>[title](http://)</td>
								                <td>Ctrl + Shift + L</td>
								            </tr>
								            <tr>
								                <td>Image</td>
								                <td>![alt](http://)</td>
								                <td>Ctrl + Shift + I</td>
								            </tr>
								            <tr>
								                <td>List</td>
								                <td>* item</td>
								                <td>Ctrl + L</td>
								            </tr>
								            <tr>
								                <td>H1</td>
								                <td># Heading</td>
								                <td>Ctrl + Alt + 1</td>
								            </tr>
								            <tr>
								                <td>H2</td>
								                <td>## Heading</td>
								                <td>Ctrl + Alt + 2</td>
								            </tr>
								            <tr>
								                <td>H3</td>
								                <td>### Heading</td>
								                <td>Ctrl + Alt + 3</td>
								            </tr>
								            <tr>
								                <td>Select Word</td>
								                <td></td>
								                <td>Ctrl + Alt + W</td>
								            </tr>
								            <tr>
								                <td>Uppercase</td>
								                <td>-</td>
								                <td>Ctrl + U</td>
								            </tr>
								            <tr>
								                <td>Lowercase</td>
								                <td>-</td>
								                <td>Ctrl + Shift + U</td>
								            </tr>
								            <tr>
								                <td>Titlecase</td>
								                <td>-</td>
								                <td>Ctrl + Alt + Shift + U</td>
								            </tr>
								            <tr>
								                <td>Insert Current Date</td>
								                <td>-</td>
								                <td>Ctrl + Shift + 1</td>
								            </tr>
								        </tbody>
								    </table>
								</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>相关资源</h2>
									    <ul>
									        <li><a href="http://docs.ghostchina.com/zh/">Ghost 中文文档</a></li>
									        <li><a href="http://handlebarsjs.com/">Handlebars</a></li>
									        <li><a href="http://nodejs.org/">Node.js</a></li>
									        <li><a href="http://www.ghostchina.com/">Ghost 资料/教程</a></li>
									    </ul>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>Default.hbs</h2>
									    <em>default.hbs 文件中可以用到的 Handlebars 指令</em>
									    <h3>Head</h3>
									    <code>{{meta_title}}
									        <br>{{meta_description}}
									        <br>{{ghost_head}}
									        <br>
									    </code>
									    <h3>Body</h3>
									    <code>{{body_class}}
									        <br>{{{body}}}
									        <br>
									    </code>
									    <h3>Footer</h3>
									    <code>{{@blog.title}}
									        <br>{{@blog.url}}/rss/
									        <br>{{ghost_foot}}
									        <br>
									    </code>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>
									        <a href="http://docs.ghost.org/themes#file-structure">主题构成</a>
									    </h2>
									    <ul>
									        <li>/assets
									            <ul>
									                <li>/css
									                    <ul>
									                        <li>screen.css</li>
									                        <li>post.css</li>
									                    </ul>
									                </li>
									                <li>/fonts</li>
									                <li>/images</li>
									                <li>/js</li>
									                <li>/partials
									                    <ul>
									                        <li>pagination.hbs</li>
									                    </ul>
									                </li>
									            </ul>
									        </li>
									        <li>default.hbs</li>
									        <li>index.hbs [必须]</li>
									        <li>post.hbs [必须]</li>
									        <li>page.hbs [可选]</li>
									        <li>tag.hbs [可选]</li>
									        <li>package.json</li>
									    </ul>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>
									        <a href="http://handlebarsjs.com/">Handlebars</a>
									    </h2>
									    <h3>注释</h3>
									    <code>{{! 'A Comment' }}</code>
									    <h3>HTML 转义</h3>
									    <code>{{content}}</code>
									    <h3>if 指令</h3>
									    <code>{{#if author.website}}
									        <br>{{else}}
									        <br>{{/if}}</code>
									    <h3>unless 指令</h3>
									    <code>{{#unless author.website}}
									        <br>{{/unless}}</code>
									    <h3>foreach 指令</h3>
									    <code>{{#foreach posts}}
									    <br>{{/foreach}}</code>
									    <h3>块表达式</h3>
									    <code>{{#author}}
									    <br>{{/author}}</code>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>Index.hbs</h2>
									    <em>index.hbs 文件中可以使用的 Handlebars 指令</em>
									    <h3>加载父模板 default.hbs</h3>
									    <code>{{!&lt; default}}
									        <br>
									    </code>
									    <h3>Header</h3>
									    <code>{{#if @blog.cover}}
									        <br>{{@blog.cover}}
									        <br>{{/if}}
									        <br>
									        <br>{{#if @blog.logo}}
									        <br>{{@blog.logo}}
									        <br>{{/if}}
									        <br>{{@blog.title}}
									        <br>{{@blog.description}}</code>
									    <h3>文章</h3>
									    <code>{{#foreach posts}}
									        <br>{{/foreach}}
									        <br>{{post_class}}
									        <br>{{date format='YYYY-MM-DD'}}
									        <br>{{date published_at format="MMMM DD, YYYY"}}
									        <br>{{date published_at timeago="true"}}
									        <br>
									        <br>{{#if tags}}
									        <br>{{tags}}
									        <br>{{tags separator=" | "}}
									        <br>{{/if}}
									        <br>
									        <br>{{excerpt}}
									        <br>{{excerpt characters="140"}}
									        <br>{{content}}
									        <br>{{content words="100"}}
									        <br>
									    </code>
									    <h3>分页</h3>
									    <code>{{pagination}}</code>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>API 概览</h2>
									    <ol>
									        <li>@blog.title</li>
									        <li>@blog.url</li>
									        <li>@blog.logo</li>
									        <li>@blog.description</li>
									        <li>meta_title</li>
									        <li>meta_description</li>
									        <li>body</li>
									        <li>body_class</li>
									        <li>ghost_head</li>
									        <li>ghost_foot</li>
									        <li>pagination
									            <ul>
									                <li>next</li>
									                <li>page</li>
									                <li>pages</li>
									                <li>page_url prev</li>
									                <li>page_url next</li>
									                <li>prev</li>
									            </ul>
									        </li>
									        <li>post_class</li>
									        <li>post, posts</li>
									        <li>author
									            <ul>
									                <li>name</li>
									                <li>website</li>
									                <li>bio</li>
									                <li>cover</li>
									                <li>email</li>
									                <li>image</li>
									            </ul>
									        </li>
									        <li>excerpt [characters][words]</li>
									        <li>content [characters][words]</li>
									        <li>url [absolute]</li>
									        <li>tags [separator]
									            <ul>
									                <li>name</li>
									            </ul>
									        </li>
									        <li>date [format][timeago]</li>
									        <li>id</li>
									        <li>published_at</li>
									    </ol>
									</section>
									
									<hr class="contentHr">
									
									<section>  
									    <h2>Post.hbs</h2>
									    <em>post.hbs 文件中可以使用的 Handlebars 指令</em>
									    <h3>加载父模板 default.hbs</h3>
									    <code>{{!&lt; default}}
									        <br>
									    </code>
									    <h3>Header</h3>
									    <code>{{#if @blog.cover}}
									        <br>{{@blog.cover}}
									        <br>{{/if}}
									        <br>
									        <br>{{#if @blog.logo}}
									        <br>{{@blog.logo}}
									        <br>{{/if}}
									        <br>
									        <br>{{@blog.title}}
									        <br>{{@blog.description}}
									        <br>{{date published_at timeago="true"}}
									        <br>
									    </code>
									    <h3>文章</h3>
									    <code>{{post_class}}
									        <br>{{#if}}
									        <br>{{else}}
									        <br>{{/if}}
									        <br>
									        <br>{{#post}}
									        <br>{{/post}}
									        <br>{{url}}
									        <br>{{{title}}}
									        <br>{{date format='YYYY-MM-DD'}}
									        <br>{{date published_at format="MMMM DD, YYYY"}}
									        <br>{{#if tags}} {{tags}}
									        <br>{{tags separator=" | "}}
									        <br>{{/if}}
									        <br>{{content}}
									        <br>
									    </code>
									    <h3>作者信息</h3>
									    <code>{{#author}}
									        <br>{{/author}}
									        <br>
									        <br>{{#if author}}
									        <br>{{/if}}
									        <br>
									        <br>{{author.name}}
									        <br>{{author.bio}}
									        <br>{{author.email}
									        <br>{{author.website}}
									        <br>{{author.image}}
									        <br>{{author.cover}}
									        <br>
									    </code>
									</section>
								</section>		
							</article>
						</div>
						<div class="span4"  id="rightNav">
							<?php include("View/rightNav.php"); ?>
						</div>	
					</div>
				</div>
			</div>
			
			<footer id="footer">
				<?php include("View/footer.php"); ?>
			</footer>	
		</div>
	</body>
</html>
