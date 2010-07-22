	<div class="content">

		<div class="item">
			<h1>{TITLE}</h1>
			<cite>{MESSAGE}</cite>
			<form method="post" action="index.php?page=configuration">
			<ul>
				<li>
					{INPUT_TITLE}:* <br /><textarea name="configoptions" cols=75 rows=40>{CONFIG_OPTIONS}</textarea><p class="instruct"><small>{CGTIP}</small></p>
				</li>
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
