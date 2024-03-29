<script>
	$('html').keyup(function(event) {
		if(event.which == 48) {
			$('#block-0').toggle();
		}else if(event.which == 49) {
			$('#block-1').toggle();
		} else if(event.which == 50) {
			$('#block-2').toggle();
		} else if(event.which == 51) {
			$('#block-3').toggle();
		} else if(event.which == 52) {
			$('#block-4').toggle();
		} else if(event.which == 53) {
			$('#block-5').toggle();
		} else if(event.which == 54) {
			$('#block-6').toggle();
		} else if(event.which == 55) {
			$('#block-7').toggle();
		} else if(event.which == 56) {
			$('#block-8').toggle();
		} else if(event.which == 57) {
			$('#block-9').toggle();
		}
	});
	$(document).ready(function(){
		$('table.announcements').dataTable();
	});
</script>






<div id="block-0">
	<div class="widget full welcome-message">
		<div class="widget-title">
			<div class="widget-title-left icon"></div>
			<div class="widget-title-centre">Welcome to Riccarton Tournaments</div>
			<div class="widget-title-right icon"></div>
		</div>
		<div class="widget-body">
			<img style="float:right;width:40%;padding-left:20px;" src="http://www.hw.ac.uk/img/football-800x450.jpg" />
			<p>On this website you can get the latest information about tournament events occuring on campus. This includes the calendar, scores of the matches, and winners of tournaments. You can also register here to purchase tickets and sign up for sports events.</p>
			<a href="sis/help" class="button blue">More Information</a>
		</div>
	</div>
	<h1>Announcements (<a href="#announcement-list">Full List</a>)</h1>
	<table class="full">
		<tr>
			<td colspan="2"><h2><div class="icon subscribe margin-right"></div>Subscribe to our announcements!</h2></td>
		</tr>
		<tr>
			<td style="width:40%">
				<p>Enter in your email below to get any updates we post on the site.</p>
			</td>
			<td style="width:60%">
				<form method="POST" action="/subscribe/">
					<input style="margin-right:20px" placeholder="Your email..." name="email">
					<input type="submit" value="Subscribe" class="green" name="Subscribe">
				</form>
			</td>
		</tr>
	</table>
	<div class="widget full announcement">
		<a href="#newsarticle">
			<div class="widget-title">
				<div class="widget-title-left icon"></div>
				<div class="widget-title-centre">Register now!</div>
				<div class="widget-title-right icon"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 14/02/2013 ~ 13:20</p>
			<img src="http://upload.wikimedia.org/wikipedia/commons/a/ab/Hurdling_Kraenzlein.png" width="100%"/>
			<p>Want to participate in the Heriot Watt Tournament, well now you can register on this website! We are offering the following sports this year.</p>
			<ul>
				<li>Heriot Hurdling (Men &amp; Womens)</li>
				<li>Wattball</li>
			</ul>
			<p>If you have already made an account, be sure to check into your account and sign up for the games you want to participate in.</p>
			<p>If you want to create a team in the Wattball tournament, you only need one member to bla bla bla.</p>
			<a href="#newsarticle" class="button right normal">View Announcement</a>
		</div>
	</div>
	<div>
		<div class="widget half announcement">
			<a href="#newsarticle">
				<div class="widget-title">
					<div class="widget-title-left icon"></div>
					<div class="widget-title-centre">2013 Tournaments announced!</div>
					<div class="widget-title-right icon"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Published:</b> 10/02/2013 ~ 16:20</p>
				<p>Within a couple of days, we will allow you all to register online for the sports
					tournaments. Before you can participate directly, it would be best to register
					now.
				</p>
				<a href="#newsarticle" class="button right normal">View Announcement</a>
			</div>
		</div>
		<div class="widget half announcement">
			<a href="#newsarticle">
				<div class="widget-title">
					<div class="widget-title-left icon"></div>
					<div class="widget-title-centre">Congratulations to the winners!</div>
					<div class="widget-title-right icon"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Published:</b> 12/08/2012 ~ 18:42</p>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
					incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
					nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
					Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
					fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
					culpa qui officia deserunt mollit anim id est laborum.
				</p>
				<a href="#newsarticle" class="button right normal">View Announcement</a>
			</div>
		</div>
	</div>
	<a id="announcement-list"></a><h2>Complete List of Announcements</h2>
	<table class="full announcements">
		<thead>
			<tr>
				<th>Date</th>
				<th>Announcement Title</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>2012/02/12</td>
				<td>Information about upcoming tournaments</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2012/01/16</td>
				<td>Sign up for basketball</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2011/12/23</td>
				<td>Bring it all back to you</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2011/12/31</td>
				<td>Magical Transistor Radio</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2010/11/24</td>
				<td>Duck Ellington</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2010/13/42</td>
				<td>Friendships, Relationships, and all those other ships.</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
			<tr>
				<td>2009/01/02</td>
				<td>Mr Bojangles</td>
				<td><a href="#newsarticle">View Announcement</a></td>
			</tr>
		</tbody>
	</table>
