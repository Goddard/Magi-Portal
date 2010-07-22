		<div class="item">
			<h1>{SCRIPT_NAME}</h1>
			<p>Created By: {SCRIPT_AUTHOR} on {SCRIPT_DATE}</p>
			<cite>{SCRIPT_COMMENT}</cite>
			<div class="item">
			<span class="newscode">
			<span class="newscodetitle"><b>CODE:</b><a href="#" onclick="selectCode(this); return false;"> SELECT CODE</a></span>
			<div class="codecontent"><code>{SCRIPT_CONTENT}</code></div>
			</span>
			</div>
			<div class="left"><span class="menusmallrate"><a href="#" value="-1" onclick="getVote(this.value)">-1</a> <a href="#">+1</a></span></div>
			<div class="right"><span class="menusmall">{COMMENT_COUNT} {EDIT} {DELETE} <a href="#">Flag</a> <a href="#">Print</a></span></div>
			<br /><br />
		</div>
