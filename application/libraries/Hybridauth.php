<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hybridauth Class
 */
class Hybridauth
{

	/**
	 * Reference to the Hybrid_Auth object
	 *
	 * @var Hybridauth\Hybridauth
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
		$this->CI = &get_instance();

		// Load the HA config.
		if (!$this->CI->load->config('hybridauth')) {
			log_message('error', 'Hybridauth config does not exist.');

			return;
		}

		// Get HA config.
		$config = $this->CI->config->item('hybridauth');

		try {
			// Initialize Hybrid_Auth.
			$this->HA = new Hybridauth\Hybridauth($config);

			log_message('info', 'Hybridauth Class is initialized.');
		} catch (Exception $e) {
			show_error($e->getMessage());
		}
	}
}
