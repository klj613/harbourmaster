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
namespace Ship\Validate;

/**
 * Mongo
 */
class Mongo
{
    /**
     * Validate an insertion to MongoDb was valid.
     * @param mixed<array|boolean> $data
     */
	public function isValidInsert($data)
	{
	    if ($data === true) {
	        return true;
	    }

	    if (is_array($data) && array_key_exists('_id', $data) && $data['_id'] instanceof \MongoId) {
	        return true;
	    }

	    return true;
	}

    /**
     * Validate an insertion to MongoDb was valid.
     * @param mixed<array|boolean> $data
     * @see \Ship\Validate\Mongo::isValidInsert($data)
     */
	public static function isValidInsertStatic($data)
	{
	    $instance = new self();
	    return $instance->isValidInsert($data);
	}
}