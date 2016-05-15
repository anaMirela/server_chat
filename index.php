<?php
require_once 'idiorm.php';
require_once 'db_methods.php';
require_once 'utils.php';

ORM::configure('sqlite:./db.sqlite');

if (isset($_GET['action'])) {
	if (strcmp($_GET['action'], 'login') == 0) {
		if (isset($_GET['facebookid']) && isset($_GET['name'])) {
			$user = ORM::for_table('user')->where('facebookid', $_GET['facebookid'])->find_one();
			if ($user == null) {
				$user = create_user($_GET['facebookid'], $_GET['name']);
			}
		}
	} else if (strcmp($_GET['action'], "getmessages") == 0) {
		if (isset($_GET['senderid']) && isset($_GET['receiverid'])) {
			$messages = getMessagesBySenderAndReceiver($_GET['senderid'], $_GET['receiverid']);
			$messages_arr = array();
			foreach ($messages as $m) {
				array_push($messages_arr, create_json_from_object($m));
			}
			echo json_encode($messages_arr);
		}

	} else if (strcmp($_GET['action'], "sendmsg") == 0) {
		if (isset($_POST['msg_content']) && isset($_POST['senderid']) && isset($_POST['receiverid']) && isset($_POST['timestamp'])) {
			create_message($_POST['senderid'], $_POST['receiverid'], $_POST['msg_content'], $_POST['timestamp']);
		}
	} else if (strcmp($_GET['action'], "getlastmsg") == 0) {
		if (isset($_GET['senderid']) && isset($_GET['receiverid']) && isset($_GET['timestamp']) && isset($_GET['lastId'])) {
			//echo $_GET['senderid'].' '.$_GET['receiverid'].' '.$_GET['timestamp'].' '.$_GET['lastId'];
			$messages = getLastMessages($_GET['senderid'], $_GET['receiverid'], $_GET['timestamp'], $_GET['lastId']);
			$messages_arr = array();
			foreach ($messages as $m) {
				array_push($messages_arr, create_json_from_object($m));
			}
			echo json_encode($messages_arr);
		}
	}
}

?>