<h1>Welcome to Heriot Watt Sports!</h1>

<? if(!empty($message)){ ?>
	<div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<div class="home-content">
	<p>
		Welcome to the Heriot Watt Sports Tournament Homepage!
	</p>
	<p>
		On this website you can get the latest information about tournament events
		occuring on campus. This includes the calendar, scores of the matches, and
		winners of tournaments. You can also register here to purchase tickets and
		sign up for sports events.
	</p>
</div>

<h1>News</h1>

<div class="subscribe-item">
	<form method="POST" action="/subscribe/">
		<p>Want to keep up with sport tournament news?</p>
		<p>Enter in your email below to get any updates we post on the site.</p>
		<input type="text" placeholder="Your email..." name="email"/>
		<input type="submit" value="Subscribe" name="Subscribe"/>
	</form>
</div>

<div class="news-item">
	<a href="news/$newsID" class="news-header">Register Now!</a>
	<div class="news-published">February 14th, 2013</div>
	<a href="news/$newsID" class="news-permalink">permalink</a>
	<div class="news-content">
		<p>
			Want to participate in the Heriot Watt Tournament, well now you can register on this 
			website! We are offering the following sports this year.
		</p>
		<ul>
			<li>Heriot Hurdling (Men &amp; Womens)</li>
			<li>Wattball</li>
		</ul>
		<p>
			If you have already made an account, be sure to check into your account and sign up for
 			the games you want to participate in.
 		</p>
		<p>If you want to create a team in the Wattball tournament, you can do so when signing up for a</p>
	</div>
</div>

<div class="news-item">
	<a href="news/$newsID" class="news-header">Opening soon...</a>
	<div class="news-published">February 10th, 2013</div>
	<a href="news/$newsID" class="news-permalink">permalink</a>
	<div class="news-content">
		<p>The website will work soon hopefully by February... I hope</p>
	</div>
</div>

<div class="news-item">
	<a href="news/$newsID" class="news-header">Congratulations to the winnders!</a>
	<div class="news-published">January 5th, 2013</div>
	<a href="news/$newsID" class="news-permalink">permalink</a>
	<div class="news-content">
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor 
			incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis 
			nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. 
			Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu 
			fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in 
			culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
</div>