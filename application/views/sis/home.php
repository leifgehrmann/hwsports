<h1>Welcome to Heriot Watt Sports!</h1>

<? if(!empty($message)){ ?>
	<div id="infoMessage"><?php echo $message;?></div>
<? } ?>

<div class="home-content">
	<p>This is the homepage news stuff for public people.</p>
	<p>
		This part could be a welcome message that can be defined in the <b>appearence menu</b> in the
		TMS. We are also assuming that the <b>title of this page will be changeable as well</b>.
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
	<a href="news/$newsID" class="news-header">Essay: Why Applejack is <em>best</em> pony.</a>
	<div class="news-published">January 5th, 2013</div>
	<a href="news/$newsID" class="news-permalink">permalink</a>
	<div class="news-content">
		<p>Because she is</p>
	</div>
</div>