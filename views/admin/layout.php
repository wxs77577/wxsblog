<!doctype html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8" />
	<title><?=$config->sitename?> | <?=$config->sitetitle?></title>
<?=combine(array(
	'bootstrap/css/bootstrap.min.css',
	'bootstrap/css/bootstrap-responsive.min.css',
	'sh/styles/shCore.css',
	'sh/styles/shCoreDefault.css',
	'common/css/style.css',
),'common/css/allin1_admin.css',0)?>

<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<?=combine(array(
	'common/js/jquery-1.8.3.min.js',
	'bootstrap/js/bootstrap.min.js',
	'sh/scripts/shCore.js',
	'sh/scripts/shAutoloader.js',
	'common/js/script.js',
),'common/js/allin1_admin.js',0)?>
</head>
<body>
	<div style="margin:8px;">
		<div class="row-fluid">
			<div class="span2 well" style="padding:8px 0px;">
				<?php $active='class="active"';?>
				<ul class="nav nav-list">
					<li><a href="<?=URL?>" target="_blank"><i class="icon-home"></i>网站首页</a></li>
					<li class="nav-header">文章管理</li>
					<li <?php ($a=='add' && $m=='content') && print($active); ?>>
						<a href="<?=url('a=add&m=content')?>"><i class="icon-file"></i>发表文章</a>
					</li>
					<li <?php ($a=='list' && $m=='content') && print($active); ?>>
						<a href="<?=url('a=list&m=content')?>"><i class="icon-list"></i>所有文章</a>
					</li>
					<li <?php ($a=='list' && $m=='comment') && print($active); ?>>
						<a href="<?=url('a=list&m=comment')?>"><i class="icon-list"></i>所有评论</a>
					</li>
					
					<div class="divider"></div>
					
					<li class="nav-header">分类管理</li>
					<li <?php ($a=='add' && $m=='category') && print($active); ?>>
						<a href="<?=url('a=add&m=category')?>"><i class="icon-file"></i>创建分类</a>
					</li>
					<li <?php ($a=='list' && $m=='category') && print($active); ?>>
						<a href="<?=url('a=list&m=category')?>"><i class="icon-list"></i>所有分类</a>
					</li>
					
					<div class="divider"></div>
					<li><a href="<?=url('a=logout&_rnd='.mt_rand())?>"><i class="icon-off"></i>退出</a></li>
					
				</ul>
			</div>
			<div class="span10">
				<?php foreach(msg() as $r){ ?>
				<div class="alert alert-<?=$r->type?>">
				<a class="close" data-dismiss="alert" href="#">&times;</a>
					<?=$r->text;?>
				</div>
				<?php } ?>
				<?php include $view ;?>
			</div>
		</div>
		
		
		<div class="row-fluid">
			<div class="span12 well center">
				Copyright &copy; 2012
			</div>
		</div>
		
		<?php include dirname(__FILE__).'/../debug.php'; ?>
		
	</div>
	
	<script type="text/javascript">
	var URL='<?=URL?>',MEDIA='<?=MEDIA?>',IS_BACKEND=<?=IS_BACKEND?'true':'false'?>;
	</script>
	
	
</body>
</html>