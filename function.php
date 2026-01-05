###############################################

Last Child Product Archive Function.php 

###############################################

// Elementor template IDs from Theme Builder.
const ELEM_TMPL_HAS_CHILDREN = 31605; // Category Archive
const ELEM_TMPL_LEAF         = 31629; // All Product Archives

add_action('template_redirect', function () {
    if ( ! is_tax('product_cat') ) return;

    $term = get_queried_object();
    if ( ! $term || is_wp_error($term) ) return;

    // Detect children (even empty ones).
    $children = get_terms([
        'taxonomy'   => 'product_cat',
        'parent'     => $term->term_id,
        'hide_empty' => false,
        'fields'     => 'ids',
    ]);

    $tpl_id = empty($children) ? ELEM_TMPL_LEAF : ELEM_TMPL_HAS_CHILDREN;

    if ( class_exists('\Elementor\Plugin') && get_post_status($tpl_id) ) {
        // Render with the same wrappers WoodMart/WooCommerce use on archive pages.
        get_header('shop');

        // Open content wrappers, breadcrumbs, etc.
        do_action('woocommerce_before_main_content');

        // (Optional) archive header bits. Comment out if your Elementor template already has its own header.
        do_action('woocommerce_shop_loop_header');

        echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($tpl_id);

        // Close wrappers.
        do_action('woocommerce_after_main_content');

        // Sidebar (WoodMart puts it here when layout isn’t left)
        do_action('woocommerce_sidebar');

        get_footer('shop');
        exit;
    }
});

##CSS

/* Style for category card */
.wd-cat-inner.wrapp-category {
    text-align: left;
    background: #fff;
    filter: drop-shadow(0px 4px 35px rgba(0, 0, 0, 0.05));
   
    overflow: hidden;
}
/* Image styling */
.wd-cat-inner.wrapp-category .wd-cat-thumb img, .wd-post-thumb img {
    display: block;
    width: 100% !important;
    height: 380px !important;
    object-fit: contain !important;
}

.wd-cat-inner.wrapp-category .wd-cat-content {
    padding: 20px !important;
}
.no-sub-cat {
  display: none;
}
.wd-product:not(.wd-hover-small) :is(.product-image-link,.hover-img) :is(picture,img){
   width: 100% !important;
    height: 350px !important;
    object-fit: con !important;
}

/* When category HAS children: hide the products list + its pagination */

body.cat-has-children .elementor-widget-wc-archive-products,
body.cat-has-children .wd-loop-footer, .wd-single-post-header .wd-post-meta, .wd-post-cat.wd-style-with-bg {
	display: none !important; 
}
/* When category has NO children: hide the categories grid */

body.cat-no-children .elementor-widget-wc-categories { 
	display: none !important; 
}

 
/* Remove bullets from all items in this specific Elementor icon list */
.wd-dropdown-menu .elementor-icon-list-items {
    list-style: none !important;
    padding-left: 0 !important; /* also removes indentation */
}

.wd-dropdown-menu .elementor-icon-list-item::marker {
    content: none !important; /* hides any marker in modern browsers */
}
