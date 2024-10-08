<?php
/*Plugin Name: bs Share Buttons
Plugin URI: https://bootscore.me/plugins/bs-share-buttons/
Description: Share Buttons for bootScore theme https://bootscore.me. Use Shortcode [bs-share-buttons] to display buttons in content or widget. Use <?php echo do_shortcode("[bs-share-buttons]"); ?&gt; to display in .php files.
Version: 1.0.1
Tested up to: 6.6
Requires at least: 5.0
Requires PHP: 7.4
Author: bootScore
Author URI: https://bootscore.me
License: MIT License
Text Domain: bootscore
*/




// Register Styles and Scripts
function bs_share_buttons_scripts() {
    
    wp_register_style( 'bs-share-style', plugins_url('css/bs-share-style.css', __FILE__) );
        wp_enqueue_style( 'bs-share-style' );
    }

add_action('wp_enqueue_scripts','bs_share_buttons_scripts');
// Register Styles and Scripts End





// Function to handle the thumbnail request
function get_the_post_thumbnail_src($img) {
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function bs_share_buttons($content) {
    global $post;
    if(is_singular() || is_home()){
    
        // Get current page URL 
        $bs_url = urlencode(get_permalink());
 
        // Get current page title
        $bs_title = str_replace( ' ', '%20', get_the_title());
        
        // Subject
        $bs_subject = __( 'Look what I found: ', 'bootscore' );

        // Get Post Thumbnail for pinterest
        $bs_thumb = get_the_post_thumbnail_src(get_the_post_thumbnail());
  
        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$bs_subject.' '.$bs_title.'&amp;url='.$bs_url;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$bs_url;
        $whatsappURL = 'whatsapp://send?text='.$bs_subject.' '.$bs_title . ' ' . $bs_url;
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$bs_url.'&amp;title='.$bs_title;
        $redditURL = 'http://reddit.com/submit?url='.$bs_url.'&amp;title='.$bs_title;
        $tumblrURL = 'http://www.tumblr.com/share/link?url='.$bs_url.'&amp;title='.$bs_title;
        $bufferURL = 'https://bufferapp.com/add?url='.$bs_url.'&amp;text='.$bs_title;
        $mixURL = 'http://www.stumbleupon.com/submit?url='.$bs_url.'&amp;text='.$bs_title;
        $vkURL = 'http://vkontakte.ru/share.php?url='.$bs_url.'&amp;text='.$bs_title;
        $mailURL = 'mailto:?Subject='.$bs_subject.' '.$bs_title.'&amp;Body='.$bs_title.' '.$bs_url.'';
        
       if(!empty($bs_thumb)) {
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$bs_url.'&amp;media='.$bs_thumb[0].'&amp;description='.$bs_title;
        }
        else {
            $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$bs_url.'&amp;description='.$bs_title;
        }
 
        // Based on popular demand added Pinterest too
        $pinterestURL = 'https://pinterest.com/pin/create/button/?url='.$bs_url.'&amp;media='.$bs_thumb[0].'&amp;description='.$bs_title;

        // Add sharing button at the end of page/page content
        $content .= '<div id="share-buttons" class="mb-3">';
        $content .= '<a class="mb-1 btn btn-sm btn-twitter" title="Twitter" href="'. $twitterURL .'" target="_blank" rel="nofollow"><i class="fa-brands fa-twitter"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-facebook" title="Facebook" href="'.$facebookURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-facebook-f"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-whatsapp" title="Whatsapp" href="'.$whatsappURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-whatsapp"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-pinterest" title="Pinterest" href="'.$pinterestURL.'" data-pin-custom="true" target="_blank" rel="nofollow"><i class="fa-brands fa-pinterest-p"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-linkedin" title="LinkedIn" href="'.$linkedInURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-linkedin-in"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-reddit" title="Reddit" href="'.$redditURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-reddit-alien"></i></a> '; 
        $content .= '<a class="mb-1 btn btn-sm btn-tumblr" title="Tumblr" href="'.$tumblrURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-tumblr"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-buffer" title="Buffer" href="'.$bufferURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-buffer"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-mix" title="mix" href="'.$mixURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-mix"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-vk" title="vk" href="'.$vkURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-vk"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-mail btn-dark" title="Mail" href="'.$mailURL.'"><i class="fa-solid fa-envelope"></i></a> ';
        $content .= '<a class="mb-1 btn btn-sm btn-print btn-dark" title="Print" href="javascript:;" onclick="window.print()"><i class="fa-solid fa-print"></i></a>';
        $content .= '</div>';
        
        return $content;
    } else{
        // if not a post/page then don't include sharing button
        return $content;
    }
};


// This will create a wordpress shortcode [share-buttons].
add_shortcode('bs-share-buttons','bs_share_buttons');


// Roughly fix https://github.com/bootscore/bs-share-buttons/issues/3
function bs_share_buttons_inline_script() {
    // Ensure jQuery is enqueued
    wp_enqueue_script('jquery');
    
    // Define the inline script
    $inline_script = "
    jQuery(document).ready(function($) {
        // Function to recursively search and remove unwanted text nodes
        function removeTextNodesWithText(node, textToRemove) {
            $(node).contents().each(function() {
                if (this.nodeType === 3) { // Text node
                    var text = $.trim(this.textContent);
                    if (text === textToRemove) {
                        $(this).remove(); // Remove text node
                    }
                } else if (this.nodeType === 1) { // Element node
                    removeTextNodesWithText(this, textToRemove); // Recur for child nodes
                }
            });
        }

        // Call the function to remove 'Array' text nodes
        removeTextNodesWithText($('body'), 'Array');
    });
    ";

    // Add the inline script
    wp_add_inline_script('jquery', $inline_script);
}

add_action('wp_enqueue_scripts', 'bs_share_buttons_inline_script');