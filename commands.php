<?php
include __DIR__ . '/functions.php';
include __DIR__ . '/update.php';

$bot = new bot;
$tastierainline = '[{"text":"Tastiera 1","url":"t.me/LorenzoTM88"},{"text":"Tastiera 2","callback_data":"answerQuery"}],[{"text":"Tastiera 3","callback_data":"tast3"}]';
$tastierafisica = '["Tastiera 1"],["Tastiera 2","Tastiera 3"],["Tastiera 4"]';
$cmd = '[{"text":"🆘 Comandi del Bot","callback_data":"cmd"}]';
$tornaindietro = '[{"text":"🔙 Torna Indietro","callback_data":"tornaindietro"}]';
$config = json_decode(file_get_contents(__DIR__ . '/config.json'),TRUE);
$admin = $config['admins'];
$rand = mt_rand(1,1000);


if($config['dev_mode'] == false){
    if($text == "/start"){
        $bot->sendMessage($userID,"👋<b>Ciao $name</b>!\nQuesta è la base per bot ufficiale di <a href='t.me/LorenzoTM88'>LorenzoTM88</a>!\nClicca il button qua sotto per vedere cosa faccio!",$cmd,"inline");
    }
    if($text == "/tinline"){
        $bot->sendMessage($chatID,"Ecco a te una tastiera inline!",$tastierainline,"inline");
    }

    if($text == "/tfisica"){
        $bot->sendMessage($userID,"Ecco a te una tastiera fisica!",$tastierafisica,"fisica");
    }

    if($text == "/rand"){
        $bot->sendMessage($chatID,"Numero random => $rand");
    }

    if($text == "/info"){
        if($typeChat == "private"){
            $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $chatID\nTipo Chat = Privata";
            $bot->sendMessage($chatID,$msg);
        }
        if($typeChat == "supergroup"){
            $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $userID\n\nInfo Chat\nTitolo = $titleGroup\nID = $chatID\nTipo Chat = Supergruppo";
            $bot->sendMessage($chatID,$msg);
        }
        if($typeChat == "group"){
            $msg = "<b>Info Utente</b>\nNome = $name\nCognome = $surname\nUsername = $username\nID = $userID\n\nInfo Chat\nTitolo = $titleGroup\nID = $chatID\nTipo Chat = Gruppo";
            $bot->sendMessage($chatID,$msg);
        }
}

    if(stripos($text,"/admin")=== 0 and in_array($userID,$admin)){
        $bot->sendMessage($chatID,"Hey, @$username è un admin del bot! ❤️");
    }

    if(stripos($text,"/say")=== 0){
        $mess = explode(" ",$text,2);
        $say = $mess[1];
        $bot->sendMessage($chatID,$say);
        $bot->deleteMessage($chatID,$message_id);
    }


    if($queryData == "answerQuery"){
        $bot->answerQuery($queryID,"Ciao $queryName!");
    }

    if($queryData == "tast3"){
        $bot->editMessageText($queryUserID,$queryMsgID,"Ciao $queryName!",$tornaindietro,"inline");
    }

    if($queryData == "tornaindietro"){
        $bot->editMessageText($queryUserID,$queryMsgID,"Ecco a te una tastiera inline!",$tastierainline,"inline");
    }

    if($queryData == "cmd"){
        $bot->editMessageText($queryUserID,$queryMsgID,"Comandi:\n/tfisica => Tastiera Fisica\n/tinline => Tastiera Inline\n/rand => Numero Random da 1 a 1000\n/info => Info Utente\n/admin => Comando solo per admin del bot\n/say => Per far inviare un messaggio al bot");
    }
}

if($config['dev_mode'] == true){
    if($text == "/start"){
        $bot->sendMessage($userID,"<b>Hey $name</b>, il bot è attualmente in manutenzione :(");
    }
}
