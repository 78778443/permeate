
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<script type="text/javascript" charset="utf-8" src="./ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="./ueditor/ueditor.all.js"></script>


<form action='doadd.php' method='post'>
	title:<input type='text' name='title' /><br />
	content:<textarea name='content' id='content'></textarea><br />
	<input type='submit' />
</form>


<script type="text/javascript">
	
		var a = UE.getEditor('content',{
            toolbars:[['bold', 'italic', 'underline', '|','fontsize', 'emotion', 'insertorderedlist', 'insertunorderedlist']],
            initialContent: '初始化内容',//初始化编辑器的内容
            initialFrameHeight: 200,
			autoClearinitialContent:true,
			fontsize:[10, 11, 12, 14, 16, 18, 20, 24, 36,360],
			emotionLocalization:true,
			listiconpath : URL+'themes/ueditor-list/'
        });
		
		//window.UEDITOR_CONFIG = {
		
			
			
		//}
	
</script>