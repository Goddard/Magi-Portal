	<div class="content">

		<div class="item">
			<h1>Post your comment!</h1>
			<form method="post" action="{ACTION}">
			<ul>
				<input type="hidden" name="referenceid" value="{REFERENCE_ID}" />
				
				<li>
					{MESSAGE}:* <br /><textarea rows="15" name="message" cols="75"></textarea><p class="instruct"><small>Say whats on your mind.  If you don't some one else will.  Please register so we know who is posting.</small></p>
					
				</li>
					{CAPTCHA_LINK}
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
