<?php
$token = '5129627253:AAFywW6wyOl0SPTAt8DY-rHWg-kjUE_IhWM';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatType = $update["message"]["chat"]["id"];
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
// $repl = $update['message']['reply_to_message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado, para comenzar pon /help para ver los comandos que puedes utilizar';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'Hola! Soy @NoticiasUltimaHoraa_bot mi creador es Rafael González';
        sendMessage($chatId, $response);
        break;
    case '/hola':
        $response = 'Hola! Hoy va a ser tu mejor día';
        sendMessage($chatId, $response);
        break;
    case '/help':
        $response = '/start: Inicia el bot,
        /hola: Te anima el día,
        /info: Te dice quien es,
        /help: Te ayuda que comandos puedes poner en este bot
        /noticias: Te enseña las noticias de Europa Press
        /elmundo: Te enseña las noticias de El Mundo
        /ideal: Te enseña las noticias del Ideal
        /newyork: Te enseña las noticias del New York Times';
        sendMessage($chatId, $response);
        break;
    case '/noticias':
        getNoticias($chatId);
        break;
    case '/elmundo':
        getNews($chatId);
        break;
    case '/ideal':
        getIdeal($chatId);
        break;
    case '/newyork':
        NewYork($chatId);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
}

function sendMessage($chatId, $response, $repl) {
    // if ($repl == TRUE){
    //     $replay_mark = array ('force_reply' => True);
    //     $url = $GLOBALS[website].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($replay_mark).'&text='.urlencode($response);
    // }else{

        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
        file_get_contents($url);
    //}
}

function getNoticias($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://www.europapress.es/rss/rss.aspx";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
        +Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}




function getNews($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://e00-elmundo.uecdn.es/elmundo/rss/espana.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
        +Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}



function getIdeal($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://www.ideal.es/rss/2.0/portada";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
        +Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}
function NewYork($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://rss.nytimes.com/services/xml/rss/nyt/HomePage.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
        +Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}
?>