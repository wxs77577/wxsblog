<?php if(DEBUG){ ?>
<div class="row-fluid">
	<div class="span12 well">
		<strong>调试信息</strong>
		<ol>
			<?php foreach($log as $r){ ?><li><?=$r?></li><?php } ?>
		</ol>
	</div>
</div>
<?php } ?>