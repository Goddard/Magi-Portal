	<div class="content">

		<div class="item">
			<h1>{PAGE_EDIT_TITLE}</h1>
			<cite>{PAGE_EDIT_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=pageedit">

			<ul><input type="hidden" name="pagename" value="{PAGE_NAME}"/>

				<li>
					{PAGE_CONTENT_TITLE}:* <br /><textarea id="message" rows="40" name="message" cols="75">{PAGE_CONTENT}</textarea><p class="instruct"> <small>Post your message here.</small></p>
					
				</li>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
