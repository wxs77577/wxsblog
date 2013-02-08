<?php
$pager=$data->pager;
if($pager->totalpage>0){
?>
<div class="pagination pagination-centered clear">
	<ul>
		<li class="<?=$page==1?'disabled':''?>"><a href="<?=$page==1?'javascript:void(0);':url('page=1','',true)?>">&laquo;&laquo;</a></li>
		<li class="<?=$page==1?'disabled':''?>"><a href="<?=$page==1?'javascript:void(0);':url('page='.($page-1),'',true)?>">&laquo;</a></li>
		<?php 
			for($p=$pager->page-$pager->offset;$p<=$pager->page+$pager->offset;$p++){
				if($p<1||$p>$pager->totalpage){ continue; } 
		?>
		<li class="<?=$page==$p?'active':''?>"><a href="<?=$page==$p?'javascript:void(0);':url('page='.$p,'',true)?>"><?=$p?></a></li>
		<?php } ?>
		<li class="<?=$page==$pager->totalpage?'disabled':''?>"><a href="<?=$page==$pager->totalpage?'javascript:void(0);':url('page='.($page+1),'',true)?>">&raquo;</a></li>
		<li class="<?=$page==$pager->totalpage?'disabled':''?>"><a href="<?=$page==$pager->totalpage?'javascript:void(0);':url('page='.$pager->totalpage,'',true)?>">&raquo;&raquo;</a></li>
		
	</ul>
</div>
<?php }else{ ?>
<div class="center">暂无内容</div>
<?php } ?>