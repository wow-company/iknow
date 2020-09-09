<?php
/**
 * Search form
 *
 * @package Iknow
 */
$iknow_search_btn_color = get_theme_mod( 'iknow_search_button_color_scheme', 'is-success' );
$iknow_btn_light        = ! empty( get_option( 'iknow_search_button_color_light', '' ) ) ? ' is-light' : '';
?>
<form role="search" method="get" id="searchform" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<?php $iknow_form_id = rand( 100, 9999 ); ?>
    <div class="field has-addons">
        <div class="control has-icons-left is-expanded">
            <label class="screen-reader-text"
                   for="s<?php echo absint( $iknow_form_id ); ?>"><?php esc_html_x( 'Search for:', 'label', 'iknow' ); ?></label>
            <input type="text" value="<?php the_search_query(); ?>" name="s"
                   id="s<?php echo absint( $iknow_form_id ); ?>"
                   placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'iknow' ); ?>"
                   class="input"/><span class="icon is-small is-left"><i class="icon-search"></i></span>
        </div>
        <div class="control">
            <input type="submit" value="<?php esc_attr_e( 'Search', 'iknow' ); ?>"
                   class="button <?php echo esc_attr( $iknow_search_btn_color . $iknow_btn_light ); ?>"/>
        </div>
    </div>
</form>
