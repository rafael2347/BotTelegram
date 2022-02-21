<?php
$token = '5129627253:AAFywW6wyOl0SPTAt8DY-rHWg-kjUE_IhWM';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatType = $update["message"]["chat"]["id"];
$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];
/*Declaro las variabes para poder usar los emoticonos por todo mi código*/
$periodicoemo=" 📰 ";
$emoticono_deportes=' 🏅 ';
$golf=' ⛳ ';
$moto=' 🏍️ ';
$formula1=' 🏎️ ';
$deportes=' ⚽ ';
$tecnologia='👨‍💻';
$hola='🙋‍♂️';
$info='ℹ️';
$ayuda='🆘';
$tiempo='⛅';
// $reply = $update['message']['reply_to_message']['text'];
//Este switch almacena todos los comandos en los que podremos interactuar en nuestro bot
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
        $response = 'Hola! Hoy va a ser tu mejor día, que nadie te lo unda, tu vales mucho';
        sendMessage($chatId, $response);
        break;
    case '/help':
        $response = '/start: Inicia el bot,
        /hola '.$hola.': Te anima el día,
        /info '.$info.': Te dice quien es,
        /help '.$ayuda.': Te ayuda que comandos puedes poner en este bot
        /noticias '.$periodicoemo.': Te enseña todos los periodicos en los que puedes consultar las noticias
        /deportes '.$emoticono_deportes.': Accedes a las noticias dedicadas sobre deportes
        /tecnologia '.$tecnologia.': Accedes a nuestra parte de tecnología
        /tiempo'.$tiempo.': Te muestra las noticias sobre el tiempo';
        sendMessage($chatId, $response);
        break;
    case '/noticias':
        $response = 'Hola! has pulsado el comando de noticias '.$periodicoemo.', porfavor pulsa para ver la noticias de ese periodico:
         Ideal '.$periodicoemo.': /ideal
         El mundo '.$periodicoemo.': /elmundo
         New York Times '.$periodicoemo.': /newyork
         EuropaExpress '.$periodicoemo.': /europapress
         La Vanguardia '.$periodicoemo.': /vanguardia
         El Pais '.$periodicoemo.': /elpais';
        sendMessage($chatId, $response);
        break;
    case '/deportes':
        $response='Has pulsado el comando de Deportes '.$emoticono_deportes.', porfavor pulsa para ver los deportes de ese periodico:
        El Marca '.$deportes.': /marca
        El AS de Formula 1 '.$formula1.': /As_formula1
        El AS de Motos '.$moto.': /As_motos
        El periodico Sport '.$deportes.': /sport
        El periodico Sport de Golf '.$golf.': /sportgolf
        El periodico El pais deportes '.$emoticono_deportes.': /deporteselpais';


        sendMessage($chatId, $response);
        break;

        case '/tecnologia':
            $response='Has pulsado el comando de Tecnologia '.$tecnologia.', pulsa que tecnologia quieres ver:
Tecnologia del país '.$tecnologia .': /Tecnologia';
            sendMessage($chatId, $response);
            break;
        case '/tiempo':
            $response='Has pulsado el comando de Tiempo '.$tiempo.', pulsa que tiempo quieres ver:
 Noticias el tiempo '.$tiempo .': /eltiempo';
            sendMessage($chatId, $response);
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
    case '/marca':
        ElMarca($chatId);
        break;
    case '/europapress':
        getNoticias($chatId);
        break;
    case '/vanguardia':
        vanguardia($chatId);
        break;
    case '/As_formula1':
        ASformula1($chatId);
        break;
    case '/As_motos':
        ASmotos($chatId);
        break;
    case '/sport':
        Sport($chatId);
        break;
    case '/sportgolf':
        Sportgolf($chatId);
        break;
    case '/elpais':
        Elpais($chatId);
        break;
    case '/Tecnologia':
        tecnologia($chatId);
        break;
    case '/deporteselpais':
        elpaisdeportes($chatId);
        break;
    case '/eltiempo':
        elpaisdeportes($chatId);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
}

/**
 * sendMessage envia el mensaje nuestro bot
 *
 * @param  mixed $chatId
 * @param  mixed $response
 * @return void
 */
function sendMessage($chatId, $response/*, $repl*/) {
    // if ($repl == TRUE){
    //     $replay_mark = array ('force_reply' => True);
    //     $url = $GLOBALS[website].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&reply_markup='.json_encode($replay_mark).'&text='.urlencode($response);
    // }else{

        $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
        file_get_contents($url);
    //}
}

/**
 * getNoticias te saca las noticias de europapress
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
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
Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}




/**
 * getNews te saca noticias del periodico el mundo
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
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
Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}



/**
 * getIdeal te saca noticias del ideal
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
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
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}
/**
 * NewYork te saca las noticias del New York Times
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
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
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/**
 * ElMarca te saca las noticias del marca
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function ElMarca($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://e00-marca.uecdn.es/rss/futbol/granada.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}



/**
 * vanguardia te saca noticias de la vanguardia
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function vanguardia($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://www.lavanguardia.com/rss/home.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/**
 * ASformula1 te saca noticias sobre formula 1
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function ASformula1 ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
    $url="https://as.com/rss/motor/formula_1.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}
/**
 * ASmotos te saca noticias sobre motos
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function ASmotos ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://as.com/rss/motor/motociclismo.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}
/**
 * Sport te saca noticias de deportes
 * 
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function Sport ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://www.sport.es/es/rss/last-news/news.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/** 
 * Sportgolf te saca noticias del golf
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function Sportgolf ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://www.sport.es/es/rss/golf/rss.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/**
 * Elpais te saca noticias del periodico El Pais
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function Elpais ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/portada";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/**
 * tecnologia te saca noticias sobre tecnología
 *
 * @param  mixed $chatId es donde almacena la información del periodico;
 * @return void
 */
function tecnologia ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/section/tecnologia/portada";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

/**
 * elpaisdeportes te saca los deportes del periodico El Pais
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function elpaisdeportes ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="https://feeds.elpais.com/mrss-s/pages/ep/site/elpais.com/section/deportes/portada";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}


/**
 * eltiempo te saca noticias del tiempo
 *
 * @param  mixed $chatId es donde almacena la información del periodico
 * @return void
 */
function eltiempo ($chatId) {
    include("simple_html_dom.php");
    $context=stream_context_create(array('http' => array('header' => "Accept: application/xml")));
   
    $url="http://www.aemet.es/xml/municipios/localidad_18087.xml";

    $xmlstring= file_get_contents($url, false, $context);

    $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
    $json =json_encode($xml);
    $array = json_decode($json, TRUE);

    for($i=0; $i<9; $i++){
        $titulos = $titulos. "\n\n".$array['channel']['item'][$i]['title']."<a href='".$array['channel']['item'][$i]['link']."'>
 Pincha aquí para más información</a>";
        
    }

    sendMessage($chatId, $titulos);


}

?>