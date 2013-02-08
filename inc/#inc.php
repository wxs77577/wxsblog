<?php
defined('IS_BACKEND') or die('<h5>不要直接访问我哈</h5>');
session_start();
mb_internal_encoding('utf-8');
date_default_timezone_set('Asia/Shanghai');
define('PATH',rtrim(realpath(dirname(__FILE__).'/../'),'\\\/').'/');
define('URL',rtrim(dirname($_SERVER['SCRIPT_NAME']),'\\\/').'/');
define('MEDIA',URL.'media/');
define('PATH_MEDIA',PATH.'media/');
define('VIEWS',PATH.'views/');
define('UPLOAD',URL.'upload/');
define('PREFIX','tb_');
define('HOST','wxsblog.com');
define('HOST_LOC','wxsblog.loc');
define('HOST_MOBILE','m.wxsblog.com');
define('EN_DELETE',0);

$config=(object)array(
	'sitename'=>'代码之美',
	'sitetitle'=>'爱美，是每一位程序员的天性',
	'pagesize'=>20,
	'pageoffset'=>7,
	'allowtags'=>'<b><i><u><code>',
	'dateformat'=>'Y-m-d',
);

if($_SERVER['HTTP_HOST']===HOST){
	$db=new PDO('mysql:host=localhost;dbname=uu145635','uu145635','jtrWhkfU');
}elseif($_SERVER['HTTP_HOST']!==HOST_LOC){
	http(301,'http://'.HOST.$_SERVER['REQUEST_URI']);
}else{
	$db=new PDO('mysql:host=localhost;dbname=blog','root','');
}
query('set names utf8');
$log=array();
!isset($_SESSION['msg']) && $_SESSION['msg']=array();
$a=args('a','index');
$m=args('m','');
$page=args('page',1);


//$type	0=rowCount,1=fetchColumn,2=fetch,3=fetchAll
function query($sql,$params=array(),$type=3){
	$timer=microtime(1);
	global $db,$log;
	$ret=null;
	if(is_array($sql)){
		$schema=$sql;
		$sql='';
		foreach($schema as $k=>$v){
			if(!in_array($k,explode('|','select|from|where|order by|limit'))){ continue; }
			!empty($v) && $sql.=$k.' '.$v.' ';
		}
	}
	if(strpos($sql,'{{')!==false){
		$sql=preg_replace('/\{\{(\w+)\}\}/i',PREFIX.'$1',$sql);
	}
	if(empty($params)){ $params=array(); }
	$type=intval($type);
	$ps=$db->prepare($sql);
	
	$ps->execute($params);
	switch($type){
		case 0:$ret=$ps->rowCount();break;
		case 1:$ret=$ps->fetchColumn();break;
		case 2:$ret=$ps->fetch(PDO::FETCH_OBJ);break;
		case 3:$ret=$ps->fetchAll(PDO::FETCH_OBJ);break;
	}
	$timer=sprintf('%.3fms',(microtime(1)-$timer)*1000);
	
	$log[]=$timer." \t".$sql;
	$error=$ps->errorInfo();
	//msg($sql,'info');
	if(!empty($error[1])){
		$log[]='Error '.$error[1].' : '.$error[2].'<br />SQL : '.$sql.'<br />参数 : <pre class="well">'.print_r($params,1).'</pre>';
		msg(end($log),'error');
	}
	return $ret;
}

function args($var,$val=null){
	return isset($_REQUEST[$var])?$_REQUEST[$var]:$val;
}

function url($param='',$uri='',$merge=false){
	$url='';
	if(!is_array($param)){
		parse_str($param,$newParam);
		$param=$newParam;
	}
	if($merge){
		parse_str($_SERVER['QUERY_STRING'],$oldParam);
		$param=array_merge($oldParam,$param);
	}
	extract($param);
	if(IS_BACKEND){
		empty($uri) && $uri=$_SERVER['REQUEST_URI'];
		is_array($param) && $param=http_build_query($param);
		$url=current(explode('?',$uri)).(!empty($param)?'?'.$param:'');
	}else{
		$rurl='';
		switch($a){
			case 'list':
				$rurl="$cname";
				!empty($page) && $rurl.="-$page";
				$rurl.='/';
				break;
			case 'read':
				$rurl="$cname/$name";
				break;
			default:
				;
		}
		empty($uri) && $uri=URL;
		$url=$uri.$rurl;
	}
	return $url;
}

