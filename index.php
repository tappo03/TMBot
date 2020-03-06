<?php

//update
$update = json_decode(file_get_contents('php://input'), TRUE);

//token e richieste
$token = $_GET['api'];
$request = "https://api.telegram.org/bot".$token;

//variabili
$text = $update['message']['text'];
$userID = $update['message']['from']['id'];
$chatID = $update['message']['chat']['id'];
$name = $update['message']['from']['first_name'];
$surname = $update['message']['from']['last_name'];
$username = $update['message']['from']['username'];
$message_id = $update['message']['message_id'];

$titleGroup = $update['message']['chat']['title'];
$usernameGroup = $update['message']['chat']['username'];
$typeChat = $update['message']['chat']['type'];

$queryID = $update['callback_query']['id'];
$queryUserID = $update['callback_query']['from']['id'];
$queryChatID = $update['callback_query']['chat']['id'];
$queryName = $update['callback_query']['from']['first_name'];
$querySurname = $update['callback_query']['from']['last_name'];
$queryUsername = $update['callback_query']['from']['username'];
$queryData = $update['callback_query']['data'];
$queryMsgID = $update['callback_query']['message']['message_id'];

$rand = rand(1,1000);
$json = json_encode($update,JSON_PRETTY_PRINT);
$tastierainline = '[{"text":"Tastiera 1","url":"t.me/LorenzoTM88"},{"text":"Tastiera 2","callback_data":"answerQuery"}],[{"text":"Tastiera 3","callback_data":"tast3"}]';
$tastierafisica = '["Tastiera 1"],["Tastiera 2","Tastiera 3"],["Tastiera 4"]';
$cmd = '[{"text":"🆘 Comandi del Bot","callback_data":"cmd"}]';
$tornaindietro = '[{"text":"🔙 Torna Indietro","callback_data":"tornaindietro"}]';

$devMode = false;
$admin = [674965839];


//comandi
  if($devMode == false){
if($text == "/start"){
  sendMessage($chatID,"👋<b>Ciao $name</b>!\nQuesta è la base per bot ufficiale di <a href='t.me/LorenzoTM88'>LorenzoTM88</a>!\nClicca il button qua sotto per vedere cosa faccio!",$cmd,"inline");
}
if($text == "/test"){
  sendMessage($chatID,"AA");
}
if($text == "/tinline"){
  sendMessage($chatID,"Ecco a te una tastiera inline!",$tastierainline,"inline");
}

if($text == "/tfisica"){
  sendMessage($chatID,"Ecco a te una tastiera fisica!",$tastierafisica,"fisica");
}

if($text == "/rand"){
  sendMessage($chatID,"Numero random => $rand");
}

if($text == "/info"){
  if($typeChat == "private"){
  $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $chatId\nTipo Chat = Privata";
  sendMessage($chatID,$msg);
}
if($typeChat == "supergroup"){
  $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $userID\n\nInfo Chat\nTitolo = $titleGroup\nID = $chatID\nTipo Chat = Supergruppo";
  sendMessage($chatID,$msg);
}
if($typeChat == "group"){
  $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $userID\n\nInfo Chat\nTitolo = $titleGroup\nID = $chatID\nTipo Chat = Gruppo";
  sendMessage($chatID,$msg);
}
}

if(strpos($text,"/admin")=== 0 and in_array($userID,$admin)){
  sendMessage($chatID,"Hey, @$username è un admin del bot! ❤️");
}

if(strpos($text,"/say")=== 0){
  $mess = explode(" ",$text,2);
  $say = $mess[1];
  sendMessage($chatID,$say);
  deleteMessage($chatID,$message_id);
}


if($queryData == "answerQuery"){
  answerQuery($queryID,"Ciao $queryName!");
}

if($queryData == "tast3"){
  editMessageText($queryUserID,$queryMsgID,"Ciao $queryName!",$tornaindietro,"inline");
}

if($queryData == "tornaindietro"){
  editMessageText($queryUserID,$queryMsgID,"Ecco a te una tastiera inline!",$tastierainline,"inline");
}

if($queryData == "cmd"){
 editMessageText($queryUserID,$queryMsgID,"Comandi:\n/tfisica => Tastiera Fisica\n/tinline => Tastiera Inline\n/rand => Numero Random da 1 a 1000\n/info => Info Utente\n/admin => Comando solo per admin del bot\n/say => Per far inviare un messaggio al bot");
}
  }


  if($devMode == true){
    if($text == "/start"){
      sendMessage($chatID,"<b>Hey $name</b>, il bot è attualmente in manutenzione :(");
    }
  }


//funzioni
  function sendMessage($chatID,$text,$key = false, $type = false){
    if($key != false){
      if($type == "fisica"){
        $keyboard = '&reply_markup={"keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
      elseif($type == "inline"){
        $keyboard = '&reply_markup={"inline_keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
    }
    $url = $GLOBALS['request']."/sendMessage?chat_id=$chatID&parse_mode=HTML&disable_web_page_preview=true&text=".urlencode($text).$keyboard;
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        json_decode($output);
    }

  function editMessageText($chatID,$message_id,$newText,$key = false, $type = false)
  {
    if($key != false){
      if($type == "fisica"){
        $keyboard = '&reply_markup={"keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
      elseif($type == "inline"){
        $keyboard = '&reply_markup={"inline_keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
    }
    $url = $GLOBALS['request']."/editMessageText?chat_id=$chatID&message_id=$message_id&parse_mode=HTML&disable_web_page_preview=true&text=".urlencode($newText).$keyboard;
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        json_decode($output);
  }

  function answerQuery($callbackQueryID,$text){
    $url = $GLOBALS['request']."/answerCallbackQuery?callback_query_id=$callbackQueryID&text=".urlencode($text);
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        json_decode($output);
  }

  function deleteMessage($chatID,$message_id){
    $url = $GLOBALS['request']."/deleteMessage?chat_id=$chatID&message_id=$message_id";
    $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        json_decode($output);
  }
?>
