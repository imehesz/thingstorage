<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<!-- top -->
<?php /*
		<div id="top">
			<div>
                <a href="#" class="tag tag1">4g communications</a>
                <a href="#" class="tag tag2">telecom jobs</a>
                <a href="#" class="tag tag3">RF design</a>
                <a href="#" class="tag tag4">LTE</a>
                <a href="#" class="tag tag5">3g ringtones</a>
            </div>

			<div>
                <a href="#" class="tag tag6">BREW</a>
                <a href="#" class="tag tag7">UMTS networks</a>
                <a href="#" class="tag tag8">Bluetooth gps</a>
                <a href="#" class="tag tag9">GIS</a>
                <a href="#" class="tag tag10">broadband internet</a>
            </div>

			<div>
                <a href="#" class="tag tag11">gsm mobile</a>
                <a href="/" class="logo"><img src="images/storedbyu_255x99.png" alt="stored.by.u" title="stored.by.u" /></a>
                <a href="#" class="tag tag12">WCDMA </a>
            </div>

			<div>
                <a href="#" class="tag tag13">j2me games</a>
                <a href="#" class="tag tag14">HSDPA games</a>
                <a href="#" class="tag tag15">Zigbee products</a>
                <a href="#" class="tag tag16">live video</a>
                <a href="#" class="tag tag17">wimax equipment </a>
            </div>

	  </div>
	  */ ?>

                <div style="width:100%;text-align:center;">
					<a href="/" class="logo"><img src="images/storedbyu_255x99.png" alt="stored.by.u" title="stored.by.u" /></a>
					<?php 
						$session = new CHttpSession;
						$session -> open();
						if( $session['mehesznet_storedbyu_flash_message'] ) :
					?>
					<script language="javascript">
						$(document).ready(function() {
							$('#flash_message').fadeOut(3000);
						 });
					</script>
					<div id="flash_message" style="padding:5px;font-size:20px;background-color:#348781;color:#fff;margin:0px 200px 0px 200px;"><?= $session['mehesznet_storedbyu_flash_message'] ?></div>
					<?php $session['mehesznet_storedbyu_flash_message'] = ''; endif; ?>
				</div>
<!-- search and menus -->

		<div style="margin-top:15px;">

<!-- main menu -->
<?php /*
			<div id="menu">
				<a href="Hardware_Vendors_Equipment_Manufacturers">Equipment</a>
				<a href="Mobile_Applications_Software_Development">Applications</a>
				<a href="Wireless_Telecom_Services_Resources">Resources</a>
				<a href="Operators_Carriers_Service_Providers">Operators</a>
				<a href="/Agencies_Organizations_Regulatory">Agencies</a>

				<a href="/Telecommunications_Distribution">Distribution</a>


				<a href="#" class="more">more</a>

				<div class="moredisplay">
					<a href="http://www.3gwirelessjobs.com">Jobs &amp; Employment</a>
					<a href="Products/Mobile_Cell_Phones_Accessories">Mobile Phones</a>
					<a href="http://forum.3gwirelessjobs.com" >Forums</a>
				    <a href="Products">Products</a>
				    <a href="/news/">News</a>

					<a href="/facts/">Interesting</a>
								</div>
			</div>

 */ ?>
<!-- search -->
			<div id="search">
						<!-- Google CSE Search Box Begins  -->
						<form action="?r=site/list" method="post">
						<fieldset>
						  <input type="text" name="name" size="45" id="searchField" value="SEARCH HERE ..." onClick="javascript:if(this.value=='SEARCH HERE ...'){this.value=''};" onBlur="javascript:if(this.value.length==0){this.value='SEARCH HERE ...';}" />
						  <div class="b">
								<input  type="image" src="/images/search.gif"/>
						  </div>
						  </fieldset>
						
			</div>
            <div style="margin:0 auto;width:200px;margin-top:5px;">
                <span><input type="radio" id="moboco" name="moboco" value="movie" onclick="$('#infobox').fadeOut();" checked/> movies</span>
                <span><input type="radio" id="moboco" name="moboco" value="book" onfocus="$('#infobox').fadeIn();"/> books</span>
                <span><input type="radio" id="moboco" name="moboco" value="comic" disabled /> comics</span>
            </div>
            </form>
			<div id="infobox" class="yellow-infobox">
				Use the <strong>ISBN</strong> number of the book (only the numbers!)
			</div>
			<div class="amazon-ad">
				<iframe src="http://rcm.amazon.com/e/cm?t=mehesznet-20&o=1&p=13&l=ur1&category=dvd&banner=1Y6X580CSWSE2JYBZ6R2&f=ifr" width="468" height="60" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
			</div>

<!-- browse by -->
            <?php /*
			<div id="browse">
				browse by: <a href="/Technology">Technology</a> <a href="/show">Country</a> <a href="/show/metroarealist">Metro area</a> <a href="/show/letter/">Alphabetical</a>

			</div>
            */ ?>
		</div>
