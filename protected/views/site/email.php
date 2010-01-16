<div class="yiiForm">
<?= CHtml::beginForm(); ?>
	<div class="simple">
        <?php echo CHtml::activeLabel($form,'email_address' ); ?>
        <?php echo CHtml::activeTextField($form,'email_address', array( 'size' => '25', 'value'=> $_COOKIE['mehesznet_storedbyu_email'] ) ); ?>
	</div>

	<div class="simple">
        <?php echo CHtml::activeLabel($form,'subject' ); ?>
        <?php echo CHtml::activeTextField($form,'subject', array( 'size' => '30' ) ); ?>
	</div>

	<div class="simple">
        <?php echo CHtml::activeLabel($form,'body' ); ?>
        <?php echo CHtml::activeTextArea($form,'body', array( 'cols' => 30, 'rows' => 10 ) ); ?>
	</div>
	<?php if(! isset($_COOKIE['mehesznet_storedbyu_email']) ) : ?>
		<div class="simple">
        	<?php echo CHtml::activeLabel($form,'remember_me' ); ?>
    	    <?php echo CHtml::activeCheckbox($form,'remember_me' ); ?>
		</div>
	<?php endif; ?>

	<div class="simple">
		<label for="send">&nbsp;</label>
        <?php echo CHtml::submitButton('send'); ?>
	</div>

<?= CHtml::endForm(); ?>
</div>
<div style="text-align:center;width:100%;font-size:12px;color:#777;margin-top:10px;">
	<strong>NOTE:</strong> the email will be delivered from <br /><i>noreply-DVD-stored-by-u@mehesz.net</i>
</div>
<?php exit(); ?>
