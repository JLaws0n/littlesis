<?php use_helper('Number') ?>
<?php $sf_response->addJavascript('jquery.min.js', 'first'); ?>
<?php $sf_response->addJavascript('jquery.tinycarousel.js'); ?>
<?php $sf_response->addJavascript('jquery.shuffle.js'); ?>

<!-- SPLASH -->

<div id="homepage-splash">

<div id="homepage-lists">
<span style="font-size: 19px;"><span style="color: #000;">
<?php $num = $person_num + $org_num; ?>
<?php $nums = str_split($num); ?>
<?php $counter = '&nbsp;'; ?>
<?php foreach ($nums as $num) : ?>
  <?php $counter .= ('<div class="homepage-counter">' . $num . '</div>'); ?>
<?php endforeach; ?>
<?php echo $counter; ?>
</span> dots connected:</span>
<div style="margin-top: 10px; margin-bottom: 24px;">
&nbsp; &nbsp;&#10004;&nbsp; <?php echo link_to('Paid-for politicians', $politician_list->getInternalUrl()) ?><br />
&nbsp; &nbsp;&#10004;&nbsp; <?php echo link_to('Corporate fat cats', $fatcat_list->getInternalUrl()) ?><br />
&nbsp; &nbsp;&#10004;&nbsp; <?php echo link_to('Revolving door lobbyists', $lobbyist_list->getInternalUrl()) ?><br />
&nbsp; &nbsp;&#10004;&nbsp; <?php echo link_to('Secretive Super PACs', $pac_list->getInternalUrl()) ?><br />
&nbsp; &nbsp;&#10004;&nbsp; <?php echo link_to('Elite think tanks', $think_tank_list->getInternalUrl()) ?> <!--& <?php echo link_to('philanthropies', $philanthropy_list->getInternalUrl()) ?>-->
</div>
  <form action="<?php echo url_for('search/simple') ?>">
    <div class="input-group" style="width: 250px;">
      <input class="form-control" type="text" name="q" placeholder="search for a name" />
      <span class="input-group-btn">
        <button class="btn" style="color: white; background-color: #cc5454;" type="submit"><span class="glyphicon glyphicon-search"></span>&nbsp;</button>
      </span>
    </div>
  </form>
</div>


<div style="margin-left: 0px; width: 600px;">
<div id="homepage-splash-header">LittleSis<span style="color: #cc5454;">*</span> is a free database of who-knows-who at the heights of business and government.</div>
<div style="font-weight: 300; font-size: 14px; color: #cc5454;"><span style="font-size: 16px; font-weight: bold;">*</span> opposite of Big Brother</div>

<div id="homepage-splash-subheader">
We're a grassroots watchdog network connecting the dots between the world's most powerful people and organizations.
</div>

<div style="float: left; margin-right: 2em;">
<form action="http://groups.google.com/group/littlesis/boxsubscribe">

<div class="input-group" style="width: 280px;">
  <input class="form-control" type="text" name="email"
  placeholder="your email" size="25" />
  <span class="input-group-btn">
    <button class="btn" style="color: white; background-color: #cc5454;" type="submit" name="sub">Join Us!</button>
  </span>
</div>

</form>
</div>

<div style="float: left; margin-right: 2em; padding-top: 8px;">
<a href="https://twitter.com/twittlesis" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false" data-dnt="true">Follow</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>

<div style="padding-top: 8px; float: left; margin-right: 2em ">
<div class="fb-like" data-href="https://www.facebook.com/LittleSis.org" data-send="false" data-layout="button_count" data-width="90" data-show-faces="false"></div>
</div>

<div id="donate">
  <a href="http://public-accountability.org/donate/" class="btn" style="color: white; background-color: #cc5454; text-decoration: none;">Donate</a>
</div>

</div>

</div>


<!-- CAROUSEL PART -->

<br />
<br />
<br />

<div class="littlesis-carousel">
  <a class="buttons prev" href="#"><?php echo image_tag("system/carousel-left-semi.png"); ?></a>
  <div class="viewport">
      <ul class="overview">
      <?php foreach ($carousel_ids as $id) : ?>
        <li><?php include_component('entity', 'carousel', array('id' => $id)) ?></li>
      <?php endforeach; ?>
      </ul>
  </div>
  <a class="buttons next" href="#"><?php echo image_tag("system/carousel-right-semi.png"); ?></a>
</div>


<!-- OLIGRAPHER PART -->

