<?php

namespace CCF\Core\CCF\Abstracts;

use \CCF\Core\CCF\Interfaces\App as AppInterface;
use \CCF\Core\CCF\Interfaces\Controller as ControllerInterface;
use \CCF\Core\CCF\Interfaces\Plugin as PluginInterface;
use \CCF\Core\CCF\Interfaces\View as ViewInterface;

/**
 * Plugin class
 * @abstract
 */
abstract class Plugin extends Common implements PluginInterface
{
	/**
	 * Application instance
	 * @var \CCF\Core\CCF\Interfaces\App
	 */
	protected $app;

	/**
	 * Controller instance
	 * @var \CCF\Core\CCF\Interfaces\Controller
	 */
	protected $controller;

	/**
	 * View instance
	 * @var \CCF\Core\CCF\Interfaces\View
	 */
	protected $view;

	/**
	 * Set application instance
	 * @param App $app
	 * @return View
	 */
	public function setApp(AppInterface $app)
	{
		$this->app = $app;

		return $this;
	}

	/**
	 * Set controller instance
	 * @param Controller $controller
	 * @return Plugin
	 */
	public function setController(ControllerInterface $controller)
	{
		$this->controller = $controller;

		return $this;
	}

	/**
	 * Set view instance
	 * @param View $view
	 * @return Plugin
	 */
	public function setView(ViewInterface $view)
	{
		$this->view = $view;

		return $this;
	}
}
