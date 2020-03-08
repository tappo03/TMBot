<?php
class bot {

    public function cURL ($method,$args) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot'.$_GET['api'].$method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, TRUE);
    }
    public function sendMessage ($chat_id,$text,$key = false,$type = false) {
    if($key != false) {
        if($type == 'fisica'){
            $keyboard = '{"keyboard":['.$key.'],"resize_keyboard":true}';
        }
        elseif($type == 'inline'){
            $keyboard = '{"inline_keyboard":['.$key.'],"resize_keyboard":true}';
        }
    }else {
        $keyboard = '';
    }
            $args = [
                'chat_id' => $chat_id,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
                'text' => $text,
                'reply_markup' => $keyboard
            ];
    return $this->cURL ('/sendMessage',$args);
    }
    public function editMessageText ($chat_id, $message_id, $text, $key = false, $type = false) {
        if($key != false) {
            if($type == 'fisica'){
                $keyboard = '{"keyboard":['.$key.'],"resize_keyboard":true}';
            }
            elseif($type == 'inline'){
                $keyboard = '{"inline_keyboard":['.$key.'],"resize_keyboard":true}';
            }
        }else {
            $keyboard = '';
        }
            $args = [
                'chat_id' => $chat_id,
                'message_id' => $message_id,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
                'text' => $text,
                'reply_markup' => $keyboard
            ];
        return $this->cURL ('/editMessageText',$args);
    }
    public function answerQuery ($callbackQueryID,$text) {
        return $this->cURL ('/answerCallbackQuery',['callback_query_id' => $callbackQueryID, 'text' => $text]);
    }
    public function deleteMessage ($chat_id,$message_id) {
        return $this->cURL ('/deleteMessage',['chat_id' => $chat_id, 'message_id' => $message_id]);
    }
}
