<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<?php $this->renderPartial( '_toplikebottom' );?>
<?php if( $book ) : ?>

<div style="width:500px;margin:0 auto;">
<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$book,
    'attributes'=>array(
        'title',
        'author',
        'summary:html',
        'publisher',
        'isbn:text:ISBN',
        'isbn13:text:ISBN-13',
    ),
));
?>
<a  class="thickbox" href="<?= $this -> createUrl( 'site/emailbook', array( 'height' => 375, 'width' => 425, 'id' => $book->id ) );?>">send email</a>
<?php print CHtml::link('back to search', $this->createUrl('site/search') ); ?>
</div>
<?php else: ?>
  <div style="font-weight:bolder;padding:25px;width:100%;font-size:36px;color:#ddd;text-align:center;">
    No matches found for `<i><?= $_POST['name']; ?></i>` :|
      <div><a href="<?= $this -> createUrl( 'site/search');?>" style="color:#00f;font-size:12px;font-weight:normal;">please try again</a></div>
  </div>
<?php endif;?>
