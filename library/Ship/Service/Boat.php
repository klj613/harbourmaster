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
     * Create a boat record, but if the boat already exists then we use return
     * the existing boat record instead. No duplication and all.
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
    public function addBoat($url, $tags)
    {
        if (!is_array($tags)) {
            throw new \Exception('tags was expected to be an array.');
        }

        // Check if the URL already exists.
        $existingBoat = $this->getBoatByUrl($url);
        if (is_array($existingBoat)) {
            return $existingBoat;
        }

        $now = new \MongoDate(time());

        $boat = array();
        $boat['cd'] = new \MongoDate(time());
        $boat['u'] = $url;
        $boat['t'] = $this->cleanTags($tags);

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
     * Retrieve a single boat based on the URL
     *
     * @param string $url
     * @return array|null
     */
    public function getBoatByUrl($url)
    {
        $query = array(
            'u' => $url
        );

        $collection = static::getDatabaseConnection()->boats;
        /* @var $collection \MongoCollection */
        $record = $collection->findOne($query, array('_id', 't', 'u'));
        return $record;
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

        $sortFields = array('t', 'cd', 't');
        $sortDirections = array(1, -1);
        $randomField = rand(0, (count($sortFields) - 1));
        $randomDirection = rand(0, (count($sortDirections) - 1));
        $sortBy = array($sortFields[$randomField] => $sortDirections[$randomDirection]);

        $collection = static::getDatabaseConnection()->boats;
        /* @var $collection \MongoCollection */
        $records = $collection->find($query, array('_id', 't', 'u'))
            ->sort($sortBy)
            ->limit(100);

        $use = 1;
        $count = $records->count(true);
        if ($count > 0) {
            $use = rand(1, $count);
        }

        $return = null;
        $i = 0;
        foreach ($records as $rec) {
            $i++;
            if ($i != $use) {
                continue;
            }
            $return = $rec;
            break;
        }
        return $return;
    }

    /**
     * Clean the tags sent by the query.
     *
     * @param array $tags
     * @return multitype:string
     */
    private function cleanTags($tags)
    {
        $final = array();
        foreach ($tags as $tag) {
            // Replace all non-alphanumeric characters.
            $trimmed = trim(preg_replace("/[^A-Za-z0-9 ]/", '', $tag));
            if (!empty($trimmed)) {
                $final[] = mb_strtolower($trimmed);
            }
        }

        return $final;
    }

    /**
     * Retrieve the count of boats.
     *
     * @return integer
     */
    private function getCount()
    {
        $collection = static::getDatabaseConnection()->boats;
        /* @var $collection \MongoCollection */
        $count = $collection->count();
        if ($count) {
            return $count;
        }
        return 0;
    }
}