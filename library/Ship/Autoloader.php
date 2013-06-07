<?php

/**
 * GitShip.com PHP Library
 *
 * @copyright GitShip.com
 *
 * @author GitShip.com
 * @link http://www.GitShip.com
 *
 * @license This software and associated documentation (the "Software") may not be
 * used, copied, modified, distributed, published or licensed to any 3rd party
 * without the written permission of GitShip.com
 *
 * The above copyright notice and this permission notice shall be included in
 * all licensed copies of the Software.
 *
 */
namespace Ship;

class Autoloader {

	/**
	 * @var \Ship\Autoloader
	 */
	protected static $_instance = null;

	/**
	 * Singleton instance.
	 */
	protected function __construct() {

		set_include_path ( implode ( PATH_SEPARATOR, array (
				realpath ( APPLICATION_PATH ),
				get_include_path ()
		) ) );
		spl_autoload_register ( function ($className) {
		    if (!strstr($className, "Routes")) {
		        return;
		    }
			if (! class_exists ( $className, false )) {
				$path =  realpath(
				    __DIR__ . '/../' .
				    implode(
				        DIRECTORY_SEPARATOR,
				        explode(
				            '\\',
				            $className
				        )
				    ) . '.php');
				if ($path) {
					include $path;
				}
			}
		}, null, true );
	}

	/**
	 * Retrieve an instance of \Ship\Autoloader which initiates the
	 * autoloader onto the top of the autoloading stack.
	 * @return \Ship\Autoloader
	 */
	public static function getInstance() {
		if (null == self::$_instance) {
			self::$_instance = new self ();
		}

		return self::$_instance;
	}
}