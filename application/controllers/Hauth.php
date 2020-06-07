<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */
class Hauth extends CI_Controller
{

	/**
	 * {@inheritdoc}
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->load->library('hybridauth');
	}

	/**
	 * {@inheritdoc}
	 */
	public function index()
	{
		// Build a list of enabled providers.
		$providers = array();
		foreach ($this->hybridauth->HA->getProviders() as $name) {
			$uri = 'hauth/window/' . strtolower($name);
			$providers[] = anchor($uri, $name);
		}

		$this->load->view('hauth/login_widget', array(
			'providers' => $providers,
		));
	}

	/**
	 * Try to authenticate the user with a given provider
	 *
	 * @param string $provider Define provider to login
	 */
	public function window($provider)
	{
		try {
			$adapter = $this->hybridauth->HA->authenticate($provider);
			$profile = $adapter->getUserProfile();

			$this->load->view('hauth/done', array(
				'profile' => $profile,
			));
		} catch (Exception $e) {
			show_error($e->getMessage());
		}
	}
}
