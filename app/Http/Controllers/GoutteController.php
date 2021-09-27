<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;


class GoutteController extends Controller
{
    public function doWebScraping(Request $request)
    {
        //  $title = 'hie';
        //  $price = 'hie';
        //  $engine = 'hie';
        //  $year = 'hie';
        global $x;
        $x = 0;
        $goutteClient = new Client();
        $guzzleClient = new GuzzleClient(array(
            'timeout' => 60,
            'verify' => false
        ));
        $goutteClient->setClient($guzzleClient);
        $crawler = $goutteClient->request('GET', $_GET['url']);
        // get title
        $crawler->filter('.car-info-flex-box H1')->each(function ($node) {
            global $title;
            $title = $node->text();
            // dump($node->text());
        });

        //get engine size
        $crawler->filter('.pickup-specification-text')->each(function ($node) {
            $GLOBALS['x'] = $GLOBALS['x'] + 1;
            global $engine;
            // $engine = $node[2]->text();

            // dump($GLOBALS['x']);
            if($GLOBALS['x'] == 3){
                $engine =$node->text();
            }
        });

        //get year of make
        $crawler->filter('.pickup-specification-text')->each(function ($node) {
            $GLOBALS['x'] = $GLOBALS['x'] + 1;

            global $year;
            // dump($GLOBALS['x']);
            if($GLOBALS['x'] == 7){
                $year =$node->text();
            }
            // dump($node->text());
            // $year = $node[1]->text();
        });
        //get price
        $crawler->filter('#fn-vehicle-price-total-price')->each(function ($node) {
            global $price;
            $price = $node->text();
        });


        return response()->json([
            'title'=>$GLOBALS['title'],
            'price'=>$GLOBALS['price'],
            'engine'=>$GLOBALS['engine'],
            'year'=>$GLOBALS['year']
        ]);
    }
}
