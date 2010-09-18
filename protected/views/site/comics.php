<?php $this->renderPartial( '_toplikebottom' );?>

<?php if( sizeof( $comics ) > 0) : ?>
<table id="box-table-a">
<thead>
    <tr>
        <th scope="col">volume</th>
        <th scope="col">title</th>
        <th scope="col">issue</th>
        <th scope="col">year</th>
        <?php /* <th scope="col">last cached</th> */ ?>
    </tr>
</thead>
<tbody>
     <?php foreach( $comics as $comic ) : ?>
        <tr alt="click for more info" title="click for more info" onclick="javascript:$('#info_<?php echo $comic->cvID; ?>').show();">
            <td><?php echo $comic->volume; ?></td>
            <td><?php echo $comic->name; ?></td>
            <td><?php echo $comic->issue; ?></td>
            <td><?php echo $comic->year == 0 ? 'n/a' : $comic->year; ?></td>
        </tr>
        <tr class="nohover" id="info_<?php echo $comic->cvID;?>" style="display:none;">
            <td class="nohover">
				<img src="<?php echo $comic->image; ?>" />
			</td>
            <td class="nohover" colspan="3" style="font-size:12px;" id="info_summary_<?php echo $comic->cvID; ?>">
				<p style="max-width:500px;"><?php echo $comic->description ;?></p>
				<p><br /></p>
                <a  class="thickbox" href="<?php echo $this->createUrl( 'site/email', array( 'height' => 375, 'width' => 425, 'id' => $comic->id ) );?>">send email</a> | <a href="<?php echo $comic->url; ?>" alt="in a new window" title="in a new window" target="_blank">check on ComicVine</a> | <a href="javascript:void(0);" onClick="javascript:$('#info_<?php echo $comic->cvID ?>').hide();">close</a>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
</table>
<?php else: ?>
  <div style="font-weight:bolder;padding:25px;width:100%;font-size:36px;color:#ddd;text-align:center;">
    No matches found for `<i><?php echo $_POST['name']; ?></i>` :|
      <div><a href="<?php echo $this->createUrl( 'site/search');?>" style="color:#00f;font-size:12px;font-weight:normal;">please try again</a></div>
  </div>
<?php endif;?>
