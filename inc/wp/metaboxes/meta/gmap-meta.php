<div id="meta_control">
	
	<!-- Can and in WP map to adjust position later -->
	<?php $metabox->the_field('lat'); ?>
	<input type="hidden" name="<?php $metabox->the_name(); ?>" id="gmap-lat" value="<?php $metabox->the_value(); ?>"  />	
	<?php $metabox->the_field('lng'); ?>
	<input type="hidden" name="<?php $metabox->the_name(); ?>" id="gmap-lng" value="<?php $metabox->the_value(); ?>"  />
	
	<?php renderGmap(); ?>
 
 	<div class="clear"></div>
</div>