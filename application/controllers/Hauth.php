<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hauth Controller Class
 */
class Hauth extends CI_Controller {

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
    foreach ($this->hybridauth->HA->getProviders() as $provider_id => $params)
    {
      $providers[] = anchor("hauth/window/{$provider_id}", $provider_id);
    }

    $this->load->view('hauth/login_widget', array(
      'providers' => $providers,
    ));
  }

  /**
   * Try to authenticate the user with a given provider
   *
   * @param string $provider_id Define provider to login
   */
  public function window($provider_id)
  {
    $params = array(
      'hauth_return_to' => site_url("hauth/window/{$provider_id}"),
    );
    if (isset($_REQUEST['openid_identifier']))
    {
      $params['openid_identifier'] = $_REQUEST['openid_identifier'];
    }
    try
    {
      $adapter = $this->hybridauth->HA->authenticate($provider_id, $params);
      $profile = $adapter->getUserProfile();

      $this->load->view('hauth/done', array(
        'profile' => $profile,
      ));
    }
    catch (Exception $e)
    {
      show_error($e->getMessage());
    }
  }

  /**
   * Handle the OpenID and OAuth endpoint
   */
  public function endpoint()
  {
    $this->hybridauth->process();
  }

}
