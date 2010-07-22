			<form method="post" action="index.php?page=userpanel&user=personalize">
			<ul><div class="right"><center>Avatar<br /><img src={USER_AVATAR}></center><br /><center><input type="text" name="avatar" value="{USER_AVATAR}" /></center></div>
				<li>
					Age: <br /> <input type="text" name="age" value="{USER_AGE}" /><input type="hidden" name="userid" value="{USER_ID}" /> <p class="instruct"> <small>{USERTIP}</small> </p>
				</li>
				<li>
					Location: <br /> <input type="text" name="location" value="{USER_LOCATION}" /><input type="hidden" name="userid" value="{USER_ID}" /> <p class="instruct"> <small>{USERTIP}</small> </p>
				</li>
				<li>
					Occupation: <br /> <input type="text" name="occupation" value="{USER_OCCUPATION}" /> <p class="instruct"> <small>{CODENAMETIP}</small> </p>
				</li>
				<li>
					MSN: <br /> <input type="text" name="msn" value="{USER_MSN}" /> <p class="instruct"> <small>{PASSTIP}</small> </p>
				</li>
				<li>
					Yahoo: <br /> <input type="text" name="yahoo" value="{USER_YAHOO}" />  <p class="instruct"> <small>{CONFIRMPASSTIP}</small> </p>
				</li>
				<li>
					Google: <br /> <input type="text" name="google" value="{USER_GOOGLE}" /> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					Skype: <br /> <input type="text" name="skype" value="{USER_SKYPE}" /> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					URL: <br /> <input type="text" name="url" value="{USER_URL}" /> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					Signature: <br /> <textarea cols="40" rows="5" name="signature">{USER_SIGNATURE}</textarea> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					Biography: <br /> <textarea cols="40" rows="5" name="biography">{USER_BIOGRAPHY}</textarea> <p class="instruct"> <small>{EMAILTIP}</small> </p>
				</li>
				<li>
					{TEMPLATE}:* <br /> {USER_TEMPLATE}
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
			<span class="right"><small>{REQUIRED}</small></span>