function jump($params='',$uri='',$merge=false,$halt=true){
	//echo '<meta http-equiv="refresh" content="0;url='.url($params,$uri).'" />';
	header('Location:'.url($params,$uri));
	if($halt){exit;}
}

function fixattr(&$element,$key,$rs){
	if(!is_object($element)){
		parse_str($element,$arr);
		$element=(object)$arr;
	}
	$ret=array();
	!isset($element->id) && $element->id='element_'.$element->name;
	!isset($element->label) && $element->label=ucwords($element->name);
	!isset($element->help) && $element->help='';
	!isset($element->type) && $element->type='text';
	!isset($element->value) && $element->value=$rs->{$element->name};
	$element->help=htmlentities($element->help,ENT_QUOTES,'utf-8');
	return $element;
}

function fillattr($element,$exclude=''){
	if(!is_array($exclude)){ $exclude=explode(' ',$exclude); }
	$exclude=array_merge(array('help','options','label'),$exclude);
	foreach($element as $k=>$v){
		if(in_array($k,$exclude)){ continue; }
		$ret[]=$k.'="'.$v.'"';
	}
	return implode(' ',$ret);
}

function save($a,$tb,$attr=array()){
	str2array($attr);
	$sql='';
	switch($a){
		case 'add':
		case 'insert':
			if(isset($attr['id'])){ unset($attr['id']); };
			$sql='insert into {{'.$tb.'}} ';
			$keys=implode(',',array_keys($attr));
			$values=implode(',',array_map(create_function('$k','return ":".$k;'),array_keys($attr)));
			$sql.="($keys)values($values)";
			break;
			
		case 'edit':
		case 'update':
			$sql='update {{'.$tb.'}} set ';
			$arr=$attr;
			if(isset($arr['id'])){ unset($arr['id']); };
			array_walk($arr,create_function('&$v,$k','$v=$k."=:".$k;'));
			$sql.=implode(',',$arr);
			$sql.=' where id=:id';
			break;
			
	}
	$num=query($sql,$attr,0);
	return $num;
}

function str2array(&$str=''){
	if(is_array($str)){ return ;}
	$arr=array();
	parse_str($str,$arr);
	$str=$arr;
}

function msg($text='',$type='info'){
	if(!empty($text)){
		$_SESSION['msg'][]=(object)compact('type','text');
	}else{
		$msg=$_SESSION['msg'];
		$_SESSION['msg']=array();
		return $msg;
	}
}

function cats(){
	return query('select id as v,title as k from {{category}}');
}

function loadscript($file,$echo=false){
	$ret='';
	if(is_array($file)){
		foreach($file as $r){
			$ret.=loadscript($r);
		}
	}else{
		$ext=pathinfo($file,PATHINFO_EXTENSION);
		$url=MEDIA.$file;
		switch($ext){
			case 'css':$ret.='<link rel="stylesheet" type="text/css" href="'.$url.'" />';break;
			case 'js':$ret.='<script type="text/javascript" src="'.$url.'"></script>';break;
		}
		$ret.=PHP_EOL;
	}
	if($echo){ echo $ret; }
	return $ret;
}

function combine($files=array(),$to='common/css/allin1.css',$update=false){
	if(!$update && file_exists(PATH_MEDIA.$to)){
		return loadscript($to);
	}
	$cont='';
	$ext=pathinfo($to,PATHINFO_EXTENSION);
	if($ext=='css'){
		$cont.='@charset "UTF-8";';
	}
	foreach($files as $file){
		$cont.=PHP_EOL.file_get_contents(PATH_MEDIA.$file).($ext=='js'?';':'');
	}
	file_put_contents(PATH_MEDIA.$to,$cont);
	return loadscript($to);
}

function autocombine($files=array(),$update=false){
	$script=array(
		'css'=>'common/css/allin1.css',
		'js'=>'common/js/allin1.js',
	);
	if(!$update &&
	file_exists(PATH_MEDIA.$script['css']) &&
	file_exists(PATH_MEDIA.$script['js'])){
		return loadscript($script);
	}
	$fp=array();
	$fp['css']=fopen(PATH_MEDIA.$script['css'],'wb');
	$fp['js']=fopen(PATH_MEDIA.$script['js'],'wb');
	foreach($files as $file){
		$ext=pathinfo($file,PATHINFO_EXTENSION);
		if(isset($fp[$ext])){
			fputs($fp[$ext],PHP_EOL.file_get_contents(PATH_MEDIA.$file));
		}
	}
	fclose($fp['css']);
	fclose($fp['js']);
	return loadscript($script);
}

