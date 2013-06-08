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

/**
 * Service
 */
abstract class Service
{
	/**
	 * Retrieve a database connection
	 * @return \MongoDB
	 */
	protected static function getDatabaseConnection()
	{
	    global $appSettings;
	    $mongo = new \Mongo($appSettings['mongoDbConnection']);
	    return $mongo->selectDB($appSettings['mongoDbDatabase']);
	}
}