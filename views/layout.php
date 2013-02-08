<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<title><?=$page->title?> - <?=$a!='index'?$config->sitename:$config->sitetitle?></title>
	<meta name="description" content="<?=$page->description?>" />
	<meta name="keywords" content="<?=$page->keywords?>" />
	<meta name="baidu-site-verification" content="FeXrz908uultxgtl" />
	<meta property="qc:admins" content="731756710324776375" />
	<meta property="wb:webmaster" content="02136de52adf7c42" />
	<link rel="shortcut icon" href="<?=URL?>favicon.ico" />
	<?=combine(array(
		'bootstrap/css/bootstrap.min.css',
		'bootstrap/css/bootstrap-responsive.min.css',
		'sh/styles/shCore.css',
		'sh/styles/shThemeDefault.css',
		'common/css/style.css',
	),'common/css/allin1.css',1)?>
</head>
<body>
	<div class="container">
		<div class="row-fluid">
			<div class="span12">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="<?=URL?>">
						<?=$config->sitename?>
						</a>
						<ul class="nav">
							<?php
							foreach($cats->data as $r){
							?>
							<li <?=$cname==$r->name?'class="active"':''?>>
								<a href="<?=$r->url?>"><?=$r->title?>
								<span class="label label-info"><?=$r->view?></span>
								</a>
							</li>
							<?php } ?>
						</ul>
						<ul class="nav pull-right">
							<li><a href="<?=url('a=login',URL.'admin.php')?>" rel="nofollow">管理</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<?php include $view ;?>
		
		<div class="row-fluid">
			<div class="span12 well center">
				<p class="text-success">
					<?php
					$links=array(
						'PHP'=>'http://www.php.net/',
						'jQuery'=>'http://jquery.com/',
						'Bootstrap'=>'http://twitter.github.com/bootstrap/',
						'SyntaxHighlighter'=>'http://alexgorbatchev.com/SyntaxHighlighter/',
						'xhEditor'=>'http://xheditor.com/',
						'W3C'=>'http://www.w3.org/',
						'Chrome'=>'http://www.google.cn/intl/zh-CN/chrome/browser/',
						'Notepad++'=>'http://notepad-plus-plus.org/',
					);
					?>
					特别感谢：
					<?php foreach($links as $k=>$v){ ?>
					<a href="<?=$v?>" target="_blank"><?=$k?></a> 
					<?php } ?>
				</p>
				Copyright &copy; 2012 代码之美
				<script src="http://s19.cnzz.com/stat.php?id=4872656&amp;web_id=4872656" type="text/javascript"></script>
				<a href="https://github.com/wxs77577/wxsblog" target="_blank">本站完整源码已经落户GitHub啦</a>
				<!--
				<a href="http://www.scanv.com" id="scanv_verify_link" vm="1" vs="80x30">互联网安全</a>
				<script src="http://static.scanv.com/static/js/scanv_verify.js" scanv_id="50fcad12a61d433d646cbb77" charset="utf-8" type="text/javascript"></script>
				-->
				<br />
				<button id="backtotop" class="btn btn-primary"><i class="icon-white icon-arrow-up"></i>回到顶部</button>
			</div>
		</div>
		
		<?php include 'debug.php'; ?>
		
	</div>
	
	<script type="text/javascript">
	var URL='<?=URL?>',MEDIA='<?=MEDIA?>',IS_BACKEND=<?=IS_BACKEND?'true':'false'?>;
	</script>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?=combine(array(
		'common/js/jquery-1.8.3.min.js',
		'bootstrap/js/bootstrap.min.js',
		'sh/scripts/shCore.js',
		'sh/scripts/shAutoloader.js',
		'common/js/script.js',
	),'common/js/allin1.js',1)?>
	
	<?php if($a=='read'){ ?>
		<!-- Baidu Button BEGIN -->
		<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=671707" ></script>
		<script type="text/javascript" id="bdshell_js"></script>
		<script type="text/javascript">
		document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
		</script>
		<!-- Baidu Button END -->
	<?php } ?>
	
</body>
</html>