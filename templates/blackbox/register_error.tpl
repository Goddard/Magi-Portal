	<div class="content">

		<div class="item">
			<h1>{REGISTRATION_FORM_TITLE}</h1>
			<cite>{REGISTRATION_MESSAGE}</cite>
			<form method="post" action="register.php">
			<ul>
				<li>
					{USERNAME}:* <br /> <input type="text" name="name" /> <p class="instruct"> <small>{USERTIP}</small> </p>
				</li>
				<li>
					{CODENAME}:* <br /> <input type="text" name="codename" /> <p class="instruct"> <small>{CODENAMETIP}</small> </p>
				</li>
				<li>
					{PASSWORD}:* <br /> <input type="password" name="password" /> <p class="instruct"> <small>{PASSTIP}</small> </p>
				</li>
				<li>
					{EMAIL}:* <br /> <input type="text" name="email" /> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					{SPAM}:* <br /> {CAPTCHA_LINK} <br /> <input name="number" type="text"> <p class="instruct"> <small>{SPAMTIP}</small> </p>
				</li>
			</ul>
			<input type="submit" name="submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

			<span class="right"><small>{REQUIRED}</small></span>

	</div>
