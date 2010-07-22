	<div class="content">

		<div class="item">
			<h1>{NEWS_ADD_TITLE}</h1>
			<cite>{NEWS_ADD_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=newsadd">

			<ul>
				<li>
					{TITLE}:* <br /><input type="text" name="title" /><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				</li>

				<li>
					{CATEGORY}:* <br /><select name="category">{NEWS_CATEGORIES}</select><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				</li>

				<li>
					{MESSAGE}:* <br /><textarea id="message" rows="20" name="message" cols="75"></textarea><p class="instruct"> <small>Post your message here.</small></p>
					
				</li>

				<li>
				     {ALLOW_COMMENT}:* <br /><input type="radio" name="commentable" value="1" checked="checked" /> Yes <input type="radio" name="commentable" value="0" /> No<p class="instruct"><small>If you share allow others to comment your script.</small></p></left>
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
