	<div class="content">

		<div class="item">
			<h1>{MAINTENANCE_TITLE}</h1>
			<cite>{MAINTENANCE_SUB_TITLE}</cite>
			<form method="post" action="index.php?page=maintenance">
			<ul>
				<li>
					{MAINTENANCE_USER_DELETE}:* <br /><input type="checkbox" name="userdelete" value="true" /><p class="instruct"><small>{MAINTENANCE_USER_DELETE_TIP}</small></p>
					<cite>There are {MAINTENANCE_INACTIVE_COUNT} inactive registered accounts.
					There are {MAINTENANCE_INACTIVE_OLD_COUNT} inactive register accounts older then {MAINTENANCE_DELETE_TIME} that will be deleted as set in the configuration options.</cite>
				</li>
				<li>
					{MAINTENANCE_BAN_HAMMER}:* <br /><input type="checkbox" name="banhammer" /><p class="instruct"><small>{MAINTENANCE_BAN_HAMMER_TIP}</small></p>
				</li>				
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>