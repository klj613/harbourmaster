<?php
/* @var $app \Slim\Slim */
use Skinny\Form;

/**
 * Handles incoming GET requests to retrieve a boat.
 */
$app->get('/boat', function() use($app)
{
    if ($app->request()->isAjax()) {
        $tags = $app->request()->get('tags');
        $tags = explode(",", $tags);
        $query = array();
        if (is_array($tags) && !empty($tags)) {
            // Build Query
            $response = $app->response();
            $response->header('Content-Type', 'application/json');
            $query = array(); // Stub
            $service = new Ship\Service\Boat();
            $boat = $service->getBoat($tags);
            if (null != $boat) {
                $boat['id'] = $boat['_id']->{'$id'};
                unset($boat['_id']);
                $body = json_encode(array('total' => 1, 'boat' => $boat));
            } else {
                $body = json_encode(array('total' => 0, 'boat' => array()));
            }

            $response->body($body);
            return;
        }
        // Stub for locating from databe
    }
    $app->status(400);
});

/**
 * Handles incoming POST requests to save boats
 */
$app->post('/boat', function() use($app)
{
    $form = new Form();
    $form->addElement('url', true);
    $form->addElement('tags', true); // By specifying required as true, the NotEmpty validator is applied.

    $response = $app->response();
    $response->header('Content-Type', 'application/json');

    if ($form->isValid($app->request()->post())) {
        try {
            // Stub for save.
            $app->status(200); // Should be 201, but we want to return data as well.
            $response->body(
                json_encode(
                    array(
                        'success' => true,
                        'id' => 'todo'
                    )
                )
            );
        } catch (\Exception $e) {
            // TODO: Log
            $app->status(500);
            $response->body(
                json_encode(
                    array(
                        'success' => false,
                        'id' => '',
                        'error' => 'Save error'
                    )
                )
            );
        }
        return;
    }
    $app->status(400);
    $response->body(
        json_encode(
            array(
                'success' => false,
                'id' => '',
                'error' => 'Bad Request'
            )
        )
    );
    return;
});
