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

function create_message($senderid, $receiverid, $msg_content) {
    $m = ORM::for_table('messages')->create();
    $m->sender_fbid = $senderid;
    $m->receiver_fbid = $receiverid;
    $m->content = $msg_content;
    $m->save();
    return $m;
}

function getMessagesBySenderAndReceiver($senderid, $receiverid) {
    $messages = ORM::for_table('messages')->where_in('sender_fbid', array($senderid, $receiverid))
                                        ->where_in('receiver_fbid', array($senderid, $receiverid))
                                        ->order_by_asc('id')->find_many();
    return $messages;
}

?>