<div class="row-fluid" id="read-container">
  <div class="span12 well">
		<p class="alert alert-error">
			虽然我不知道您是怎么来到这里的，不过我还是要很抱歉地告诉您：这里没什么好玩的，您还是去别处转转吧。
		</p>
<pre class="prettyprint linenums alert alert-info" style="margin-left:0;">
&lt;?php
//返回404错误的PHP代码
header('HTTP/1.0 404 Not Found');
?&gt;
</pre>
	<div>
		<button class="btn btn-primary" onclick="history.go(-1);">返回</button>
		<a class="btn" href="<?=URL?>">首页</a>
	</div>
	</div>
</div>