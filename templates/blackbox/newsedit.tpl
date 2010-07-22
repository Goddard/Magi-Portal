	<div class="content">

		<div class="item">
			<h1>{NEWS_ADD_TITLE}</h1>
			<cite>{NEWS_ADD_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=newsedit">

			<ul><input type="hidden" name="newsid" value="{NEWS_EDIT_ID}"/>
				<li>
					{TITLE}:* <br /><input type="text" name="title" value="{NEWS_EDIT_TITLE}"/><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				</li>

				<li>
					{CATEGORY}:* <br /><select name="category">{NEWS_CATEGORIES}</select><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				</li>

				<li>
					{MESSAGE}:* <br /><textarea id="input" name="message" style="width:500px; height:200px;">{NEWS_EDIT_MESSAGE}</textarea>
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

				<li>
				     {ALLOW_COMMENT}:* <br /><input type="radio" name="commentable" value="1" {CHECKED_YES} /> Yes <input type="radio" name="commentable" value="0" {CHECKED_NO} /> No<p class="instruct"><small>If you share allow others to comment your script.</small></p></left>
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>