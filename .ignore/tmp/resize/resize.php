<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="utf-8" />
    <title> 壁纸自动处理diy工具 </title>
    
    <script type="text/javascript">
    var bigurl="image/1.jpg";
    </script>
    <link href="image/style.css" rel="stylesheet" type="text/css" />
	
  </head>
  <body>
    <table width="980" align="center">
      <tbody>
        <tr>
          <td>
						<a href="javascript:autoSize();"><b style="font-size:18px">自动裁剪为我的桌面尺寸</b></a>
						<br />
            <b>第1步 选择生成壁纸的尺寸 :</b><br />
			<a href="javascript:size(screen.width,screen.height);">适合您的电脑桌面壁纸</a>
			<br />
            <a href="javascript:size(320,480)">iphone</a> | <a href=
            "javascript:size(640,960)">iphone4</a> | <a href="javascript:size(480,720)">m8</a> |
            <a href="javascript:size(320,240)">黑莓</a> | <a href=
            "javascript:size(640,480)">google手机</a><br />
            <a href="javascript:size(1024,768)">apple ipad</a><br />
            <a href="javascript:size(480,272)">psp</a> | <a href=
            "javascript:size(92,92)">msn头像</a> | <a href="javascript:size(60,60)">qq头像</a>
            | <a href="javascript:size(300,300)">mp3封面</a><br />
            其他壁纸格式 : <select class="c1" onchange="gosj(this.value)">
              <optgroup label="其他格式壁纸">
                <option value="1024x768" selected="selected">1024x768 ipad</option>
                <option value="640x960">iphone 4</option>
                <option value="1024x600">上网本 1024x600</option>
                <option value="800x480">智器q5 800x480</option>
                <option value="640x480">android 640x480</option>
                <option value="640x960">iphone 640x960</option>
              </optgroup>
              <optgroup label="其他手机壁纸">
                <option value="240x240">240x240</option>
                <option value="240x400">240x400</option>
                <option value="240x260">240x260</option>
                <option value="352x416">352x416</option>
                <option value="480x272">480x272</option>
                <option value="240x160">240x160</option>
                <option value="128x128">128x128</option>
                <option value="132x176">132x176</option>
                <option value="320x240">320x240</option>
                <option value="320x480">320x480</option>
                <option value="480x720">魅族m8</option>
                <option value="160x128">160x128</option>
                <option value="208x208">208x208</option>
                <option value="128x160">128x160</option>
                <option value="240x320">240x320</option>
                <option value="176x192">176x192</option>
                <option value="220x176">220x176</option>
                <option value="176x208">176x208</option>
                <option value="240x300">240x300</option>
                <option value="176x220">176x220</option>
                <option value="120x160">120x160</option>
                <option value="480x320">480x320</option>
                <option value="480x360">480x360</option>
                <option value="640x360">640x360</option>
                <option value="360x640">360x640</option>
                <option value="320x533">320x533</option>
                <option value="480x800">480x800</option>
                <option value="345x800">345x800</option>
              </optgroup>
            </select><br />
          </td>
          <td width="500" align="middle" class=
          "c11">
            <b>第2步 移动红色框,选择裁剪位置 | 裁剪为: <span id=
            "newsize"></span></b><br />
            <br />
            <div id="bgDiv" style="WIDTH: 400px; HEIGHT: 400px">
			  <div id="dragDiv">
				<div id="rRightDown" style="RIGHT: 0px; BOTTOM: 0px"></div>
				<div id="rLeftDown" style="LEFT: 0px; BOTTOM: 0px"></div>
				<div id="rRightUp" style="RIGHT: 0px; TOP: 0px"></div>
				<div id="rLeftUp" style="LEFT: 0px; TOP: 0px"></div>
				<div id="rRight" style="RIGHT: 0px; TOP: 50%"></div>
				<div id="rLeft" style="LEFT: 0px; TOP: 50%"></div>
				<div id="rUp" style="LEFT: 50%; TOP: 0px"></div>
				<div id="rDown" style="LEFT: 50%; BOTTOM: 0px"></div>
			  </div>
			</div>
			<br />
          </td>
          <td>
            <form onsubmit="return crop()" action="download.php" method="post" target="_blank">
              <input id="leftpos" type="hidden" value="0" name="x" /> 
							<input id="toppos" type="hidden" value="0" name="y" /> 
							<input id="deskwidth" type="hidden" name="w" /> 
							<input id="deskheight" type="hidden" name="h" /> 
							<input id="smallwidth" type="hidden" name="sw" /> 
							<input id="smallheight" type="hidden"  name="sh" /> 
							<input id="bigurl" type="hidden" name="bigurl" /> 
							<b>第3步 :
              提交生成壁纸</b><br />
              <br />
              <input id="sbn" type="submit" value="请先执行第一步" />
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
  <script src="image/script.js" type="text/javascript"></script>
</html>
