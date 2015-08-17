<?php

namespace CCF\Core\CCF\Abstracts;

use \CCF\Core\CCF\Interfaces\Common as CommonInterface;

/**
 * Common class
 * @abstract
 */
abstract class Common implements CommonInterface
{
	/**
	 * Common setters and getters
	 *
	 * @param string $name
	 * @param mixed $arguments
	 * @throws \CCF\Core\CCF\Exception
	 * @return $this
	 */
	public function __call($name, $arguments)
	{
		$action = substr($name, 0, 3);

		if ( $action == 'get' || $action == 'set' ) {
			$property = lcfirst(substr($name, 3));

			if ( property_exists($this, $property) ) {
				$reflection = new \ReflectionObject($this);

				if ( $reflection->getProperty($property)->isPublic() ) {
					if ( $action == 'get' ) {
						return $this->{$property};
					} else {
						$this->{$property} = $arguments ? $arguments[0] : null;

						return $this;
					}
				}
			}
		}

		throw new \Swiftlet\Exception('Not implemented: ' . get_called_class() . '::' . $name);
	}
}
