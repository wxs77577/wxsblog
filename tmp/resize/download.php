<?php



//$middle只在自动截取时起作用
$middle=1; //1为垂直居中截取，0为从左上角开始截取。
empty($_REQUEST['bigurl']) && exit;
extract($_REQUEST);

//保存图片操作
if(isset($save)){
	header('Content-type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$bigurl);
	exit;
}

list($width,$height,$type)=getimagesize($bigurl);
$im_raw=imagecreatefromjpeg($bigurl);
$im_out=imagecreatetruecolor($w,$h);

$auto=isset($auto);

if((!$auto && $y==0) || ($auto && $w/$width<$h/$height)){
	$rate=$h/$height;
	$src_x=($x/$sw)*$width;
	$src_y=$y;
	$src_w=$w/$rate;
	$src_h=$height;
}elseif((!$auto && $x==0) || ($auto && $w/$width>=$h/$height)){
	$rate=$w/$width;
	$src_x=$x;
	$src_y=($y/$sh)*$height;
	$src_w=$width;
	$src_h=$h/$rate;
}
if($auto && $middle){
	if($w/$width != $h/$height){
		$src_y=($height-$h)/2;
	}
}else{
	$src_y=0;
}
imagecopyresized($im_out,$im_raw,0,0,$src_x,$src_y,$w,$h,$src_w,$src_h);
ob_start();
imagejpeg($im_out,'',100);
$cont=ob_get_clean();
$data=base64_encode($cont);
?>
<h3>右键点击图片->另存为</h3>
<img src="data:image/jpeg;base64,<?=$data?>" alt="" width="50%" />