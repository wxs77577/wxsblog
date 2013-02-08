<?php
define('IS_BACKEND',false);
define('DEBUG',0);
include 'inc/#inc.php';

$tpl=$a;
$cname=args('cname','');
$name=args('name','');

//chkmobile();
$cats=pagelist('category','',10);
switch($a){
	case 'list':
		$data=pagelist('category',array('where'=>"name='$cname'"));
		$data=array_shift($data->data);
		empty($data) && http(404);
		++$data->view;
		save('edit','category','id='.$data->id.'&view='.$data->view);
		$page=$data;
		$page->keywords=$data->title;
		$data=pagelist('content',array('where'=>"b.name='$cname'"));
		break;
	
	case 'read':
		$data=pagelist('content',array('where'=>"a.name='$name' and b.name='$cname'"));
		$data=array_shift($data->data);
		empty($data) && http(404);
		if(isset($_POST['nick']) && isset($_POST['content'])){
			//发表评论
			$ret=array('err'=>'未知错误');
			$attr=array_merge($_POST,array(
				'cid'=>$data->id,
				'pubdate'=>time(),
			));
			$tooMuch=query('select count(1) from {{comment}} where content = :content or pubdate>:limitdate',array(
				'content'=>$attr['content'],
				'limitdate'=>strtotime('-7 seconds'),
			),1);
			if($tooMuch>0){
				$ret=array(
					'err'=>'Sorry，内容重复或是提交间隔时间太短，这有点不正常哦。',
				);
			}else{
				$attr['nick']=strip_tags($attr['nick']);
				$attr['content']=strip_tags($attr['content'],$config->allowtags);
				if(empty($attr['nick']) || empty($attr['content'])){
					$ret['err']='好像有点问题哦';
				}else{
					$stat=save('add','comment',$attr);
					if($stat){
						$ret=array(
							'nick'=>$attr['nick'],
							'content'=>$attr['content'],
							'pubdate'=>date($config->dateformat,$attr['pubdate']),
							'err'=>false,
						);
						setcookie('nick',$ret['nick'],strtotime('+1 week'));
					}else{
						$ret['err']='数据库写入错误';
					}
				}
			}
			$ret=json_encode($ret);
			exit($ret);
		}
		
		++$data->view;
		save('edit','content','id='.$data->id.'&view='.$data->view);
		$page=$data;
		$page->keywords=$data->title;
		break;
	case 'index':
	default:
		$data=pagelist('content');
		$page=array(
			'title'=>$config->sitename,
			'description'=>'代码之美，专注于打造最美的PHP',
			'keywords'=>'php,jQuery,css,html',
		);
		if(args('sitemap',false)!==false){
			$fp=fopen('sitemap.txt','w+b');
			$data=pagelist('content','',9999);
			$links=array_merge($data->data,$cats->data);
			$baseurl='http://'.HOST;
			foreach($links as $r){
				fputs($fp,$baseurl.$r->url.PHP_EOL);
			}
			fputs($fp,$baseurl.'/');
			fclose($fp);
			jump('','index.php');
		}
}
$page=(object)$page;
if(!empty($tpl)){
	$view=VIEWS.$tpl.'.php';
	include VIEWS.'layout.php';
}