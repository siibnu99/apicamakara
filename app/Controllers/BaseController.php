<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['auth', 'menu', 'filesystem'];

	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
		$this->session = \Config\Services::session();
		$this->TryoutModel = new \App\Models\TryoutModel;
		$this->QuizModel = new \App\Models\QuizModel;
		$this->SoaltModel = new \App\Models\SoaltModel;
		$this->SoalqModel = new \App\Models\SoalqModel;
		$this->MytryoutModel = new \App\Models\MytryoutModel;
		$this->AnswertModel = new \App\Models\AnswertModel;
		$this->UserapiModel = new \App\Models\UserApiModel;
		$this->UserModel = new \Myth\Auth\Models\UserModel;
		$this->TopupModel = new \App\Models\TopupModel;
		$this->Uuid = new \App\Libraries\Uuid;
		$this->serverside_model = new \App\Models\Serverside_model();
	}
}
