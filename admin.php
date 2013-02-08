<?php
define('IS_BACKEND',true);
define('DEBUG',0);
include 'inc/#inc.php';
if(empty($_SESSION['uid'])){
	if($a!='login' && $a!='logout'){
		jump('a=login');
	}elseif($a=='login'){
		login();
	}
}
$a=='index' && $a='list';
$tpl=$a;
$ajax=args('ajax',0);
switch($a){
	case 'list':
		if(empty($m)){ $m='content'; }
		$config->pagesize=20;
		
		if(!in_array($m,array('content','category','comment'))){ break; }
		$data=pagelist($m);
		break;
	
	case 'edit':
	case 'add':
		$tpl='edit';
		if(empty($m)){ break; }
		$pk=intval(args('pk',0));
		$then=args('then','');
		$rs=array(
			'content'=>array(
				'cid'=>0,
				'name'=>'',
				'title'=>'',
				'tag'=>'',
				'keywords'=>'',
				'description'=>'',
				'image'=>'',
				'view'=>0,
				'content'=>'',
			),
			'category'=>array(
				'name'=>'',
				'title'=>'',
				'keywords'=>'',
				'description'=>'',
				'image'=>'',
				'content'=>'',
				'ispage'=>0,
			),
			'comment'=>array(
				'nick'=>'',
				'content'=>'',
			),
		);
		$rs=$rs[$m];
		if(
			($m=='content' && args('title')) ||
			($m=='category' && args('title')) ||
			($m=='comment' && args('nick'))
		){
			$rs=array_intersect_key($_REQUEST,$rs);
			if(get_magic_quotes_gpc()){
				$rs=array_map('stripslashes',$rs);
			}
			if($pk){$rs['id']=$pk;}
			$num=save($a,$m,$rs);
			if($num>0){
				msg('操作完毕，影响了'.$num.'行','success');
			}else{
				msg('(⊙o⊙)哦， 数据库没变化？','info');
			}
			if(!$ajax && $a=='add'){
				jump('a=list&m='.$m);
			}
		}
		if($a=='edit'){
			
			if(!$pk){ break; }
			$rs=query('select * from {{'.$m.'}} where id='.$pk,'',2);
			if(empty($rs)){ break; }
		}else{
			$rs=(object)$rs;
		}
		$form=array(
			'content'=>array(
				'elements'=>array(
					'name=title&label=标题&class=span7',
					'name=name&label=别名&required',
					'name=cid&label=所属分类&type=select&items=cats',
					//'name=image&label=代表图片&type=file',
					'name=content&label=文章内容&type=wysiwyg',
					'name=description&label=描述&type=textarea&help=<meta name="description" value="..." />',
					//'name=tag&label=TAG标签',
					'name=view&label=浏览次数&class=span1',
					//'name=keywords&label=关键词&help=<meta name="keywords" value="..." />',
					
				),
			),
			'category'=>array(
				'elements'=>array(
					'name=title&label=分类名称',
					'name=name&label=别名',
					'name=keywords&label=关键词',
				),
			),
			'comment'=>array(
				'elements'=>array(
					'name=nick&label=昵称',
					'name=content&label=评论内容',
				),
			),
		);
		if(empty($form[$m])){ break; }
		$form=(object)$form[$m];
		if($a=='edit'){
			array_unshift($form->elements,'name=id&disabled=disabled&label=ID&class=span1');
		}
		array_walk($form->elements,'fixattr',$rs);
		break;
	case 'delete':
		if($_SESSION['uid']!='wxs77577'){
			break;
		}
		if(empty($m)){ break; }
		$pk=intval(args('pk',0));
		$sql='';
		switch($m){
			case 'comment':
				$sql='delete from {{comment}} where id='.$pk;
				break;
				
			case 'content':
				$sql='delete {{content}},{{comment}} from {{content}},{{comment}} where {{content}}.id={{comment}}.cid and {{content}}.id='.$pk;
				break;
				
			case 'category':
				$sql='delete {{category}},{{content}},{{comment}} from {{category}},{{content}},{{comment}} where {{category}}.id={{content}}.cid and {{content}}.id={{comment}}.cid and {{category}}.id='.$pk;
				break;
		}
		if(!empty($sql)){
			//$stat=query($sql);
		}
		jump('a=list&m='.$m);
		break;
		
	case 'login':
		$stat=login();
		if($stat){
			jump('a=list&m=content');
		}
		if(args('uid')){
			msg('不对吧？','error');
		}else{
			msg('你是管理员吗？','info');
		}
		break;
	
	case 'logout':
		logout();
		jump('a=login');
		break;
	
	case 'upload':
		
		break;
		
	default:
		
}
if($ajax){
	exit(json_encode(msg()));
}

if(!empty($tpl)){
	$view=VIEWS.'admin/'.$tpl.'.php';
	include VIEWS.'admin/layout.php';
}