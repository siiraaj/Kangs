<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

splash_enqueue_modul_scripts_styles('stm_block_quote');

$ico = "icon-icon_testimonials";
if(is_layout("baseball")) $ico = "icon-ico_qoute";
if(!empty($bq_icon)) $ico = $bq_icon;
?>
<div class="stm-block-quote-wrapper <?php echo $blockquote_style; ?>">
	<div class="stm-block-quote-icon">
		<i class="<?php echo esc_html($ico); ?>"></i>
	</div>
	<div class="stm-block-quote">
		<?php echo esc_html($atts['bq_text']); ?>
        <?php if($blockquote_style == 'style_3') {?>
            <div class="author">
                <?php if(!empty($author)) echo esc_html($author);?>
            </div>
        <?php }?>
	</div>
</div>
