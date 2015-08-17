<?php

namespace CCF\Core\CCF\Abstracts;

use \CCF\Core\CCF\Interfaces\App as AppInterface;
use \CCF\Core\CCF\Interfaces\Controller as ControllerInterface;
use \CCF\Core\CCF\Interfaces\View as ViewInterface;

/**
 * Controller class
 * @abstract
 */
abstract class Controller extends Common implements ControllerInterface
{
	/**
	 * Application instance
	 * @var \CCF\Core\CCF\Interfaces\App
	 */
	protected $app;

	/**
	 * View instance
	 * @var \CCF\Core\CCF\Interfaces\View
	 */
	protected $view;

	/**
	 * Page title
	 * @var string
	 */
	protected $title;

	/**
	 * Routes
	 * @var array
	 */
	protected $routes = array();

	/**
	 * Set application instance
	 * @param \CCF\Core\CCF\Interfaces\App $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setApp(AppInterface $app)
	{
		$this->app = $app;

		return $this;
	}

	/**
	 * Set view instance
	 * @param \CCF\Core\CCF\Interfaces\App $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setView(ViewInterface $view)
	{
		$this->view = $view;

		$reflection = new \ReflectionClass($this);

		$this->view->name = strtolower($reflection->getShortName());

		$this->view->pageTitle = $this->title;

		return $this;
	}

	/**
	 * Set page title
	 * @param string $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setTitle($title)
	{
		$this->title = $title;

		$this->view->pageTitle = $title;

		return $this;
	}

	/**
	 * Get routes
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Default action
	 */
	public function index()
	{ }
}
