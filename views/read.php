<div class="row-fluid" id="read-container">
  <div class="well bg-white step step-first">
		<h1 class="center">
			<small><?=$data->title?>
				<sup><span class="badge badge-info views"><?=$data->view?></span></sup>
			</small>
		</h1>
		<blockquote>
			<p><?=$data->description?></p>
		</blockquote>
	</div>
	
	<div id="content" class="well step bg-white" style="width:95%">
		<?=$data->content?>
		
		<?php
			$list=pagelist('content',array(
				'where'=>'cid='.$data->cid.' and a.id <> '.$data->id,
			),10);
			if(!empty($list->data)){
		?>
		<dl>
			<dt>本类目下推荐文章</dt>
			<?php
				
				foreach($list->data as $r){
			?>
			<dd><a href="<?=$r->url?>"><?=$r->title?></a></dd>
			<?php } ?>
		</dl>
		<?php }	?>
	</div>

	<div class="well step bg-white" style="width:93%">
		<?php $comments=pagelist('comment',array('where'=>'a.cid='.$data->id),20); ?>
		<fieldset>
			<legend><?=!empty($comments->data)?'他们说':'赶紧抢沙发'?></legend>
			<dl id="comment_list">
				<?php foreach($comments->data as $r){ ?>
				<dt><?=strip_tags($r->nick)?>@<?=date($config->dateformat,$r->pubdate)?></dt>
				<dd><?=strip_tags($r->content,$config->allowtags)?></dd>
				<?php } ?>
			</dl>
		</fieldset>
	</div>

	<div class="well step bg-white"  style="width:90%;margin-bottom:20px">
		<form class="" method="post" onsubmit="return postComment(this);">
			<fieldset>
				<legend>有点想法？</legend>
				<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare clear">
					<a class="bds_tsina">新浪微博</a>
					<a class="bds_tqq">腾讯微博</a>
					<a class="bds_hi">百度空间</a>
					<a class="bds_bdhome">百度新首页</a>
					<span class="bds_more">更多</span>
				</div>
				<div class="clear"></div>
				<input type="text" name="nick" id="element_nick" class="span2" required placeholder="江湖名号" value="<?=!empty($_COOKIE['nick'])?$_COOKIE['nick']:''?>"/>
				<br />
				<textarea name="content" id="element_content" class="span5" rows="3" required placeholder="我想说。。。"></textarea>
				<div class="clear"></div>
				<button type="submit" class="btn btn-primary"><i class="icon-glass icon-white"></i> 发表我的看法</button>
				<span class="help-inline" id="form_info">非常感谢。</span>
			</fieldset>
		</form>
	</div>
	
</div>