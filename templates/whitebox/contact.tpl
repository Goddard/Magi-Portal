	<div class="content">

		<div class="item">
			<h1>{CONTACT_TITLE}</h1>
			<cite>{CONTACT_SUB_TITLE}</cite>
			<form method="post" action="contact.php">
			<ul>
				<li>
					{NAME}:* <br /><input type="text" name="name" /><p class="instruct"><small>{CONTACT_NAME_TIP}</small></p>
				</li>
				<li>
					{EMAIL}:* <br /><input type="text" name="email" /><p class="instruct"><small>{CONTACT_EMAIL_TIP}</small></p>
				</li>
				<li>
					{MESSAGE}:* <br /><textarea rows="15" name="message" cols="40"></textarea><p class="instruct"> <small>{CONTACT_MESSAGE_TIP}</small></p>
					
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
