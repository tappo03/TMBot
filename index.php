<?php
$update = file_get_contents('php://input');
$update = json_decode($update,TRUE);

$token = "1003055329:AAGZnR3mDNFzUrDu7zvEoLDIIKmy90vvR9o";
$request = "https://api.telegram.org/bot".$token;

$text = $update['message']['text'];
$userID = $update['message']['from']['id'];
$chatId = $update['message']['chat']['id'];
$name = $update['message']['from']['first_name'];
$surname = $update['message']['from']['last_name'];
$username = $update['message']['from']['username'];

$titleGroup = $update['message']['chat']['title'];
$usernameGroup = $update['message']['chat']['username'];
$typeChat = $update['message']['chat']['type'];
$inviteLinkChat = $update['message']['chat']['invite_link'];

$message_id = $update['message']['message_id'];

$query = $update['callback_query'];
$queryID = $query['id'];
$queryUserID = $query['from']['id'];
$queryName = $query['from']['first_name'];
$querySurname = $query['from']['last_name'];
$queryUsername = $query['from']['username'];
$queryData = $query['data'];
$queryMsgID = $query['message']['message_id'];

$devMode = false;
$rand = rand(1,1000);

$json = json_encode($update,JSON_PRETTY_PRINT);

  if($queryData == "answerQuery"){
    answerQuery($queryID,"Ciao $queryName! Come stai?");
  }
  if($queryData == "tast3"){
    editMessageText($queryUserID,$queryMsgID,"Ciao!");
  }

  $tastierainline = '[{"text":"Tastiera 1","url":"t.me/LorenzoTM88"},{"text":"Tastiera 2","callback_data":"answerQuery"}],[{"text":"Tastiera 3","callback_data":"tast3"}]';
  $cmd = '["Comandi del Bot"]';
  $tastierafisica = '["Tastiera 1"],["Tastiera 2","Tastiera 3"],["Tastiera 4"]';


  if($devMode == false){
if($text == "/start"){
  sendMessage($chatId,"Ciao $name!\nQuesta è la base per bot ufficiale di <a href='t.me/LorenzoTM88'>LorenzoTM88</a>!\nClicca il button qua sotto per vedere cosa faccio!",$cmd,"fisica");
}
if($text == "Comandi del Bot"){
  sendMessage($chatId,"Comandi:\n/tfisica => Tastiera Fisica\n/tinline => Tastiera Inline\n/rand => Numero Random da 1 a 1000\n/info => Info Utente\n/update => Update del Bot");
}
if($text == "/tinline"){
  sendMessage($chatId,"Ecco a te una tastiera inline!",$tastierainline,"inline");
}
if($text == "/tfisica"){
  sendMessage($chatId,"Ecco a te una tastiera fisica!",$tastierafisica,"fisica");
}
if($text == "/rand"){
  sendMessage($chatId,"Numero random => $rand");
}
if($text == "/update"){
  sendMessage($chatId,"Update del bot:\n$json");
}
if($text == "/info"){
  $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $chatId";
  sendMessage($chatId,$msg);
}
  }

  
  if($devMode == true){
    if($text == "/start"){
      sendMessage($chatId,"Hey, il bot è attualmente in manutenzione :(");
    }
  }


  function sendMessage($chatId,$text,$key,$type){
    if(isset($key)){
      if($type == "fisica"){
        $keyboard = '&reply_markup={"keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
      else {
        $keyboard = '&reply_markup={"inline_keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
    }
    $url = $GLOBALS[request]."/sendMessage?chat_id=$chatId&parse_mode=HTML&text=".urlencode($text).$keyboard;
    file_get_contents($url);
  }

  function answerQuery($callback_query_id,$text){
    $url = $GLOBALS[request]."/answerCallbackQuery?callback_query_id=$callback_query_id&text=".urlencode($text);
    file_get_contents($url);
  }

  function editMessageText($chatId,$message_id,$newText,$key,$type)
  {
    if(isset($key)){
      if($type == "fisica"){
        $keyboard = '&reply_markup={"keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
      else {
        $keyboard = '&reply_markup={"inline_keyboard":['.urlencode($key).'],"resize_keyboard":true}';
      }
    }
    $url = $GLOBALS[request]."/editMessageText?chat_id=$chatId&message_id=$message_id&parse_mode=HTML&text=".urlencode($newText);
    file_get_contents($url);
  }
?>
