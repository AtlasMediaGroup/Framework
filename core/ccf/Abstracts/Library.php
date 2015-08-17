<?php

namespace CCF\Core\CCF\Abstracts;

use \CCF\Core\CCF\Interfaces\App as AppInterface;
use \CCF\Core\CCF\Interfaces\Library as LibraryInterface;

/**
 * Library class
 * @abstract
 */
abstract class Library extends Common implements LibraryInterface
{
	/**
	 * Application instance
	 * @var \CCF\Core\CCF\Interfaces\App
	 */
	protected $app;

	/**
	 * Set application instance
	 * @param \CCF\Core\CCF\Interfaces\App $app
	 * @return \CCF\Core\CCF\Interfaces\Library
	 */
	public function setApp(AppInterface $app)
	{
		$this->app = $app;

		return $this;
	}
}
