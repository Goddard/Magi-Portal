	<div class="content">

		<div class="item">
		
			<h1>
			
			   {PM_SEND_TITLE}
			   
			</h1>
			
			<cite>
			
			   {PM_SEND_SUB_TITLE}
			   
			</cite>
			
			<form onsubmit="instance.post();" method="post" action="index.php?page=userpanel&user=sendmessage">

         <input type="hidden" name="replyid" value="{USERID}" />

			<ul>
			
				<li>
				
					{PM_SUBJECT}:* <br /><input type="text" name="subject" /><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				
				</li>

				<li>
				
					{PM_MESSAGE}:* <br /><textarea id="input" name="message" style="width:500px; height:200px;"></textarea>
					
<script type="text/javascript"> 
var instance = new TINY.editor.edit('editor',{
	id:'input',
	width:584,
	height:175,
	cssclass:'te',
	controlclass:'tecontrol',
	rowclass:'teheader',
	dividerclass:'tedivider',
	controls:['bold','italic','underline','strikethrough','|','subscript','superscript','|',
			  'orderedlist','unorderedlist','|','outdent','indent','|','leftalign',
			  'centeralign','rightalign','blockjustify','|','unformat','|','undo','redo','n',
			  'font','size','style','|','image','hr','link','unlink','|','cut','copy','paste','print'],
	footer:true,
	fonts:['Verdana','Arial','Georgia','Trebuchet MS'],
	xhtml:true,
	cssfile:'style.css',
	css:'body{background-color:#fff}',
	bodyid:'editor',
	footerclass:'tefooter',
	toggle:{text:'source',activetext:'wysiwyg',cssclass:'toggle'},
	resize:{cssclass:'resize'}
});
</script> 
				</li>

			</ul>
			
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			
			</form > 
			
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>