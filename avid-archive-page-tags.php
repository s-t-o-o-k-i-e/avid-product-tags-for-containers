<?php
/*
Plugin Name: 05 AVID Product Tag Display for Archive Page
Description: Displays product tags to the product pages
Version: 1.0
Author: AVID-MIS
Author URI: www.avid.com.ph
*/

function enqueue_styles_for_archive_tags() {
    wp_enqueue_style('woocommerce-style', get_template_directory_uri() . '/woocommerce.css');
    $inline_css = "

        .tag-area-close{
            visibility:hidden;
            color:black;
        }
        .tag-icon{
            background:#f5d100;
            border-radius:100%;
            width: 30px;
            height:30px;
            border:solid 3px #f5d100;
            position:absolute;
            bottom:5px;
            right:5px;
            visibility:hidden;
        }
        .tag{
            color: black!important;
            font-family: poppins;
            font-size: 11px;
            padding-left:2px;
            padding-right:2px;
            margin-right:2px;
            white-space: nowrap;
            line-height:1.8;
        }
        .tag-grouped{
            background:#fccd00;
        }
        .tag-solo{
            cursor:default;
            user-select: none;
            -moz-user-select: none;
            -khtml-user-select: none;
            -webkit-user-select: none;
            -o-user-select: none;
        }
        .tag-solo:focus{
            outline: none;
        }
        .product .tag-area{
            background-color: #dcdddd;
            height:7px;
            position:absolute;
            width:100%;
            margin:auto!important;
            left:0;
            right:0;
            line-height:0;
            bottom:0;
            padding:0;
            overflow-y:scroll;
            padding-left:2px;
            padding-right:2px;
            border-top:7px solid #7e7d82;
            transition: height 0.5s;
            -webkit-transition: height 0.5s;
            z-index:2;
        }
        .tag-area:hover, .tag-icon:hover + .tag-area{
            height:60px;
            border-top:7px solid transparent;
            z-index:2;
        }
        .tag-area::-webkit-scrollbar {
            display: none;
        }
        @media screen and (max-width: 767px){
            .tag-icon{
                visibility:visible;
                z-index:1;
            }
            .product .tag-area{
                border-top:0;
                height:0;
                padding-right:30px;
            }
            .product .tag-area:hover{
                height:60px;
                border-top:7px solid #dcdddd;
            }
            .tag{
                padding-left:5px;
                padding-right:5px;
                font-weight: bold !important;
                margin-left:5px;
                margin-right:5px;
            }
            .tag-grouped{
                border-radius:5px;
            }
            .tag-area-close{
                background:black;
                border:solid 3px black;
                padding-top:10px;
                padding-bottom:8px;
                border-radius:100%;
                visibility:visible;
                position: absolute;
                right:5px;
                top:0;
                color:#dcdddd;
            }
            .tag-area:has(.tag-area-close:hover){
                height:0;
            }
        }
    ";

    wp_add_inline_style('woocommerce-style', $inline_css);
}
add_action('wp_enqueue_scripts', 'enqueue_styles_for_archive_tags');

function display_categories_and_tags() {
        $plugin_url = plugin_dir_url(__FILE__);
        $tag_image_url = $plugin_url . 'tag-icon.webp';
        global $product;
        $product_tags = get_the_terms($product->get_id(), 'product_tag');
        if ($product_tags && !is_wp_error($product_tags)) {
            echo '<div class="tag-icon"><img src="' . esc_url($tag_image_url) . '" class="tag-icon-image" alt="tag icon that displays product tags"></div><div class="tag-area">';
            foreach ($product_tags as $tag) {
                $tag_link = get_term_link($tag);
                if (!is_wp_error($tag_link)) {
                    $tag_count = $tag->count;
                    if ($tag_count > 1){
                        echo '<a href="' . esc_url($tag_link) . '" class="tag tag-grouped">' . esc_html($tag->name) . '</a>';}
                    else {
                        echo '<span class="tag tag-solo" onclick="return false;">' . esc_html($tag->name) . '</span>';    
                    }
            }}
            echo '<div class="tag-area-close">▼</div></div>';
        }
    
}
add_action('woocommerce_after_shop_loop_item_title', 'display_categories_and_tags');
