	<div class="content">
		<div class="item">
			<h1>{BANNED_ADD_TITLE}</h1>
			<cite>{BANNED_ADD_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=banadd">
			<ul>
				<li>
					{BANNED_IP_LABEL}:* <br /><input type="text" name="ip" /><p class="instruct"><small>{USERTIP}</small></p>
				</li>
				<li>
					{BANNED_EMAIL_LABEL}: <br /><input type="text" name="email" /><p class="instruct"><small>{PASSTIP}</small></p>
				</li>
				<li>
					{BANNED_USERID_LABEL}: <br /><input name="number" type="userid"><p class="instruct"> <small>{SPAMTIP}</small></p>
					
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>
		<span class="right"><small>{REQUIRED}</small></span>
	</div>
