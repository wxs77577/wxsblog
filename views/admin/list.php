<?php $cols=0; ?>
<table class="table table-hover table-bordered table-condensed">
	<thead>
		<tr>
			<?php foreach($data->column as $r){ $col=explode('|',$r);$cols++;?>
			<th <?=!empty($col[2])?'class="'.$col[2].'"':''; ?>><?=$col[0]?></th>
			<?php } ?>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data->data as $row){ ?>
		<tr>
			<?php
			foreach($data->column as $r){
			$col=explode('|',$r);
			if(!isset($row->{$col[1]})){ $row->{$col[1]}=''; }
			if(strpos($col[0],'时间')!==false){
				$row->{$col[1]}=date($config->dateformat,$row->{$col[1]});
			}
			?>
			<td>
			<?php if($col[1]=='title'){ ?>
			<a href="<?=url('a=edit&m='.$m.'&pk='.$row->id)?>"><?=$row->{$col[1]}?></a>
			<?php }else{ ?>
			<?=$row->{$col[1]}?>
			<?php } ?>
			</td>
			<?php } ?>
			<td width="150" class="center">
				<a class="btn btn-mini btn-primary" href="<?=url('a=edit&m='.$m.'&pk='.current($row))?>"><i class="icon-edit icon-white"></i>编辑</a>
				<?php if(EN_DELETE){ ?>
				<a class="btn btn-mini btn-danger" href="<?=url('a=delete&m='.$m.'&pk='.current($row))?>"><i class="icon-remove icon-white"></i>删除</a>
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan="<?=$cols+1?>">
				<?php include VIEWS.'/pager.php';  ?>
			</td>
		</tr>
	</tfoot>
</table>