<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
<!--
body {
	font-size: 14px;
	color: #333;
	font-family: "微软雅黑";
	line-height: 150%;
}
-->
</style>
<script type="text/javascript">
var bigurl="image/1.jpg";
function autoSize(){
	location.href='download.php?bigurl='+bigurl+'&w='+screen.width+'&h='+screen.height+'&x=0&y=0&sw=450&sh=337.5&auto=true';
}
function download(){
	location.href='download.php?bigurl='+bigurl+'&save';
}
</script>
</head>

<body>
<table width="520" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#ccc">
  <tr>
    <td width="500" bgcolor="#fff"><img src="image/1.jpg" width="600" /> </td>
  </tr>
  <tr>
    <td align="center" bgcolor="#fff">1、<a href="javascript:autoSize();">符合我电脑屏幕的尺寸</a>，2、<a href="resize.php">手动裁切</a>，3、<a href="javascript:download()">下载壁纸原图</a></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#fff"><p><strong>说明：</strong></p>
    <p><strong>1、点击链接后，进入到壁纸自动裁切后的页面。类似：  </strong><a href="http://www.bzbuluo.cn/diywall.asp?k=1440&amp;g=900&amp;i=pic/201210505453611.jpg" target="_blank">http://www.bzbuluo.cn/diywall.asp?k=1440&amp;g=900&amp;i=pic/201210505453611.jpg</a> </p>
    <p>这个页面可以增加说明文字，广告什么的。</p>
    <p><strong>2、点击链接后，进入手动裁切页面。类似：</strong></p>
    <p> <a href="http://www.bzbuluo.cn/diys.asp?p=pic/201210505453611.jpg" target="_blank">http://www.bzbuluo.cn/diys.asp?p=pic/201210505453611.jpg</a> </p>
    <p>这个页面可以增加说明文字，广告什么的。</p>
    <p><strong>3、壁纸原链接，弹窗 图片另存为 对话框，方便菜鸟用户保存图片。</strong></p></td>
  </tr>
</table>
</body>
</html>
