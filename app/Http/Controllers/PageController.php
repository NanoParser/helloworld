<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use JonnyW\PhantomJs\Client;

class PageController extends Controller
{
    public function pagenotfound()
    {
        return view('404');
    }
    public function index()
    {
        $client = Client::getInstance();
       // $client->getEngine()->setPath('~/PhpstormProjects/helloworld/bin/phantomjs');
        $client->getEngine()->setPath('../bin/phantomjs');
        $client->isLazy(); // Tells the client to wait for resources
        //$client->getEngine()->setPath('phantomjs');

        $request = $client->getMessageFactory()->createRequest('http://searchengines.guru/showthread.php?t=957693', 'GET');
        $request->setTimeout(10000);
        $response = $client->getMessageFactory()->createResponse();

// Send the request
        $client->send($request, $response);

        if($response->getStatus() === 200)
        {
            $contents = $response->getContent();
        }
        else
        {
            dd($response->getStatus());
        }

        $html = HtmlDomParser::str_get_html($contents);
        $i = 0;
        foreach ($html->find('.yap-title-block__text_inner') as $element)
        {
            $nodes [$i]['title'] = $element->innertext();
            $i++;
        }
        $i = 0;
        foreach ($html->find('img.yap-picture-block__image') as $element)
        {
            $nodes [$i]['img'] = $element->getAttribute('src');
            $file = file_get_contents('http:'.$nodes[$i]['img']);
            $filename = 'img/'.str_random(4).'img.png';
            $save = file_put_contents($filename, $file);
            $i++;
        }
        //yap-body-text
        $i = 0;
        foreach ($html->find('.yap-body-text') as $element)
        {
            $nodes [$i]['body'] = $element->plaintext;
            $i++;
        }
        $i = 0;
        foreach ($html->find('.yap-domain__text') as $element)
        {
            $nodes [$i]['domain'] = $element->plaintext;
            $i++;
        }



        return view('index', compact('nodes'));
    }
}