<div id="splash-intro" class="row">
  <div id="splash-header" class="col-sm-12">
    <h1>Map the power with <strong>Oligrapher</strong></h1>
    <?php echo link_to('Oligrapher', 'http://littlesis.org/oligrapher') ?> is a new tool for visualizing networks of influence using LittleSis data.

    <br><br>

    <?php echo link_to('Get started on a new map', 'http://littlesis.org/maps/new', array('class' => 'btn btn-lg')) ?>
    <div id="splash-join">or <?php echo link_to('sign up', '@join') ?> for a LittleSis account</div>
  </div>
</div>

<div class="row hidden-xs splash-images">
  <div class="col-sm-4 splash-image">
      <?php echo link_to(image_tag('system/Dakota_Access_Pipeline.jpg'), 'http://littlesis.org/maps/1634-who-s-banking-on-the-dakota-access-pipeline') ?><br>
      <?php echo link_to("Who's Banking on the Dakota Access Pipeline?", 'http://littlesis.org/maps/1634-who-s-banking-on-the-dakota-access-pipeline') ?>
  </div>
  <div class="col-sm-4 splash-image">
    <?php echo link_to(image_tag('system/data-society-map.jpg'), 'http://littlesis.org/partypolitics') ?><br>
    <?php echo link_to('Big Data, Small World', 'http://littlesis.org/partypolitics') ?>
  </div>
  <div class="col-sm-4 splash-image">
    <?php echo link_to(image_tag('system/ferguson-map.jpg'), 'http://littlesis.org/maps/259-profiting-from-ferguson') ?><br>
    <?php echo link_to('Profiting from Ferguson', 'http://littlesis.org/maps/259-profiting-from-ferguson') ?>
  </div>
</div>

<div id="splash-more-maps">
  <?php echo link_to('View More Maps', 'http://littlesis.org/maps/featured', array('class' => 'btn btn-default btn-lg')) ?>
</div>

<!-- BOTTOM PART -->

<br />
<br />
<br />

<div id="homepage-subsplash-header">
A unique resource for investigating cronyism, conflicts of interest, and systemic corruption.
</div>

<div id="homepage-subsplash">

<a name="about"></a>

<div id="homepage-about">

<h3 class="homepage-subheader" style="margin-top: 0;">An involuntary facebook of the 1%</h3> 

We bring transparency to influential social networks by tracking the key relationships of politicians, business leaders, lobbyists, financiers, and their affiliated institutions. We help answer questions such as:<br />

<ul id="homepage-about-questions">
	<li>Who do the wealthiest Americans donate their money to?</li>
	<li>Where did White House officials work before they were appointed?</li>
	<li>Which lobbyists are married to politicians? Who do they lobby for?</li>
</ul>

All of this information is public, but scattered. We bring it together in one place. Our data derives from government filings, news articles, and other reputable sources. Some data sets are updated automatically; the rest is filled in by our user community. <nobr><?php echo link_to('More Features', '@features') ?></nobr>

<br />

<h3 class="homepage-subheader">Names behind the news</h3> 

Who are the movers and shakers behind the bailouts, government contracts, and austerity policies? We’re working around the clock to stock LittleSis with information about bigwigs who make the news, and their connections to those who don’t. For updates and analysis visit our blog, <nobr><?php echo link_to('Eyes on the Ties', 'http://blog.littlesis.org') ?></nobr>

<br />

<h3 class="homepage-subheader">Made for watchdogs</h3> 

We're bringing together a community of watchdogs who believe in transparency and accountability where it matters most. We're looking for journalists, researchers, programmers, artists and organizers to lend a hand. <nobr><?php echo link_to('Get Involved', '@join') ?></nobr>

<br />

<h3 class="homepage-subheader">Think-and-do tank</h3> 

LittleSis is a project of Public Accountability Initiative, a 501(c)3 organization focused on corporate and government accountability. We receive financial support from <?php echo link_to('foundations', 'http://public-accountability.org/about/funding/') ?> and benefit from free software written by the open source community.
</div>

<div id="homepage-data-summary">
<?php include_component('home', 'stats', array('filter' => true))?>
</div>

<div style="clear: both;">&nbsp;</div>
</div>

<!--
<div style="text-align: right; color: #ccc; font-size: 10px; font-style: italic; position: relative; top: 10px; padding-right: 10px;">
background art by <a href="http://www.google.com/search?q=mark+lombardi">Mark Lombardi</a>
</div>
-->

<script type="text/javascript">         
    $(document).ready(function(){               

        $(".littlesis-carousel li").shuffle();              
        $(".littlesis-carousel").tinycarousel({ 
          pager: true, 
          start: 1, 
          interval: true, 
          intervaltime: 5000, 
          rewind: true, 
          animation: true 
        });
        
    });
</script> 
