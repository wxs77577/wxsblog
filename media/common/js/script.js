;(function($){
	$(function(){
		if(IS_BACKEND){
			initWYSIWYG();
			initMainForm('#main_form');
			
		}else{
			initLinks();
			initEM();
			initBackToTop();
			sh_autoload();
		}
	});
})(jQuery);

function initLinks(){
	$('#content a[target="_blank"]').addClass('link-ext');
}

function initEM(){
	$('#content img').each(function(){
		var $this=$(this);
		if($this.attr('src').indexOf('http://wxsblog.com/media/')<0){
			return;
		}
		
		$this.css({
			'border':'none',
			'box-shadow':'none' 
		});
	});
}

function initMainForm(selector){
	var $this=$(selector);
	$('.submit',$this).click(function(){
		$.post($this.attr('action'),$this.serializeArray(),function(data){
			var $html='';
			
			for(var k in data){
				$html +='<div class="alert alert-' + data[k].type + '">'+
					'<a class="close" data-dismiss="alert" href="#">&times;</a>'+data[k].text+
				'</div>';
			}
			$('#ajax_message').html($html);
		},'json');
	});
}

function postComment(form){
	$(':input',form).each(function(i){
		if($(this).attr('required')){
			if($(this).val().length<1){
				$(this).select();
				return false;
			}
		}
	});
	var $info=$('#form_info');
	$.post(location.href,$(form).serialize(),function(data){
		if(!data.err){
			$info.html('<i class="icon-heart"></i> 谢谢，我收到了。');
			form.reset();
			
			$('#comment_list')
				.prepend('<dt>'+data.nick+'@'+data.pubdate+'：</dt><dd>'+data.content+'</dd>')
				.prev().text('他们说');
		}else{
			$info.html('<i class="icon-exclamation-sign"></i> '+data.err);
		}
	},'json');
	return false;
}

function initBackToTop(){
	$('#backtotop').click(function(){
		var int=setInterval(function(){
			$(window).scrollTop($(window).scrollTop()*0.9);
			if($(window).scrollTop()<=0){
				clearInterval(int);
			}
		},15);
	});
}

function initWYSIWYG(){
	window.editor=$('textarea.wysiwyg').xheditor({
		skin:'nostyle', 
		plugins:{
			SyntaxHighLighter:{c:'btnCode',t:'插入高亮代码块(pre标签)',h:1,s:'alt+s',e:function(){
				var _this=this;
				var htmlCode='<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="js">Javascript/jQuery</option><option value="css">CSS</option><option value="php">PHP</option><option value="java">Java</option><option value="py">Python</option><option value="pl">Perl</option><option value="rb">Ruby</option><option value="cs">C#</option><option value="c">C++/C</option><option value="vb">VB/ASP</option><option value="">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';			
				var jCode=$(htmlCode),jType=$('#xheCodeType',jCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
				jSave.click(function(){
					_this.loadBookmark();
					_this.pasteHTML('<pre class="brush:'+jType.val()+'">'+_this.domEncode(jValue.val())+'</pre>');
					_this.hidePanel();
					return false;	
				});
				_this.saveBookmark();
				_this.showDialog(jCode);
			}},
			Code:{c:'btnCode',t:'转为代码(code标签)',h:1,s:'alt+c',e:function(){
				if(this.getSelect().length<1){return false;}
				this.pasteHTML('<code>'+this.getSelect()+'</code>');
			}},
			Blockquote:{c:'btnCode',t:'添加引用',h:1,s:'alt-q',e:function(){
				var _this=this;
				var htmlCode='<div>来源： <input type="text" id="quoteSouce" /><div><textarea id="quoteValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="quoteSave" value="确定" /></div>';
				var jCode=$(htmlCode),jSource=$('#quoteSouce',jCode),jValue=$('#quoteValue',jCode),jSave=$('#quoteSave',jCode);
				jSave.click(function(){
					_this.loadBookmark();
					_this.pasteHTML('<blockquote><p>'+_this.domEncode(jValue.val())+'</p><small>'+_this.domEncode(jSource.val())+'</small></blockquote>');
					_this.hidePanel();
					return false;
				});
				_this.saveBookmark();
				_this.showDialog(jCode);
			}}
		},
		localUrlTest:/^http:\/\/(wxsblog\.com)\//i,
		urlBase:URL,
		urlType:'abs',
		remoteImgSaveUrl:URL+'saveremoteimg.php',
		tools:'full'
	});
	editor.addShortcuts('alt+h',function(){
		editor.toggleSource();
	});
}

function sh_autoload(){
	SyntaxHighlighter.autoloader.apply(null, sh_path(
		'applescript					 @shBrushAppleScript.js',
		'actionscript3 as3		 @shBrushAS3.js',
		'bash shell						 @shBrushBash.js',
		'coldfusion cf				 @shBrushColdFusion.js',
		'cpp c								 @shBrushCpp.js',
		'c# c-sharp csharp		 @shBrushCSharp.js',
		'css									 @shBrushCss.js',
		'delphi pascal				 @shBrushDelphi.js',
		'diff patch pas				 @shBrushDiff.js',
		'erl erlang						 @shBrushErlang.js',
		'groovy								 @shBrushGroovy.js',
		'java									 @shBrushJava.js',
		'jfx javafx						 @shBrushJavaFX.js',
		'js jscript javascript @shBrushJScript.js',
		'perl pl							 @shBrushPerl.js',
		'php									 @shBrushPhp.js',
		'text plain						 @shBrushPlain.js',
		'py python						 @shBrushPython.js',
		'ruby rails ror rb		 @shBrushRuby.js',
		'sass scss						 @shBrushSass.js',
		'scala								 @shBrushScala.js',
		'sql									 @shBrushSql.js',
		'vb vbnet							 @shBrushVb.js',
		'xml xhtml xslt html	 @shBrushXml.js'
	));
	SyntaxHighlighter.all();
}

function sh_path(){
	var args = arguments,result = [];
	for(var i = 0; i < args.length; i++){
		result.push(args[i].replace('@', MEDIA+'sh/scripts/'));
	}
	return result;
};