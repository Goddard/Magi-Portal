	<div class="content">

		<div class="item">
			<h1>{PAGE_ADD_TITLE}</h1>
			<cite>{PAGE_ADD_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=pageadd">

			<ul>
				<li>
					{FILE_NAME}:* <br /><input type="text" name="title" /><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				</li>

				<li>
					{PAGE_CONTENT}:* <br /><textarea id="message" rows="20" name="message" cols="75"></textarea><p class="instruct"> <small>Post your message here.</small></p>
					
				</li>

			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
