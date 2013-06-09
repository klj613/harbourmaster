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
namespace Ship\Service;

use Ship\Exception\DatabaseInsertFailed;
use Ship\Service;

/**
 * Boat
 */
class Boat extends Service
{
    /**
     * Create a boat record
     *
     * @param string $url
     * @param array $tags (optional)
     * @return array
     * @throws \Exception
     * @example
     *     $service = new \Ship\Service\Boat();
     *     $service->addBoat(
     *         'http://25.media.tumblr.com/tumblr_lod3zgOWsu1qmlz9do1_500.jpg',
     *         array(
     *             'boat',
     *             'rubber duck',
     *             'duck',
     *             'yellow'
     *         )
     *     );
     */
    public static function addBoat($url, $tags)
    {
        if (!is_array($tags)) {
            throw new \Exception('tags was expected to be an array.');
        }

        $now = new \MongoDate(time());

        $boat = array();
        $boat['cd'] = new \MongoDate(time());
        $boat['u'] = $url;
        $boat['t'] = $tags;

        $collection = static::getDatabaseConnection()->boats;
        /* @var $collection \MongoCollection */
        $insert = $collection->insert(
            $boat,
            array(
                "safe" => true
            )
        );

        if (\Ship\Validate\Mongo::isValidInsertStatic($insert)) {
            return $boat;
        }

        throw new DatabaseInsertFailed('Insert to Mongo failed');
    }

    /**
     * Retrieve a single boat based on an array of tags.
     *
     * @param array $tags
     * @throws \Exception
     * @return array|null
     */
    public function getBoat($tags)
    {
        if (!is_array($tags)) {
            throw new \Exception('tags was expected to be an array.');
        }

        $tags = $this->cleanTags($tags);
        $query = array();

        if (!empty($tags)) {
            $query = array(
                't' => array('$in' => $tags),
            );
        }

        $collection = static::getDatabaseConnection()->boats;
        /* @var $collection \MongoCollection */
        $record = $collection->findOne($query, array('_id', 't', 'u'));
        return $record;
    }

    private function cleanTags($tags)
    {
        $final = array();
        foreach ($tags as $tag) {
            $trimmed = trim($tag);
            if (!empty($trimmed)) {
                $final[] = $trimmed;
            }
        }

        return $final;
    }
}