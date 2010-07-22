			<form method="post" action="index.php?page=userpanel&user=required">
			<ul>
				<li>
					{USERNAME}:* <br /> {USER_NAME}<input type="hidden" name="userid" value="{USER_ID}" /> <p class="instruct"> <small>{USERTIP}</small> </p>
				</li>
				<li>
					{CODENAME}:* <br /> {DISPLAY_NAME} <p class="instruct"> <small>{CODENAMETIP}</small> </p>
				</li>
				<li>
					{PASSWORD}:* <br /> <input type="password" name="password" /> <p class="instruct"> <small>{PASSTIP}</small> </p>
				</li>
				<li>
					{CONFIRM_PASSWORD}:* <br /> <input type="password" name="confirmpassword" /> <p class="instruct"> <small>{CONFIRMPASSTIP}</small> </p>
				</li>
				<li>
					{EMAIL}:* <br /> <input type="text" name="email" value="{USER_EMAIL}" /> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					{LANGUAGE}:* <br /> {USER_LANGUAGE} <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
			<span class="right"><small>{REQUIRED}</small></span>