	<div class="content">

		<div class="item">
			<h1>{MAINTENANCE_TITLE}</h1>
			<cite>{MAINTENANCE_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=maintenance">
			<ul>
				<li>
					{MAINTENANCE_USER_DELETE}:* <br /><input type="checkbox" name="name" /><p class="instruct"><small>{MAINTENANCE_USER_DELETE_TIP}</small></p>
				</li>
				<li>
					{MAINTENANCE_BAN_HAMMER}:* <br /><input type="checkbox" name="name" /><p class="instruct"><small>{MAINTENANCE_BAN_HAMMER_TIP}</small></p>
				</li>				
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>