<?php
$update = json_decode(file_get_contents('php://input'), TRUE);
    $text = $update['message']['text'];


if(isset($update['message']['from']['id'])) {
    $userID = $update['message']['from']['id'];
}

if(isset($update['message']['chat']['id'])) {
    $chatID = $update['message']['chat']['id'];
}

if(isset($update['message']['from']['first_name'])) {
    $name = htmlspecialchars($update['message']['from']['first_name']);
}

if(isset($update['message']['from']['last_name'])) {
    $surname = htmlspecialchars($update['message']['from']['last_name']);
}
if(isset($update['message']['from']['username'])) {
    $username = $update['message']['from']['username'];

}
if(isset($update['message']['message_id'])) {
    $message_id = $update['message']['message_id'];
}

if(isset($update['message']['chat'])) {
    $titleGroup = htmlspecialchars($update['message']['chat']['title']);
}
if(isset($update['message']['chat']['username'])) {
    $usernameGroup = $update['message']['chat']['username'];
}
if(isset($update['message']['chat']['type']) ) {
    $typeChat = $update['message']['chat']['type'];
}

if(isset($update['callback_query'])) {
    $queryID = $update['callback_query']['id'];
}
if(isset($update['callback_query']['from'])) {
    $queryUserID = $update['callback_query']['from']['id'];
}

if(isset($update['callback_query']['from']['first_name'])) {
    $queryName = htmlspecialchars($update['callback_query']['from']['first_name']);
}
if(isset($update['callback_query'])) {
    $querySurname = htmlspecialchars($update['callback_query']['from']['last_name']);
    $queryData = $update['callback_query']['data'];
    $queryUsername = $update['callback_query']['from']['username'];
    $queryMsgID = $update['callback_query']['message']['message_id'];
    $queryChatType = $update['callback_query']['chat']['type'];
    $queryChatUsername = $update['callback_query']['chat']['username'];
    $queryChatID = $update['callback_query']['chat']['id'];
}

if(isset($update['callback_query']['chat']['title'])) {
    $queryChatTitle = htmlspecialchars($update['callback_query']['chat']['title']);
}
