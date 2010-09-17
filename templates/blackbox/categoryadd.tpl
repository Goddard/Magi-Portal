	<div class="content">

		<div class="item">
			<h1>{CATEGORY_ADD_TITLE}</h1>
			<cite>{CATEGORY_ADD_SUB_TITLE}</cite>
			<form onsubmit="instance.post();" method="post" action="index.php?page=categoryadd">

			<ul>
			
				<li>
				
					{CATEGORY_NAME_LABEL}:* <br /><input type="text" name="name" /><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				
				</li>
				
				<li>
				
					{CATEGORY_PICTURE_LABEL}:* <br /><input type="text" name="picture" /><p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
				
				</li>

				<li>
				
					{CATEGORY_TYPE_LABEL}:* <br />
					{CATEGORY_TYPES}
					<p class="instruct"><small>This headline will be displayed along with your news posting in links across the site.</small></p>
					
				</li>

				<li>
				
					{CATEGORY_DESCRIPTION_LABEL}:* <br /><textarea name="description" style="width:500px; height:200px;"></textarea>

				</li>

				<li>
				
				     {CATEGORY_SUB_LABEL}: <br /> {CATEGORY_SUB} <p class="instruct"><small>If you share allow others to comment your script.</small></p></left>
				
				</li>
				
			</ul>
			<input type="submit" name="Submit" value="{SUBMIT}"> <input type="reset" value="{RESET}">
			</form > 
		</div>

		<span class="right"><small>{REQUIRED}</small></span>

	</div>
