<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hybridauth Class
 */
class Hybridauth {

  /**
   * Reference to the Hybrid_Auth object
   *
   * @var	Hybrid_Auth
   */
  public $HA;

  /**
   * Reference to CodeIgniter instance
   *
   * @var CI_Controller
   */
  protected $CI;

  /**
   * Class constructor
   *
   * @param array $config
   */
  public function __construct($config = array())
  {
    $this->CI =& get_instance();
    // Load the HA config.
		if (!$this->CI->load->config('hybridauth')) {
      log_message('error', 'Hybridauth config does not exist.');
      return;
    }

    // Get HA config.
		$config = $this->CI->config->item('hybridauth');

		// Specify base url to HA Controller.
    $config['base_url'] = $this->CI->config->site_url('hauth/endpoint');

    // Load HA library.
		$this->_init();

		// Initialize Hybrid_Auth.
		$this->HA = new Hybrid_Auth($config);

    log_message('info', 'Hybridauth Class is initialized.');
  }

  /**
   * Process the HA request
   */
  public function process() {
    $this->_init('Hybrid_Endpoint');

    Hybrid_Endpoint::process();
  }

  /**
   * Initialize HA library
   *
   * @param string $class_name Define HA class to load
   */
  protected function _init($class_name = 'Hybrid_Auth') {
    list($dir, $filename) = explode('_', $class_name);

    if (class_exists($class_name)) {
      // Nothing to do here. Most probably the class is loaded by composer_autoload.
    }
    elseif (file_exists(APPPATH . "third_party/hybridauth/hybridauth/{$dir}/{$filename}.php")) {
      // In case when the library is placed in third_party/hybridauth.
      require_once APPPATH . "third_party/hybridauth/hybridauth/{$dir}/{$filename}.php";
    }
    elseif (file_exists(FCPATH . 'vendor/autoload.php')) {
      // Finally try to load the given class from CI autoload.
      require_once FCPATH . 'vendor/autoload.php';
    }

    if (!class_exists('Hybrid_Auth')) {
      log_message('error', "Could not load the {$class_name} class.");
      return;
    }

    log_message('info', "{$class_name} class is loaded.");
  }

}
