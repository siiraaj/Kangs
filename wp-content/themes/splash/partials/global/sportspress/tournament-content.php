<?php if(!is_layout('magazine_one') && !is_layout('soccer_two')) get_template_part('partials/global/title-box'); ?>
<?php $sp_format = get_post_meta(get_the_ID(), "sp_format"); ?>
<div class="stm-format-<?php echo esc_attr($sp_format[0]);?>">
    <?php the_content(); ?>
</div>
