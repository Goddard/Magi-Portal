	<div class="content">
		<div class="item">
			<h1>{LOGIN_FORM_TITLE}</h1>
			<cite>{LOGIN_MESSAGE}</cite>
			<form method="post" action="index.php?page=login">
			<ul>
				<li>
					{USERNAME}:* <br /><input type="text" name="name" /><p class="instruct"><small>{USERTIP}</small></p>
				</li>
				<li>
					{PASSWORD}:* <br /><input type="password" name="password" /><p class="instruct"><small>{PASSTIP}</small></p>
				</li>
				<li>
					{SPAM}:* <br /> {CAPTCHA_LINK} <br /><input name="number" type="text"><p class="instruct"> <small>{SPAMTIP}</small></p>
					
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>
		<span class="right"><small>{REQUIRED}</small></span>
	</div>