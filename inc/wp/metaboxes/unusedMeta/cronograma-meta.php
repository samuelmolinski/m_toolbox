<div id="meta_control">
		
	<p>
		<?php $metabox->the_field('date'); ?>
		<label for="<?php $metabox->the_name(); ?>">Data: </label>
		<input type="hidden" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"  />
		<input type="text" name="<?php $metabox->the_name(); ?>-show" value="<?php $metabox->the_value(); ?>"  />
	</p>
	
	<p>
		<?php $metabox->the_field('facebook'); ?>
		<label for="<?php $metabox->the_name(); ?>">Facebook URL: </label>
		<input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"  />
	</p>
	
	<div class="meta-textarea">
		<?php $metabox->the_field('descricao'); ?>
		<label for="<?php $metabox->the_name(); ?>">Descrição: </label>
		<textarea name="<?php $mb->the_name(); ?>" rows="6"><?php $mb->the_value(); ?></textarea>
	</div>
	<div class="meta-textarea">
		<?php $metabox->the_field('solucao'); ?>
		<label for="<?php $metabox->the_name(); ?>">Solução: </label>
		<textarea name="<?php $mb->the_name(); ?>" rows="6"><?php $mb->the_value(); ?></textarea>
	</div>
 
 	<div class="clear"></div>
</div>