function fix(&$r,$k,$m='content'){
	switch($m){
		case 'content':
			$r->url=url('a=read&cname='.$r->cname.'&name='.$r->name);
			if(isset($r->description) && empty($r->description) && !empty($r->content)){
				$r->description=left($r->content,70);
			}
			break;
			
		case 'category':
			$r->url=url('a=list&cname='.$r->name);
			break;
	}
}

function pagelist($m='content',$criteria=array(),$pagesize=''){
	global $config;
	$default=array(
		'content'=>array(
			'select'=>'a.*,b.title as ctitle,b.name as cname',
			'from'=>'{{'.$m.'}} as a left join {{category}} as b on a.cid=b.id',
			'where'=>'',
			'order by'=>'a.id desc',
			'column'=>array('ID|id|span1','所属分类|ctitle','标题|title','别名|name'),
		),
		'category'=>array(
			'select'=>'id,title,name,keywords,description,ispage,content,view',
			'from'=>'{{'.$m.'}}',
			'where'=>'',
			'order by'=>'',
			'column'=>array('ID|id|span1','分类名称|title','别名|name'),
		),
		'comment'=>array(
			'select'=>'a.id,a.nick,a.content,a.pubdate,b.title,b.id as cid',
			'from'=>'{{'.$m.'}} as a left join {{content}} as b on a.cid=b.id',
			'where'=>'',
			'order by'=>'a.pubdate desc',
			'column'=>array('ID|id|span1','文章标题|title','昵称|nick','内容|content','发布时间|pubdate'),
		),
	);
	empty($criteria) && $criteria=array();
	$sql=array_merge($default[$m],$criteria);
	$csql=$sql;
	$csql['select']='count(1)';
	$csql['order by']=$csql['limit']='';
	$total=query($csql,'',1);
	empty($pagesize) && $pagesize=$config->pagesize;
	$totalpage=ceil($total/$pagesize);
	$page=max(1,min(max(1,args('page',1)),$totalpage));//current page
	$limit=(($page-1)*intval($pagesize)).','.intval($pagesize);
	$sql['limit']=$limit;
	$rs=query($sql);
	array_walk($rs,'fix',$m);
	$ret=(object)array(
		'column'=>$sql['column'],
		'data'=>$rs,
		'pager'=>(object)array(
			'total'=>$total,
			'page'=>$page,
			'pagesize'=>$pagesize,
			'totalpage'=>$totalpage,
			'offset'=>$config->pageoffset,
		),
	);
	return $ret;
}

function http($code=404,$jump=''){
	$code=strval($code);
	
	$headers=array(
		'404'=>'Not Found',
		'301'=>'Moved Permanently',
	);
	$header='HTTP/1.0 '.$code;
	if(isset($errors[$code])){
		$header.=' '.$errors[$code];
	}
	header($header);
	$view=VIEWS.$code.'.php';
	if(file_exists($view)){
		global $config,$cname,$pk,$log;
		include VIEWS.'layout.php';
	}
	if(!empty($jump)){
		header('Location:'.$jump);
	}
	exit;
}

function face($type='lauth',$echo=true){
	
}

function left($str,$len=30,$fix='...'){
	$str=strip_tags($str);
	$strlen=mb_strlen($str);
	return mb_substr($str,0,$len).($strlen<=$len?'':$fix);
}

function chkmobile(){
	preg_match('/(iPhone|iPod|Android|ios|iPad)/i',$_SERVER['HTTP_USER_AGENT'],$match);
	$match=array_pop($match);
	if(!empty($match)){
		http('301','','http://'.HOST_MOBILE.'/');
	}
}

function login(){
	$ret=false;
	$uid=args('uid',isset($_COOKIE['uid'])?$_COOKIE['uid']:'');
	$pwd=args('pwd','');
	if(!empty($pwd)){
		$pwd=md5($pwd);
	}elseif(isset($_COOKIE['pwd'])){
		$pwd=$_COOKIE['pwd'];
	}
	$remember=args('remember');
	if(($uid==='admin' || $uid==='wxs77577') && $pwd==='9e65894f01c477528b4f6b3e0999cefa'){
		$_SESSION['uid']=$uid;
		if($remember){
			setcookie('uid',$uid,strtotime('+7 day'));
			setcookie('pwd',$pwd,strtotime('+7 day'));
		}
		$ret=true;
	}
	return $ret;
}

function logout(){
	unset($_SESSION['uid']);
	setcookie('uid','false',-99999);
	setcookie('pwd','false',-99999);
}

function islogin(){
	return strlen($_SESSION['uid'])>3;
}

