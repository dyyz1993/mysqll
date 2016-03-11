<?php 
//require('Db.php');
require('api.php');
$db=Db::instance('user');
$value=0;
/*生成唯一id*/
$uid=md5(uniqid());
//插入用户数据
$user=array('uid'=>$uid, 
			'openid'=>'xxxxx',
			'nickname'=>'达标',
			'sex'=>1,
			'city'=>'广州',
			'language'=>'语yan',
			'province'=>'sheng',
			'country'=>'sheng',
			'headimgurl'=>'ssssssssssssssss',
			'subscrible_time'=>'sdaa',
			'remark'=>'xx',
			'groupid'=>'a',
			'subscribe'=>1,
		  	'account'=>13);



 //$insert_id = $db->insert('user')->cols($user)->query();
 //echo $insert_id;
 //开房间啦通过
//$result = insertUser($user);
//echo $result;

/* 创建房间 */
/* echo strtotime('+1 days')."\n";
echo date('Y-m-d H:i:s',time())."\n";
echo time()."\n"; */

$startTime=time();
$endTime=strtotime('+1 days');
//echo ($endTime-$startTime)/24/60/60;  //输出为1

$room=array('uid'=>$uid,'name'=>'中华冥国','startTime'=>$startTime,
    'endTime'=>$endTime,'maxNum'=>10,'info'=>'这是我的房间');


//createRoom($room);

/* 通过rid 获取房间的 数据 */
$rid="c60594b8c394d 2ded797d2f5d7d9e310";
//getRoomInfo($rid);

$rid="";
$uid="";
echo createRU($rid, $uid);













?>