</div>





<div id="block-1">
	<div class="message message-information"><div class="icon margin-right"></div><h3>Information</h3><p>You have successfully logged out.</p></div>
	<div class="message message-success"><div class="icon margin-right"></div><h3>Success</h3></div>
	<div class="message message-error"><div class="icon margin-right"></div><h3>Error</h3><p>So and So did not work, Sorry... :(</p></div>
	<div class="message message-warning"><div class="icon margin-right"></div><h3>Warning</h3><p>So and So did not work, Sorry... :(</p></div>
</div>












<div id="block-2">
	<h1>Tournaments</h1>
	<h1><a href="#">Tournaments</a><div class="icon subsection margin-right margin-left"></div>Wattball 2013</h1>
	<p class="indent">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed felis felis, tristique at interdum et, dapibus ut ligula. Vestibulum mi neque, laoreet a egestas sit amet, lacinia quis nisi. Nunc enim mi, aliquet vel gravida a, fermentum vel augue. Donec mi dolor, consectetur id aliquam non, posuere eget ante. Nam vel elit et justo egestas interdum. Quisque feugiat feugiat purus, sit amet commodo turpis tincidunt pretium. Suspendisse volutpat, tellus nec aliquam <a href="/">fermentum</a>, libero velit placerat purus, vitae dignissim risus massa et nisl. Mauris congue feugiat erat, nec tempus felis tincidunt et. Sed ultrices urna sodales est rutrum in elementum arcu commodo. Cras id risus a dolor varius ultrices. Suspendisse potenti. Curabitur vestibulum mi sit amet sapien vulputate faucibus.</p>
	<h1>&quot;Sed ipsum nulla, hendrerit ac suscipit at, bibendum sed lacus. In et mauris et eros imperdiet vestibulum. Nam dapibus vestibulum neque, non pharetra dolor tincidunt ac. In hac habitasse platea dictumst. Aliquam erat volutpat.&quot;</h1>
	<p class="indent">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed felis felis, tristique at interdum et, dapibus ut ligula. Vestibulum mi neque, laoreet a egestas sit amet, lacinia quis nisi. Nunc enim mi, aliquet vel gravida a, fermentum vel augue. Donec mi dolor, consectetur id aliquam non, posuere eget ante. Nam vel elit et justo egestas interdum. Quisque feugiat feugiat purus, sit amet commodo turpis tincidunt pretium. Suspendisse volutpat, tellus nec aliquam <a href="/">fermentum</a>, libero velit placerat purus, vitae dignissim risus massa et nisl. Mauris congue feugiat erat, nec tempus felis tincidunt et. Sed ultrices urna sodales est rutrum in elementum arcu commodo. Cras id risus a dolor varius ultrices. Suspendisse potenti. Curabitur vestibulum mi sit amet sapien vulputate faucibus.</p>
	<img width="100%" src="http://images.veerle.duoh.com/uploads/design-article-images/Otl-Aicher.png">
	<h3>Select role:</h3>
	<h3>
		Ed ipsum nulla, hendrerit ac suscipit at, bibendum sed lacus. In et mauris et eros imperdiet vestibulum. Nam dapibus vestibulum neque, non pharetra dolor tincidunt ac. In hac habitasse platea dictumst. Aliquam erat volutpat.
	</h3>
	<h3>Select role:</h3>
	<p class="indent">
		Sed ipsum nulla, hendrerit ac suscipit at, bibendum sed lacus. In et mauris et eros imperdiet vestibulum. Nam dapibus vestibulum neque, non pharetra dolor tincidunt ac. In hac habitasse platea dictumst. Aliquam erat volutpat. Etiam lobortis aliquet risus quis porta. Maecenas in arcu eu orci laoreet mollis. <br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi suscipit dapibus nulla, non venenatis sapien viverra vitae. Nullam tincidunt lectus mauris. Nam tincidunt imperdiet commodo. <br/><br/>In egestas tellus hendrerit augue rhoncus aliquam. Donec quis libero at felis tristique egestas. Sed eu mauris nisi, a consectetur mi.
	</p>
	<h2>2014</h2>
	<br/>
	<h2>
		Sed ipsum nulla, hendrerit ac suscipit at, bibendum sed lacus. In et mauris et eros imperdiet vestibulum. Nam dapibus vestibulum neque, non pharetra dolor tincidunt ac. In hac habitasse platea dictumst. Aliquam erat volutpat.
	</h2>
	<figure>
		<img src="http://cloud.bench.li/images/original/21294.jpg" alt="Schedule for olympics" width="50%">
		<figcaption>Fig.1 - Otl Aicher 1972 Munich Olympics Poster - Timetable</figcaption>
	</figure>
	<h2>2014</h2>
	<h2>2014</h2>
	<p class="indent">
		Sed ipsum nulla, hendrerit ac suscipit at, bibendum sed lacus. In et mauris et eros imperdiet vestibulum. Nam dapibus vestibulum neque, non pharetra dolor tincidunt ac. In hac habitasse platea dictumst. Aliquam erat volutpat. Etiam lobortis aliquet risus quis porta. Maecenas in arcu eu orci laoreet mollis. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Morbi suscipit dapibus nulla, non venenatis sapien viverra vitae. Nullam tincidunt lectus mauris. Nam tincidunt imperdiet commodo. In egestas tellus hendrerit augue rhoncus aliquam. Donec quis libero at felis tristique egestas. Sed eu mauris nisi, a consectetur mi.
	</p>
	<ul>
		<li>A, you're adorable</li>
		<li>B, you're so beautiful</li>
		<li>C, you're cutie full of charms.</li>
	</ul>
	<ol>
		<li>D, you're a darling</li>
		<li>E, you're exiting and</li>
		<li>F, you're a feather in my arms.</li>
	</ol>
	<dl>
		<dt>G</dt>
		<dd>you look good to me</dd>
		<dt>H</dt>
		<dd>you're so heavenly</dd>
		<dt>I</dt>
		<dd>you're the one I idolize.</dd>
	</dl>
	<p>
		Did you know that <abbr title="PHP Hypertext Preprocessor">PHP</abbr> is an abbreviation of "PHP hypertext Preprocessor"? This experssion also evaluates to PHP hypertext Preprocessor hypertext Preprocessor. Additionally, do you know what the difference between an abbbreviation and an acronym is? An acronym is something you say as a word, like <acronym title="As Soon As Possible">ASAP</acronym>, <acronym title="North Atlantic Treaty Organization">NATO</acronym> or <acronym title="National Aeronautics and Space Administration">NASA</acronym>.
	</p>
	<p>
		Lets test out our html tags here: <b>bold</b>, <em>emphasis</em>, <i>italics</i>, <s>incorrect text</s>, super<sup>script</sup>, sub<sub>script</sub> <q>A quote</q>
	</p>
	<blockquote cite="http://www.worldwildlife.org/who/index.html">
		For 50 years, WWF has been protecting the future of nature. The world’s leading conservation organization, WWF works in 100 countries and is supported by 1.2 million members in the United States and close to 5 million globally.
	</blockquote>
	<address>
		Written by <a href="mailto:webmaster@example.com">Jon Doe</a>.<br> 
		Visit us at:<br>
		Example.com<br>
		Box 564, Disneyland<br>
		USA
	</address>
	<pre>
		Some Stuff

		Some more stuff, 

		I wonder if this does anything interesting.
	</pre>
</p>
	<h2>2013</h2>
	<br/>
</div>



















<div id="block-3">
	<div>
		<div class="widget half">
			<a href="">
				<div class="widget-title">
					<div class="widget-title-left icon sport-wattball"></div>
					<div class="widget-title-centre">Wattball Tournament</div>
					<div class="widget-title-right icon chevron"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Duration:</b> 01/03/2013 - 28/03/2013</p>
				<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
				<a href="#" class="button green right">Sign up!</a>
			</div>
		</div>
		<div class="widget half">
			<a href="">
				<div class="widget-title">
					<div class="widget-title-left icon sport-hurdling"></div>
					<div class="widget-title-centre">Men's Hurdling Tournament Extravaganza</div>
					<div class="widget-title-right icon chevron"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Duration:</b> 01/03/2013 - 28/03/2013</p>
				<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
				<div class="right">
					<a href="#" class="button normal">Details</a>
					<a href="#" class="button green">Sign up!</a>
				</div>
			</div>
		</div>
		<div class="widget half">
			<a href="">
				<div class="widget-title">
					<div class="widget-title-left icon news"></div>
					<div class="widget-title-centre">ThisShouldHopefullyWordWrap</div>
					<div class="widget-title-right icon load"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Duration:</b> 01/03/2013 - 28/03/2013</p>
				<img width="100%" src="http://24.media.tumblr.com/tumblr_m1xac0MAsn1qiugg3o1_400.png">
				<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
				<a href="#" class="button right blue normal">More Information &amp; Even More Information.</a>
			</div>
		</div>
		<div class="widget half">
			<a href="">
				<div class="widget-title">
					<div class="widget-title-left icon news"></div>
					<div class="widget-title-centre">Some other thing that is cool</div>
					<div class="widget-title-right icon chevron"></div>
				</div>
			</a>
			<div class="widget-body">
				<p><b>Duration:</b> 01/03/2013 - 28/03/2013</p>
				<img width="100%" src="http://www.vintagefestival.co.uk/system/images/BAhbB1sHOgZmIicyMDExLzExLzEwLzEzXzM3XzIwXzEyOV9NdW5pY2guanBnWwg6BnA6CnRodW1iIg00NTB4NDUwPg/Munich.jpg">
				<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
				<a href="#" class="button right normal">More Information</a>
			</div>
		</div>
		<div class="widget half">
			test
		</div>
		<div class="widget half">
			test
		</div>
		<div class="widget half">
			test
		</div>
		<div class="widget half">
			test
		</div>
	</div>
	<p><a href="#" class="button green">I'm a button, all alone... </a></p>
	<p>
		<input type="submit" class="green" value="Test">
		<input type="submit" class="red" value="Heck">
		<input type="submit" class="blue" value="Blue">
		<input type="submit" class="normal" value="Normal">
	</p>
	<div class="widget full">
		<a href="">
			<div class="widget-title">
				<div class="widget-title-left icon news"></div>
				<div class="widget-title-centre">A news article about something that happened</div>
				<div class="widget-title-right icon chevron"></div>
			</div>
		</a>
		<div class="widget-body">
			<p><b>Published:</b> 01/03/2013 ~ 13:20</p>
			<p>Running with a ball, sometimes kicking it. This would be the description of the tournament</p>
			<h1>Running with a ball, sometimes kicking it. This would be the description of the tournament</h1>
			<h2>Running with a ball, <a href="test">sometimes kicking it.</a> This would be the description of the tournament</h2>
			<img width="100%" src="http://vintageseekers.assets.d3r.com/images/gallery/55019-1972-munich-olympics-poster.jpg">
			<h3>Running with a ball, sometimes kicking it. (ノಠ益ಠ)ノ彡┻━┻ This would be the description of the tournament</h3>
			<p>Running with a ball, sometimes <a href="test">kicking it</a>. This would be the description of the tournament</p>
			<div class="right">
				<a href="#" class="button normal"><!--<div class="icon load margin-right"></div>-->More Information</a>
				<a href="#" class="button red"><div class="icon dalek-white margin-right"></div>EXTERMINATE!</a>
			</div>
		</div>
	</div>
	<div class="widget half">
		test
	</div>
	<div class="widget half">
		test
	</div>
	<div class="widget half">
		test
	</div>
</div>


















<div id="block-4">
	<table class="widget threefourth">
		<tr>
			<th>Header 1</th>
			<th>Header 2</th>
		</tr>
		<tr>
			<td>Text 1</td>
			<td>Lorem ipsum dolor sit a met</td>
		</tr>
		<tr>
			<td>Text 2</td>
			<td>Lorem ipsum dolor sit a met</td>
		</tr>
		<tr>
			<td>Name</td>
			<td><input type="text"></td>
		</tr>
		<tr>
			<td>Checkbox</td>
			<td>
				<label><input name="checkmate" type="checkbox"> Thingy A</label>
				<label><input name="checkmate" type="checkbox"> Thingy B</label>
				<label><input name="checkmate" type="checkbox"> Thingy C</label>
				<label><input name="checkmate" type="checkbox"> Thingy D</label>
				<label><input name="checkmate" type="checkbox"> Thingy E</label>
			</td>
		</tr>
		<tr>
			<td>Signals</td>
			<td>
				<label><input name="avalanches" type="radio"> Thing 1</label>
				<label><input name="avalanches" type="radio"> Thing 2</label>
				<label><input name="avalanches" type="radio"> Thing 3</label>
			</td>
		</tr>
		<tr>
			<td>Select</td>
			<td>
				<select>
					<option value="volvo">Volvo</option>
					<option value="saab">Saab</option>
					<option value="mercedes">Mercedes</option>
					<option value="audi">Audi</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Name</td>
			<td><textarea>Lorem ipsum dolor sit a met</textarea></td>
		</tr>
	</table>
</div>
















<div id="block-5">
	<form action="/sis/signup/18" id="signupForm" method="POST">
		<h3 id="actionHeading">Select role:</h3>
		<p><a href="#" class="roleButton button blue" id="roleButton-1">Umpire</a>
			<a href="#" class="roleButton button blue" id="roleButton-2">Team Leader</a></p>
			<p>Just doing another line test</p>
			<div class="roleSections" id="roleSections-1" style="display: none">
				<h3 class="sectionHeading" id="sectionHeading-1">Personal Details</h3>
				<div class="sectionBody" id="sectionBody-1">
					<table>
						<tr><td>Address: 		</td><td><textarea id="address" name="address"></textarea></tr>
						<tr><td>About Yourself: </td><td><textarea id="aboutMe" name="aboutMe"></textarea></tr>
					</table>
					<div class='navButtons'><a href='#' class='nextButton button'>Next</a></div>
				</div>
				<h3 class="sectionHeading" id="sectionHeading-2">Emergency Contact Details</h3>
				<div class="sectionBody" id="sectionBody-2">
					<table>
						<tr><td>Name: 			</td><td><input id="emergencyName" name="emergencyName"></input></tr>
						<tr><td>Phone:			</td><td><input id="emergencyPhone" name="emergencyPhone"></input></tr>
						<tr><td>Email:			</td><td><input id="emergencyEmail" name="emergencyEmail"></input></tr>
						<tr><td>Address:		</td><td><input id="emergencyAddress" name="emergencyAddress"></input></tr>
					</table>
					<div class='navButtons'><a href='#' class='backButton button'>Back</a> <a href='#' class='nextButton button'>Next</a></div>	
				</div>
				<h3 class="sectionHeading" id="sectionHeading-7">Availability</h3>
				<div class="sectionBody" id="sectionBody-7">
					<table>
						<tr><td>Monday: 	</td><td><input type="checkbox" id="monday" name="monday" value="1"></input></tr>
						<tr><td>Tuesday:	</td><td><input type="checkbox" id="tuesday" name="tuesday" value="1"></input></tr>
						<tr><td>Wednesday: 	</td><td><input type="checkbox" id="wednesday" name="wednesday" value="1"></input></tr>
						<tr><td>Thursday: 	</td><td><input type="checkbox" id="thursday" name="thursday" value="1"></input></tr>
						<tr><td>Friday: 	</td><td><input type="checkbox" id="friday" name="friday" value="1"></input></tr>
						<tr><td>Saturday: 	</td><td><input type="checkbox" id="saturday" name="saturday" value="1"></input></tr>
						<tr><td>Sunday: 	</td><td><input type="checkbox" id="sunday" name="sunday" value="1"></input></tr>
					</table>
					<div class='navButtons'><a href='#' class='backButton button'>Back</a> <a href='#' class='nextButton button'>Next</a></div>
				</div>
				<h3 class="sectionHeading" id="sectionHeading-submit">Sign Up!</h3>
			</div>

			<div class="roleSections" id="roleSections-2" style="display: none">
				<h3 class="sectionHeading" id="sectionHeading-8">Personal Details</h3>
				<div class="sectionBody" id="sectionBody-8">
					Address: 		<textarea id="address" name="address"></textarea><br/> <br/>
					About Yourself: <textarea id="aboutMe" name="aboutMe"></textarea><br/> <br/>
					<div class='navButtons'><a href='#' class='nextButton button'>Next</a></div>
				</div>
				<h3 class="sectionHeading" id="sectionHeading-9">Emergency Contact Details</h3>
				<div class="sectionBody" id="sectionBody-9">
					Name: <br/><input id="emergencyName" name="emergencyName"></input><br/> <br/>
					Phone: <br/><input id="emergencyPhone" name="emergencyPhone"></input><br/> <br/>
					Email: <br/><input id="emergencyEmail" name="emergencyEmail"></input><br/> <br/>
					Address: <br/><input id="emergencyAddress" name="emergencyAddress"></input><br/> <br/>
					<div class='navButtons'><a href='#' class='backButton button'>Back</a> <a href='#' class='nextButton button'>Next</a></div>	
				</div>
				<h3 class="sectionHeading" id="sectionHeading-10">Team Details</h3>
				<div class="sectionBody" id="sectionBody-10">
					Name: <br/><input id="teamName" name="teamName"></input><br/> <br/>
					Association Number: <br/><input id="teamNumber" name="teamNumber"></input><br/> <br/>
					<div class='navButtons'><a href='#' class='backButton button'>Back</a> <a href='#' class='nextButton button'>Next</a></div>	
				</div>
				<h3 class="sectionHeading" id="sectionHeading-11">Team Members</h3>
				<div class="sectionBody" id="sectionBody-11">
					Members: <br/><a href="#" class="addTeamMember">Add Team Member</a> <br/>
					<div class='navButtons'><a href='#' class='backButton button'>Back</a> <a href='#' class='nextButton button'>Next</a></div>	
				</div>
				<h3 class="sectionHeading" id="sectionHeading-submit">Sign Up!</h3>
			</div>
		</form>

		<script>
		$(document).ready(function(){
			$(".roleButton").click(function(){
				roleID=$(this).attr('id').substr(11);
				/*$(".roleButton").remove();*/
				/*$("#actionHeading").remove();*/
				$('.roleSections').not("#roleSections-"+roleID).hide();
				$("#roleSections-"+roleID).show("fast");
				$("#roleSections-"+roleID).accordion({heightStyle:"content"});
				$("#submit").show();
				$(".nextButton").click(function(){
					var currentActiveSection=$("#roleSections-"+roleID).accordion("option","active");
					$("#roleSections-"+roleID).accordion("option","active",currentActiveSection+1);
					return false;
				});
				$(".backButton").click(function(){
					var currentActiveSection=$("#roleSections-"+roleID).accordion("option","active");
					$("#roleSections-"+roleID).accordion("option","active",currentActiveSection-1);
					return false;
				});
				$(".addTeamMember").click(function(){
					alert("Hurr Durr Team Member Added");
					return false;
				});
				$("#roleSections-"+roleID).on("accordionactivate",function(event,ui){
										// console.log(ui);
										$("input",ui.newPanel).first().focus();
									});
				return false;
			});
$("#sectionHeading-submit").click(function(){
	$('.roleSections').not("#roleSections-"+roleID).hide();
	$("#signupForm").submit();return false;
});
$("a").die("keypress").live("keypress",function(e){
	if(e.which==32){$(this).trigger("click");e.preventDefault();}});if($(".roleButton").length==1){$(".roleButton").click();
}
});
</script>
</div>







<div id="block-6">
	<div id='calendar'></div>
	<script>
	$(document).ready(function(){
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay'
			},
			contentHeight: 600,
			editable: true,
			events: [
			{
				title: 'All Day Event',
				start: new Date(y, m, 1),
				className: 'match'
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2),
				className: 'registration'
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2),
				className: 'registration'
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2),
				className: 'match wakaka'
			},
			{
				title: 'Long Event',
				start: new Date(y, m, d-5),
				end: new Date(y, m, d-2),
				className: 'match'
			},
			{
				id: 999,
				title: 'Repeating Event',
				start: new Date(y, m, d-3, 16, 0),
				allDay: false,
				className: 'match'
			},
			{
				id: 999,
				title: 'IjustWanderHowLongItWillTake',
				start: new Date(y, m, d+4, 16, 0),
				allDay: false,
				className: 'match'
			},
			{
				title: 'Meeting With Joe',
				start: new Date(y, m, d, 10, 45),
				allDay: false,
				className: 'match'
			},
			{
				title: 'Lunch',
				start: new Date(y, m, d, 12, 0),
				end: new Date(y, m, d, 14, 0),
				allDay: false,
				className: 'match'
			},
			{
				title: 'Birthday Party',
				start: new Date(y, m, d+1, 19, 0),
				end: new Date(y, m, d+1, 22, 30),
				allDay: false,
				className: 'tournament'
			},
			{
				title: 'Click for Google',
				start: new Date(y, m, 28),
				end: new Date(y, m, 29),
				url: 'http://google.com/',
				className: 'match'
			}
			]
		});

});
</script>
</div>

<div id="block-7">
	<h1>Icons</h1>
	<h3>
		<div class="icon dalek-white"></div>
		<div class="icon dalek-black"></div>
		<div class="icon block-black-light"></div>
		<div class="icon block-black-medium"></div>
		<div class="icon block-black-dark"></div>
		<div class="icon block-blue-light"></div>
		<div class="icon block-blue-medium"></div>
		<div class="icon block-blue-dark"></div>
		<div class="icon block-white"></div>
		<div class="icon block-blue-medium"></div>
		<div class="icon arrow-right-white"></div>
		<div class="icon chevron"></div>
		<div class="icon arrow-right-black-light"></div>
		<div class="icon arrow-right-black-gray"></div>
		<div class="icon arrow-right-black-dark"></div>
		<div class="icon arrow-right-blue-light"></div>
		<div class="icon arrow-right-blue-gray"></div>
		<div class="icon arrow-right-blue-dark"></div>
	</h3>
</div>