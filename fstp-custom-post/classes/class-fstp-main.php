<?php

class FSTP_Main
{
	public function __construct( $fileds, $post, $taxonomies ) {
		$fileds->register_fields();
		$post->register_post();
		$taxonomies->register_taxonomies();
		
		//TGM Plugin Activation
		//add_action( 'tgmpa_register', array( $this, 'fstp_register_required_plugins') );

		add_action( 'admin_init', array( $this, 'check_version' ) );

        // Don't run anything else in the plugin, if we're on an incompatible WordPress version
        if ( ! self::compatible_version() ) {
            return;
        }

        // Description: Parent Plugin should be installed and active to use this plugin.
        add_action( 'admin_init', array( $this, 'child_plugin_has_parent_plugin' ) );

	}

    // The primary sanity check, automatically disable the plugin on activation if it doesn't
    // meet minimum requirements.
    // @source {https://pento.net/2014/02/18/dont-let-your-plugin-be-activated-on-incompatible-sites/}
    public static function activation_check() {
        if ( ! self::compatible_version() ) {
            deactivate_plugins( plugin_basename( FSTP_PLUGIN_PATH . 'fstp-custom-post.php' ) );
            wp_die( __( 'My Plugin requires WordPress 3.7 or higher!', 'fstpcp' ) );
        }
        // flush rewrite rules
        flush_rewrite_rules();
        //echo 'Test activation!';
    }

    public function deactivate() {
        // flush rewrite rules
        flush_rewrite_rules();
    }

    // The backup sanity check, in case the plugin is activated in a weird way,
    // or the versions change after activation.
    function check_version() {
        if ( ! self::compatible_version() ) {
            if ( is_plugin_active( plugin_basename( FSTP_PLUGIN_PATH . 'fstp-custom-post.php' ) ) ) {
                deactivate_plugins( plugin_basename( FSTP_PLUGIN_PATH . 'fstp-custom-post.php' ) );
                add_action( 'admin_notices', array( $this, 'disabled_notice' ) );
                if ( isset( $_GET['activate'] ) ) {
                    unset( $_GET['activate'] );
                }
            }
        }
    }

    function disabled_notice() {
       echo '<strong>' . esc_html__( 'My Plugin requires WordPress 3.7 or higher!', 'fstpcp' ) . '</strong>';
    }

    public static function compatible_version() {
        if ( version_compare( $GLOBALS['wp_version'], '3.7', '<' ) ) {
            return false;
        }

        // Add sanity checks for other version requirements here

        return true;
    }

    // Description: Parent Plugin should be installed and active to use this plugin.
    // @source {https://wordpress.stackexchange.com/questions/127818/how-to-make-a-plugin-require-another-plugin}
    // @source {https://gist.github.com/dianjuar/9a398c9e86a20a30868eee0c653e0ca4}
    // @source {https://wordpress.stackexchange.com/questions/189208/check-for-dependent-plugin-and-if-false-dont-activate-plugin}
    function child_plugin_has_parent_plugin() {
        if ( is_admin() && current_user_can( 'activate_plugins' ) &&  !is_plugin_active( 'advanced-custom-fields/acf.php' ) && is_plugin_active( plugin_basename( FSTP_PLUGIN_PATH . 'fstp-custom-post.php' ) ) ) {
            add_action( 'admin_notices', array( $this, 'child_plugin_notice' ) );
            deactivate_plugins( plugin_basename( FSTP_PLUGIN_PATH . 'fstp-custom-post.php' ) ); 
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    }

    function child_plugin_notice(){
        echo '<div class="error">' . sprintf(
					__( "FSTP Custom Post requires Advanced Custom Fields plugin to be installed and active!", 'fstpcp' ) ) . '</div>';
    }
}