<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function ()
{

    $client = new \GuzzleHttp\Client();
    $url = "https://plentymarkets.kanbanize.com/index.php/api/kanbanize/get_all_tasks/format/json/";

    $response = $client->request("POST", $url,
        [
            'headers' => [
                'apikey' => 'n6KnmA67Rr8zxVC5lQ1AicudfVnt1h2mZQkvqm2K',
                'content-type' => 'application/json'
            ],
            'json' => [
                'boardid' => '50'
            ]
        ]);

    $body = $response->getBody();

    $sbody = json_decode($body, true);

    $archive = 0;

    foreach ($sbody as $bug) {

        if (strlen($bug['columnid']) && strpos($bug['columnid'], 'archive_636') === 0) {
            $archive++;

        }


    }

    return view('welcome')->with('body', json_encode($archive));
});
*/


