<?php
$token = '5129627253:AAFywW6wyOl0SPTAt8DY-rHWg-kjUE_IhWM';
$website = 'https://api.telegram.org/bot'.$token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

$chatId = $update['message']['chat']['id'];
$message = $update['message']['text'];

switch($message) {
    case '/start':
        $response = 'Me has iniciado';
        sendMessage($chatId, $response);
        break;
    case '/info':
        $response = 'Hola! Soy @NoticiasUltimaHoraa_bot';
        sendMessage($chatId, $response);
        break;
    case '/hola':
        $response = 'Hola! Hoy va a ser tu mejor día';
        sendMessage($chatId, $response);
        break;
    case '/help':
        $response = '/start: Inicia el bot
        /hola: Te anima el día
        /info: Te dice quien es';
        sendMessage($chatId, $response);
        break;
    default:
        $response = 'No te he entendido';
        sendMessage($chatId, $response);
        break;
}

function sendMessage($chatId, $response) {
    $url = $GLOBALS['website'].'/sendMessage?chat_id='.$chatId.'&parse_mode=HTML&text='.urlencode($response);
    file_get_contents($url);
}
?>