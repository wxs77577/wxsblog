<div class="row-fluid list-container">
  <?php foreach($data->data as $k=>$r){ ?>
	<a href="<?=$r->url?>" class="span3" title="<?=$r->title?>">
	<div class="span12 well well-small">
		<blockquote class="list-item">
			<p>
				<span class="label label-success"><?=$r->ctitle?></span>
				<?=left($r->description,65)?> <span class="label"><?=$r->view?></span>
			</p>
			<small> <?=$r->title?> </small>
		</blockquote>
  </div>
	</a>
	<?php if(($k+1)%4==0){?>
	</div>
	<div class="row-fluid list-container">
  <?php } ?>
  <?php } ?>
	<?php $a=='list' && include VIEWS.'/pager.php';  ?>
</div>