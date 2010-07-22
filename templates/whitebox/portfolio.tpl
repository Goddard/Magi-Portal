		<div class="item">
			<h1>Biography</h1>
				<br />
				<cite>My name is Ryein Cardale Goddard/Bowling.  I'm currently enrolled at Chemeketa Community College pursuing a degree in Computer Science and Information Systems.  I live in the great green state of Oregon.  The capital more precisely.  
				<br /><br />I am really interested in open software development. I enjoy tinkering with the latest electrics as well.  I am some what lucky being a Linux user.  All the software is usually developed for people in this category.
				<br /><br />I have experience in a few different fields so far and I enjoy sharing my experience with others either on IRC, or community forums.  I don't consider myself a web developer, but that is currently were most my experience is.
				<br /><br />Working on my certifications and degrees I plan on becoming a Network Administrator and possibly other things that interest me.
				<br /><br />Some of my other interests are in language and I am not talking about programming languages.  I am currently learning Japanese and plan on learning several other languages.
				<br /><br />I enjoy sports, but lean towards football and basketball mostly.  My favorite teams are the Seahawks and Trail-Blazers respectively.  
				</cite>
				<br />
			<h1>Languages</h1>
				<br />
				<cite>PHP, Java, Javascript, Mysql, Bash Shell, HTML, CSS</cite>
				<br />
			<h1>Portfolio</h1>
				<br />
				<cite>I have been working on a lot of little projects recently here and there.  I will try and keep an updated list for those that are interested.</cite>
				<br />
			<h2>Java Projects</h2>
				<br />
					<h3>Simple Calculator</h3>
						<br />
						<cite>Here is a simple calculator I made for a class project.
						<br /><br />
						Download : <a href="http://www.kinggoddard.com/files/calculator.jar">Simple Calculator</a>
						<br /><br />This should work on all machines.  If you want to use this on a linux machine you need to launch it with your java console.<br />
						</cite>
			<h2>PHP Projects</h2>
				<br />
					<h3>Page counter with no database and only a picture file</h3>
						<br />
						<cite>I was on phpfreaks.com forum and a user had a problem.  They wanted to have a website counter, but didn't either have access to, or didn't want to use a database.  There was a couple options offered by a few users, but none the person liked.  So I offered one and this is the one he liked.
						<br /><br />
						Example : <a href="/test/test.php">Site Counter Picture</a>
						<br /><br />Unless modified this will only work on Unix machines.  The folder holding this file needs the proper permissions and the image file needs to be writable.<br />
						<div><div class="errorcodetitle"><b>Code:</b><a href="#" onclick="selectCode(this); return false;"> SELECT CODE</a></div><div class="codecontent"><code>&lt;?php
$command = "find /yourimagefolder/*.jpg";
    $file = exec($command);

    $info = pathinfo($file);
$file_name =  basename($file,'.'.$info['extension']);

    $realstring = $file_name;
$useimage  = imagecreatefromjpeg($file);
$linecolor = imagecolorallocate($useimage,233,239,239);
$textcolor = imagecolorallocate($useimage, 255, 255, 255);

imageline($useimage,1,1,40,40,$linecolor);
imageline($useimage,1,100,60,0,$linecolor);
imagestring($useimage, 5, 20, 10, $realstring, $textcolor);

header("Content-type: image/jpeg");
    imagejpeg($useimage);
?&gt;
<img src="test.php">
&lt;?php
    $file_name = $file_name + 1;
rename($file, "/yourimagefolder/".$file_name.".jpg");
?&gt;
</code></div></div><br />
						</cite>
					<h3>Page counter with no database</h3>
						<br />
						<cite>Another person asked for a counter that blends better with their website.
						<br /><br />
						Example : <a href="/test/test2.php">Site Counter Text</a>
						<br /><br />Unless modified this will only work on Unix machines.  The folder holding this file needs the proper permissions and the text file needs to be writable.<br />
						<div><div class="errorcodetitle"><b>Code:</b><a href="#" onclick="selectCode(this); return false;"> SELECT CODE</a></div><div class="codecontent"><code>&lt;?php
$command = "find /yourfolder/*.txt";
	$file = exec($command);

	$info = pathinfo($file);
$file_name =  basename($file,'.'.$info['extension']);

	$file_name = $file_name + 1;
rename($file, "/yourfolder/".$file_name.".txt");

echo $file_name;
?&gt;
</code></div></div><br />
						</cite>
			<h1>My Beginning</h1>
			<ul>
				<cite>When I first started I was apart of a gaming group.  The gaming group didn't have a website or at least a very good one so I decided to try making one.  It just so happens the same time during high school I started a computer class that taught html.  Here is a short list of my incomplete history.  They are listed newest to oldest.</cite>

				<li>
				<a href="http://www.kinggoddard.com/vampportal/">Vamp Portal</a> <cite>This was my first attempt at a large project.  I made it pretty far on my own steam, but as I developed my skills the mess became to much to control.  I eventually started over with my new skills and that is what you see now.  Magi Portal.</cite>
				</li>

				<li>
				<a href="http://opus.chemeketa.edu/~webs/bowlingryein/mypage.htm">School Project 1</a> <cite>Small project for school.  The first of two.</cite>
				</li>

				<li>
				<a href="http://opus.chemeketa.edu/~webs/bowlingryein/project.htm">School Project 2</a> <cite>Small project for school.  The second of two.</cite>
				</li>

				<li>
				<a href="http://www.angelfire.com/rpg2/vampmodteam/">Gaming group</a> <cite>This is another one of my earlier websites I created.  This was after I discovered a few powerful tools.</cite>
				</li>

				<li>
				<a href="http://www.angelfire.com/rpg2/vampmodteam/VAMPTESTPAGE.html">Never Used</a> <cite>Ugly site I never used.  I'm not just showing you the good stuff.  I am showing it all.</cite>
				</li>

				<li>
				<a href="http://www.angelfire.com/ego/s_industries/">First Attempt</a> <cite>This is a page I pretty much took off another website and modified.  Not something I do now without giving proper credit, but hey you have to learn some how.</cite>
				</li>

			</ul>
				
		</div>
	</div>
