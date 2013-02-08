<form id="main_form" method="post" enctype="multipart/form-data" class="form-horizontal well" onsubmit="return false;">
	<?php
	foreach($form->elements as $r){
	?>
	<div class="control-group">
		<?php
		switch($r->type){
			case 'checkbox':
		?>
			<div class="controls">
				<label class="checkbox">
					<input <?=fillattr($r)?> /><?=$r->label?>
					<span class="help-inline"><?=$r->help?></span>
				</label>
			</div>
		<?php
				break;
			default :
		?>
    <label class="control-label span1" for="<?=$r->id?>"><?=$r->label?></label>
    <div class="controls span11">
			<?php
			switch($r->type){
				case 'select':
			?>
			<select <?=fillattr($r,'value type items')?>>
				<option value="">选一个...</option>
				<?php  foreach(call_user_func($r->items) as $v){ ?>
				<option value="<?=$v->v?>" <?=$v->v==$r->value?'selected':'' ?>><?=$v->k?></option>
				<?php } ?>
			</select>
			<?php
					break;
				case 'wysiwyg':
					$r->class.='wysiwyg span12';
					$r->rows=25;
			?>
			<?=loadscript('xheditor/xheditor.js');?>
			<textarea <?=fillattr($r,'value type')?>><?=htmlentities($r->value,ENT_QUOTES,'utf-8')?></textarea>
			<?php
					break;
				case 'file':
					$r->style='display:none;';
			?>
			<label for="<?=$r->id?>" class="span2">
				<span class="btn btn-success fileinput-button">
					<i class="icon-upload icon-white"></i>
					<span>选择图片...</span>
				</span>
				<input <?=fillattr($r)?> />
			</label>
			
			<?php if(!empty($r->value)){ ?>
			<a href="#modalImage" role="button" class="btn" data-toggle="modal">预览</a>
			<div id="modalImage" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel"><?=$r->value?></h3>
				</div>
				<div class="modal-body">
					<p><img src="<?=$r->value?>" alt="<?=$r->value?>" /></p>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true">返回</button>
					<button class="btn btn-primary">删除图片</button>
				</div>
			</div>
			
			<?php } ?>
			
			
			<span class="help-inline"><?=$r->help?></span>
			
			<?php
					break;
				case 'textarea':
					$r->class='span8';
					$r->rows=3;
			?>
			<textarea <?=fillattr($r,'value type')?>><?=$r->value?></textarea>
			<div class="help-block"><?=$r->help?></div>
			<?php
					break;
				default:
			?>
      <input <?=fillattr($r)?>/>
			<span class="help-inline"><?=$r->help?></span>
			<?php } ?>
			
    </div>
		<?php } ?>
  </div>
	<?php } ?>
	<div class="center">
		<div class="btn-group">
			<?php if($a=='edit'){ ?>
			<a href="<?=url('a=delete','',1);?>" class="btn btn-danger"><i class="icon-white icon-remove"></i> 删除</a>
			<?php } ?>
			<button type="button" class="btn btn-primary submit"><i class="icon-white icon-ok"></i> 保存</button>
		</div>
	</div>
	<div id="ajax_message"></div>
	
	<input type="hidden" name="ajax" value="1" />
</form>