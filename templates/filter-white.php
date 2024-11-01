<?php
	use \TyresAddict\WFilter\Plugin;
?>

<div class="taw-filter">
	<form method="get" action="<?php echo $form_url; ?>">

	<div class="section section-top">
		<div class="title"><?=__('Wheel Size', Plugin::lang) ?></div>
	
		<select class="elem" name="width">
			<option value=""><?=__('Rim Width', Plugin::lang) ?></option>
			<?php foreach ( $wheel_width as $width ) : ?>
				<option <?php selected( $width, $r_width ); ?>
					value="<?php echo esc_attr( $width ); ?>">
					<?php echo esc_html( $width ); ?>''</option>
			<?php endforeach ?>
		</select>

		<select class="elem" name="r" class="dynamic" data-group="by-size">
			<option value=""><?=__('Rim Diameter', Plugin::lang) ?></option>
			<?php foreach ( $wheel_r as $r ) : ?>
				<option <?php selected( $r, $r_r ); ?>
					value="<?php echo esc_attr( $r ); ?>">
					R<?php echo esc_html( $r ); ?></option>
			<?php endforeach ?>
		</select>

		<select class="elem" name="pcd" class="dynamic" data-group="by-size">
			<option value=""><?=__('Bolt Pattern / PCD', Plugin::lang) ?></option>
			<?php foreach ( $wheel_pcd as $pcd ) : ?>
				<option <?php selected( $pcd, $r_pcd ) ?>
					value="<?php echo esc_attr( $pcd ); ?>">
					<?php echo esc_html( $pcd ); ?></option>
			<?php endforeach ?>
		</select>

		<select class="elem" name="dia" class="dynamic" data-group="by-size">
			<option value=""><?=__('Center Bore', Plugin::lang) ?></option>
			<?php foreach ( $wheel_dia as $dia ) : ?>
				<option <?php selected( $dia, $r_dia ) ?>
					value="<?php echo esc_attr( $dia ); ?>">
					d<?php echo esc_html( $dia ); ?></option>
			<?php endforeach ?>
		</select>

		<select class="elem" name="et" class="dynamic" data-group="by-size">
			<option value=""><?=__('Offset', Plugin::lang) ?></option>
			<?php foreach ( $wheel_et as $et_id => $et ) : ?>
				<option <?php selected( $et_id, $r_et ) ?>
					value="<?php echo esc_attr( $et_id ); ?>">
					<?php echo esc_html( $et ); ?></option>
			<?php endforeach ?>
		</select>

	</div>

	<div class="section">
		<div class="title"><?=__('Wheel Type', Plugin::lang) ?></div>

		<div class="elem">
			<input class="js-wheel-type js-wheel-type-all" id="tw-wheel-type-all" 
						data-type_id="all"
						autocomplete="off" type="checkbox" 
						<?php checked( 'all', $r_type ); ?>
						name="type" value="all">
			<label for="tw-wheel-type-all"><?=__( 'All', Plugin::lang ); ?></label>
		</div>
		<?php foreach ( $types as $type_id => $type ) : ?>
			<div class="elem">
				<input class="js-wheel-type js-wheel-type-<?=esc_attr( $type_id ); ?>" id="tw-wheel-type-<?=esc_attr( $type_id ); ?>" 
											data-wheel_type_id="<?=esc_attr( $type_id ); ?>"
											autocomplete="off" type="checkbox" 
											<?php checked( $type_id, $r_type ); ?>
											name="type" value="<?=esc_attr( $type_id ); ?>">
				<label for="tw-wheel-type-<?=esc_attr( $type_id ); ?>"><?=esc_html( $type ); ?></label>
			</div>
		<?php endforeach ?>
	</div>

	<div class="section">
		<div class="title"><?=__('Wheel Brand', Plugin::lang) ?></div>

		<div class="taw-brand-list">
		<div class="elem">
			<input class="js-wheel-brand js-wheel-brand-all" id="tw-wheel-brand-all" autocomplete="off" type="checkbox" 
						<?php \TyresAddict\WFilter\Woo::checked_multiple( 'all', $r_wheel_brand ); ?>
						name="wheel_brand[]" value="all">
			<label for="tw-wheel-brand-all"><?=__( 'All', Plugin::lang ) ?></label>
		</div>
		<?php foreach ( $brands as $brand ) : ?>
			<div class="elem">
				<input class="js-wheel-brand" id="tw-wheel-brand-<?=esc_attr( $brand ); ?>" 
						autocomplete="off" type="checkbox" 
						<?php \TyresAddict\WFilter\Woo::checked_multiple( $brand, $r_wheel_brand ); ?>
						name="wheel_brand[]" value="<?=esc_attr( $brand ); ?>">
				<label for="tw-wheel-brand-<?=esc_attr( $brand ); ?>"><?=esc_html( $brand ); ?></label>
			</div>
		<?php endforeach ?>
		</div>
	</div>

	<div class="taw-buttons">
		<button class="button wheel-filter"><?=__( 'Find Wheels', Plugin::lang ) ?></button>
		<button class="button js-twf-wheel-filter-reset" type="reset"><?=__( 'Reset', Plugin::lang ) ?></button>
	</div>

	</form>

</div>


