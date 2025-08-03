<?php
/**
 * Plugin Name:       Visual Content Builder
 * Description:       A visual layout builder for WordPress.
 * Version:           1.0.0
 * Author:            Gemini
 * Text Domain:       visual-content-builder
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Enqueue the editor assets.
 *
 * @since    1.0.0
 */
function visual_content_builder_enqueue_assets() {

    // Only load on the post edit screen.
    $screen = get_current_screen();
    if ( 'post' !== $screen->base && 'page' !== $screen->base ) {
        return;
    }

	// Enqueue the script.
	wp_enqueue_script(
		'visual-content-builder-editor',
		plugin_dir_url( __FILE__ ) . 'build/index.js',
		array( 'wp-element', 'wp-components', 'wp-api-fetch' ),
		'1.0.0',
		true
	);

    // Enqueue the style.
    wp_enqueue_style(
		'visual-content-builder-editor-style',
		plugin_dir_url( __FILE__ ) . 'build/index.css',
		array(),
		'1.0.0'
	);
}
add_action( 'admin_enqueue_scripts', 'visual_content_builder_enqueue_assets' );

/**
 * Add a button to the editor to launch the visual builder.
 *
 * @since    1.0.0
 */
function visual_content_builder_add_editor_button() {
    // Only add the button to post and page edit screens
    $screen = get_current_screen();
    if ( 'post' !== $screen->base && 'page' !== $screen->base ) {
        return;
    }
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            function addLaunchButton() {
                var editorToolbar = document.querySelector('.edit-post-header__toolbar');
                if (editorToolbar) {
                    var ourButton = document.createElement('button');
                    ourButton.innerHTML = 'Launch Visual Builder';
                    ourButton.classList.add('components-button', 'is-primary');
                    ourButton.onclick = function() {
                        // We will launch our React app here.
                        // For now, it will just be an alert.
                        // In the future, this will mount our React component.
                        var editorContainer = document.getElementById('editor');
                        if(editorContainer){
                            editorContainer.innerHTML = '<div id="visual-builder-root"></div>';
                             // This is where we would bootstrap the React app
                        }
                        alert('Visual Builder Launched!');
                    };
                    editorToolbar.appendChild(ourButton);
                }
            }

            // The Gutenberg editor loads asynchronously, so we need to wait for it.
            var observer = new MutationObserver(function(mutations, me) {
              var editorToolbar = document.querySelector('.edit-post-header__toolbar');
              if (editorToolbar) {
                addLaunchButton();
                me.disconnect(); // stop observing
                return;
              }
            });

            observer.observe(document.body, {
              childList: true,
              subtree: true
            });
        });
    </script>
    <?php
}
add_action( 'admin_footer', 'visual_content_builder_add_editor_button' );

/**
 * Add a div for our React app to mount to.
 *
 * @since 1.0.0
 */
function add_visual_builder_mount_point() {
    echo '<div id="visual-builder-root"></div>';
}
// We'll need a more robust way to trigger this, but for now,
// let's add it to the admin footer.
add_action( 'admin_footer', 'add_visual_builder_mount_point' );

