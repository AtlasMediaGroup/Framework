<?php

namespace CCF\Core\CCF\Interfaces;

/**
 * Controller interface
 */
interface Controller extends Common
{
	/**
	 * Set application instance
	 * @param \CCF\Core\CCF\Interfaces\App $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setApp(App $app);

	/**
	 * Set view instance
	 * @param \CCF\Core\CCF\Interfaces\App $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setView(View $view);

	/**
	 * Set page title
	 * @param string $app
	 * @return \CCF\Core\CCF\Interfaces\Controller
	 */
	public function setTitle($title);

	/**
	 * Get routes
	 * @return array
	 */
	public function getRoutes();

	/**
	 * Default action
	 */
	public function index();
}
