<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script language="javascript">
	var loadMovieInfo = function( imdbID, selectorID )
	{
		// jQuery.ajax({'url':'index.php?r=plan/updatedays','success':updatePlanDays,'data':'uid=&pid=','cache':false}); 
		jQuery.ajax({'url':'index.php?r=site/loadmovieinfo','success':displayExtendedInfo,'data':'id='+imdbID,'cache':false}); 
//		alert( 'imdbID:' + imdbID + ' selectorID:' + selectorID );
	}

	var displayExtendedInfo = function( data, textStatus )
	{
		if( textStatus == 'success' )
		{
			if( data != 'fail' )
			{
				movieObj = eval( '(' + data + ')' );
				$('#movie_' + movieObj['imdbID'] ).html(
					'<strong>Year:</strong> ' + movieObj['year'] + '<br />' +
					'<strong>Runtime:</strong> ' + movieObj['runtime'] + '<br />' +
					'<strong>Genre:</strong> ' + movieObj['genre'] + '<br />' +
					'<strong>Summary:</strong> ' + movieObj['summary']
				);
				$('#ajaxloader_' + movieObj['imdbID']).html( '' );
				return true;
			}
		}
		alert( 'error :/ please try again, sorry' );
	}
</script>


<div id="toplikebottom">
    <a href="/"><img src="images/storedbyu_100x39.png" alt="stored.by.u" title="stored.by.u" border="0" style="margin-bottom:10px;"/></a>
    <?php /* <span style="width:100%;text-align:right;font-size:36px;font-weight:bolder;color:#ddd;">movies</span> */ ?>
<span style="margin-left:350px;">	<script type="text/javascript"><!--
google_ad_client = "pub-1319358860215477";
/* stored by u - top banner */
google_ad_slot = "2721322499";
google_ad_width = 468;
google_ad_height = 60;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</span>
</div>

<?php if( sizeof( $movies ) > 0) : ?>
<table id="box-table-a">
<thead>
    <tr>
        <th scope="col">imdbID</th>
        <th scope="col">title</th>
        <th scope="col">year</th>
        <?php /* <th scope="col">last cached</th> */ ?>
    </tr>
</thead>
<tbody>
     <?php foreach( $movies as $movie ) : ?>
        <tr alt="click for more info" title="click for more info" onclick="javascript:$('#info_<?=$movie->imdbID?>').show(); loadMovieInfo( '<?= $movie->imdbID ?>', 'info_summary_<?= $movie -> imdbID; ?>' );">
            <td><?= $movie -> imdbID; ?></td>
            <td><?= $movie -> title; ?></td>
            <td><?= $movie -> year; ?></td>
            <?php /* <td style="font-size:10px;"><?= date('\o\n l, F jS Y', $movie -> updated); ?></td> */ ?>
        </tr>
        <tr class="nohover" id="info_<?=$movie->imdbID;?>" style="display:none;">
            <td class="nohover">
				<span style="font-size:10px;" id="ajaxloader_<?= $movie->imdbID; ?>"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/ajax-loader.gif" /><br />loading ...</span>
			</td>
            <td class="nohover" colspan="3" style="font-size:12px;" id="info_summary_<?= $movie->imdbID; ?>">
                <div id="movie_<?= $movie->imdbID; ?>"></div>
				<p></p>
                <a  class="thickbox" href="<?= $this -> createUrl( 'site/email', array( 'height' => 350, 'width' => 400, 'id' => $movie->imdbID ) );?>">send email</a> | <a href="http://www.imdb.com/title/tt<?= $movie->imdbID; ?>" alt="in a new window" title="in a new window" target="_blank">check on IMDB</a> | <a href="javascript:void(0);" onClick="javascript:$('#info_<?= $movie->imdbID ?>').hide();">close</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
  <div style="font-weight:bolder;padding:25px;width:100%;font-size:36px;color:#ddd;text-align:center;">
    No matches found for `<i><?= $_POST['name']; ?></i>` :|
      <div><a href="<?= $this -> createUrl( 'site/search');?>" style="color:#00f;font-size:12px;font-weight:normal;">please try again</a></div>
  </div>
<?php endif;?>
