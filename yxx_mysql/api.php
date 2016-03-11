<?php
require('Db.php');
require('mysql.php');
$db=Db::instance('user');
/**
 * 
 检查openid是否在数据中
 * 有 获取用户的name  headurlimg uid
 * 没有 创建一个uid 将用户的数据写入数据库中 并返回name headurlimg uid 
 *
 */
function isOpenid($openid){
	$result=Db::instance('user')->select('nickname,headimgurl,uid')->from('user')->where("openid='$openid'")->query();
	if(isset($result)){
		//空
		
	}else{
		
		
	}
	return $result;

}
/*
 * 必须先检查uid是否存在否则会出错
 * 插入数据到user表
 * 
 * */

function insertUser($user){
	$result =Db::instance('user')->insert('user')->cols($user)->query();
	return $result;
}
/**
 * 创建房间
 * @param array $room
 * @return rid  
 */
function createRoom($room){
    $rid=md5(uniqid());
    $room['rid']=$rid;
    $result =Db::instance('user')->insert('room')->cols($room)->query();
    return $rid;
}
/**
 * 通过rid 获取房间的 数据
 * 返回 数组 或者 false
 * @param unknown $rid
 * @return unknown
 */
function getRoomInfo($rid){
    $result=Db::instance('user')->select('*')->from('room')->where("rid='$rid'")->row();
    return $result;
}
/**
 * 当用户进入房间的时候的调用该方法
 * 先判断该用户是否在房间内
 * @param unknown $rid
 * @param unknown $uid
 * @return $ruid
 */
function createRU($rid,$uid){
    //先查询该数据库是否有rid 和 uid
    $ruid = Db::instance('user')->select('ruid')->from('ru')->where("rid='$rid'" AND "uid='$uid'")->row();
    if($ruid) return $ruid;
    $ruid=md5(uniqid());
    $result =Db::instance('user')->insert('ru')->cols(array('ruid'=>$ruid,'rid'=>$rid,'uid'=>$uid))->query();
    return $ruid;
}


/**
 * 通过 uid 和 rid 获取当前用户的账号信息
 */
function getAccountByUidAndRid($rid,$uid){
	$account = Db::instance('user')->select('account')->from('ru')->where("rid='$rid'" AND "uid='$uid'")->row();
	return $account;
}




/**
 * 某人修改了某人的某个房间的金额
 * @param unknown $bankerId 房主id
 * @param unknown $uid
 * @param unknown $rid
 * @param unknown $money
 */

function updateAccountInRuBy($bankerId,$uid,$rid,$money){
	//判断banker 是否该房间的房主
	$result=Db::instance('user')->select('*')->from('room')->where("rid='$rid'" AND "uid='$uid'")->row();
	if($result){
	    //是房主,插入数据水流记录，并修改金额
	    $option=array('oid'=>md5(uniqid()),'uid'=>$uid,'money'=>$money,'time'=>time());
	    //修改金额
	    Db::instance('user')->update('ru')->cols(array('account'))->where("rid='$rid'" AND "uid='$uid'")->bindValue('account', 'account-$money')->query();
	    //创建流水
	    $result=Db::instance('user')->insert('option')->cols($option)->query();
        
	    
	}else{
	    //不是房主
	    return false;
	}
}

/**
 * 创建每一轮的游戏记录
 * @param unknown $rid
 * @param unknown $bankerId
 * @param unknown $downInfo
 * @param unknown $openResult
 */
function createEveryResult($rid,$bankerId,$downInfo,$openResult){
    $times = array('tid'=>md5(uniqid()),
        'rid'=>$rid,
        'bankerId'=>$bankerId,
        'downInfo'=>$openResult,
        'time'=>time()
    );
    $result=Db::instance('user')->insert('times')->cols($times)->query();
    
}

/**
 * 检测改房间是否失效 如果没有失效就返回剩余的时间
 * @param unknown $rid
 */
function queryRoomIsUse($rid){
    $endTime=Db::instance('user')->select('endTime')->from('room')->where("rid='$rid'")->row();
    
    $v = $endTime-time();
    
    if($v>0){
        //时间未到
        return $v;
    }else{
        //时间已经到
        return false;
    }
    
}





?>