<?php
require_once("idiorm.php");
ORM::configure('sqlite:./db.sqlite');

function create_user($facebookid, $name) {
    $user = ORM::for_table('user')->create();
    $user->facebookid = $facebookid;
    $user->name = $name;
    $user->save();
    return $user;
}

function create_message($senderid, $receiverid, $msg_content, $timestamp) {
    $m = ORM::for_table('messages')->create();
    $m->sender_fbid = $senderid;
    $m->receiver_fbid = $receiverid;
    $m->content = $msg_content;
    $m->timestamp = $timestamp;
    $m->save();
    return $m;
}

function getMessagesBySenderAndReceiver($senderid, $receiverid) {
    $messages = ORM::for_table('messages')->where_in('sender_fbid', array($senderid, $receiverid))
                                        ->where_in('receiver_fbid', array($senderid, $receiverid))
                                        ->order_by_asc('id')->find_many();
    return $messages;
}

function getLastMessages($senderid, $receiverid, $timestamp, $lastId) {
   // $messages = ORM::for_table('messages')->raw_query('SELECT m.* FROM messages m WHERE strftime("%s", :timestamp) - strftime("%s", `timestamp`)>0', array('timestamp' => $timestamp))->find_many();

   // $messages = ORM::for_table('messages')->raw_query('SELECT m.* FROM messages m WHERE id>:lastId', array('lastId' => $lastId))->find_many();
    $messages = ORM::for_table('messages')->where_gt('id', $lastId)->find_many();
    return $messages;
}

?>