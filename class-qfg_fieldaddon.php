<?php

GFForms::include_addon_framework();

class QFGFieldAddOn extends GFAddOn {

	protected $_version = QFG_FIELD_ADDON_VERSION;
	protected $_min_gravityforms_version = '1.9';
	protected $_slug = 'qfgravity';
	protected $_path = 'quantity-field-for-gravity-form/qfg_fieldaddon.php';
	protected $_full_path = __FILE__;
	protected $_title = 'Gravity Forms Quantity Field Add-On';
	protected $_short_title = 'Quantity Field Add-On';

	/**
	 * @var object $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @return object $_instance An instance of this class.
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Include the field early so it is available when entry exports are being performed.
	 */
	public function pre_init() {
		parent::pre_init();
		if ( $this->is_gravityforms_supported() && class_exists( 'GF_Field' ) ) {
			require_once( 'includes/class-qfg_field.php' );
		}
	}

	public function init_admin() {
		parent::init_admin();
		add_filter( 'gform_tooltips', array( $this, 'tooltips' ) );
		add_action( 'gform_field_appearance_settings', array( $this, 'field_appearance_settings' ), 10, 2 );
		add_action( 'gform_editor_js_set_default_values', array( $this, 'set_defaults' ) );
	}


	    /**
	 * Set default values when adding a slider
	 *
	 * @since    0.1
	 */
    function set_defaults() {
    	?>
    	    case "Qfg_field" :
    	    	field.label = "Quantity";
    	    break;
    	<?php
    } // end set_defaults


	// # SCRIPTS & STYLES -----------------------------------------------------------------------------------------------

	/**
	 * Include idf_script_js when the form contains a 'Edfield' type field.
	 *
	 * @return array
	 */
	public function scripts() {
		$scripts = array(
			array(
				'handle'  => 'qf_script_js',
				'src'     => $this->get_base_url() . '/js/qf_script.js',
				'version' => $this->_version,
				'deps'    => array( 'jquery' ),
				'enqueue' => array(
					array( 'field_types' => array( 'Qfg_field' ) ),
				),
			),

		);

		return array_merge( parent::scripts(), $scripts );
	}

	/**
	 * Include idf_styles.css when the form contains a 'Edfield' type field.
	 *
	 * @return array
	 */
	public function styles() {
		$styles = array(
			array(
				'handle'  => 'qf_css',
				'src'     => $this->get_base_url() . '/css/qf_styles.css',
				'version' => $this->_version,
				'enqueue' => array(
					array( 'field_types' => array( 'Qfg_field' ) )
				)
			)
		);

		return array_merge( parent::styles(), $styles );
	}


	// # FIELD SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Add the tooltips for the field.
	 *
	 * @param array $tooltips An associative array of tooltips where the key is the tooltip name and the value is the tooltip.
	 *
	 * @return array
	 */
	public function tooltips( $tooltips ) {
		$Edfield_tooltips = array(
			'id_class_setting' => sprintf( '<h6>%s</h6>%s', esc_html__( 'Input CSS Classes', 'qfgravity' ), esc_html__( 'The CSS Class names to be added to the field input.', 'qfgravity' ) ),
		);

		return array_merge( $tooltips, $Edfield_tooltips );
	}

	/**
	 * Add the custom setting for the Edfield field to the Appearance tab.
	 *
	 * @param int $position The position the settings should be located at.
	 * @param int $form_id The ID of the form currently being edited.
	 */
	public function field_appearance_settings( $position, $form_id ) {
		// Add our custom setting just before the 'Custom CSS Class' setting.
		if ( $position == 250 ) {
			?>
			<li class="id_class_setting field_setting">
				<input id="id_class_setting" type="text" class="fieldwidth-1" onkeyup="SetInputClassSetting(jQuery(this).val());" onchange="SetInputClassSetting(jQuery(this).val());"/>
			</li>

			<?php
		}
	}
}