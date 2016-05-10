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
				echo create_json_from_object($user);
			}
		}
	} else if (strcmp($_GET['action'], "getmessages") == 0) {
		if (isset($_GET['senderid']) && isset($_GET['receiverid'])) {
			$messages = getMessagesBySenderAndReceiver($_GET['senderid'], $_GET['receiverid']);
			$messages_arr = array();
			foreach ($messages as $m) {
				array_push($messages_arr, create_json_from_object($m));
			}
			echo print_r(json_encode($messages_arr));
		}

	} else if (strcmp($_GET['action'], "sendmsg") == 0) {
		if (isset($_POST['msg_content']) && isset($_POST['senderid']) && isset($_POST['receiverid'])) {
			create_message($_POST['senderid'], $_POST['receiverid'], $_POST['msg_content']);
		}
	}
}


 //$users = ORM::for_table('user')->find_many();
 //$messages = getMessagesBySenderAndReceiver('33', '34');
//foreach ($messages as $m) {
// 	echo create_json_from_object($m);
 //}
// foreach ($users as $u) {
// 	echo  create_json_from_object($u);
// }

?>

<html>
	<head></head>
	<body>
		<form action="index.php?action=sendmsg" method="post">
			<input type="text" name="senderid"></input>
			<input type="text" name="receiverid"></input>
			<input type="text" name="msg_content"></input>
			<input type="submit" value="send"/>
		</form>

	</body>
	
</html>