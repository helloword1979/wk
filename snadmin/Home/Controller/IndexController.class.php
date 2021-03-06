<?php
namespace Home\Controller;
use Think\Controller;
use Vendor\Wechat\Wechat;
use Vendor\Wechat\Snoopy;
class IndexController extends CommonController {
  public function admin_add(){
    	 
    	 
    	$this->display('index/admin_add');
    }
    function index(){
		
		$this->display("index/main");
	}
	
	
	
	function stamp(){
		$str = require_once("\Twotree.php");
		$tree = new \Twotree();

		$numid = 1;
		$row = 1;
		$cols = 1;
		
		$id = I('numid');
		$bid = I('bcid');
		$searchid = I('pnumid');
		
		if(empty($id) && !empty($bid)){
			$bcinfo = M('twotree')->where(array('numid'=>$bid))->find();
			
			$ids = $tree->get_parents($bid,$bcinfo['row'],$bcinfo['cols'],1);
			
			$id = $ids[0];
		}
		if(!empty($searchid)){
			$bcinfo = M('twotree')->where(array('user'=>$searchid))->find();
			$id = $bcinfo['numid'];
		}
		//echo $id;exit;
		if(!empty($id)){
			
			$resu = M('twotree')->field('jk_twotree.row,jk_twotree.cols,jk_twotree.numid,jk_twotree.user,jk_user.UE_money,jk_user.UE_integral')->join('left join jk_user on jk_twotree.user = jk_user.UE_account')->where(array('jk_twotree.numid'=>$id))->find();
			
			if($resu){
				$numid = $resu['numid'];
				$row = $resu['row'];
				$cols = $resu['cols'];
			}
			
		}	
		
		$return = array();
		$sons = $tree->get_son($numid,$row,$cols,3,$return);
		
		//$data = $tree->get_son(1,1,1,3,$return);
		$return[] = $numid;
		sort($return);
		
		//$result = M('twotree')->where(array('numid'=>array('in',$return)))->order('numid')->select();
		$result = M('twotree')->field('jk_twotree.row,jk_twotree.cols,jk_twotree.user,jk_twotree.numid,jk_twotree.addtime,jk_user.UE_account,jk_user.UE_money,jk_user.UE_integral')->join('left join jk_user on jk_twotree.user = jk_user.UE_account')->where(array('jk_twotree.numid'=>array('in',$return)))->order('jk_twotree.numid')->select();
		//var_dump($result);exit;
		foreach($result as $k=>$v){
			$res[$v['numid']] = $v;
			$res[$v['numid']]['id'] = $v['numid'];
		}
		
		$total = 0;
		for($i=0;$i<4;$i++){
			
			for($j=0;$j<(1<<$i);$j++){
				
				$data[$i][] = $return[$total];
				$total++;
			}
		}
		
		$this->assign('bc',$numid);
		$this->assign('data',$data);
		$this->assign('res',$res);
		$this->display();
	}
	
    public function wesh(){
        echo "11111";die();
        $this->display();
    }
    public function df1(){
    
		
    	$year = date("Y");
    	$month = date("m");
    	$day = date("d");
    	$dayed = date("d")-1;
    	$dayBegin = mktime(0,0,0,$month,$day,$year);//当天开始时间戳
    	$dayEnd = mktime(23,59,59,$month,$day,$year);//当天结束时间戳
    	 
    	$dayBegined = mktime(0,0,0,$month,$dayed,$year);//当天开始时间戳
    	$dayEnded = mktime(23,59,59,$month,$dayed,$year);//当天结束时间戳
    	 
    	$startTime = date('Y-m-d H:i:s',$dayBegin);
    	$endTime=date('Y-m-d H:i:s',$dayEnd);
    	 
    	$startTimed = date('Y-m-d H:i:s',$dayBegined);
    	$endTimed=date('Y-m-d H:i:s',$dayEnded);
    	 //echo $endTimed;die;
    	//今天註冊會員
    	$zt=M('system')->where(array('SYS_ID'=>1))->find();
    	// 		$time2 = date('H');
    	$this->zt=$zt;
    	
    	
    	$ip=M ( 'drrz' )->where ( array ('user' => $_SESSION ['adminuser'],'leixin'=>1) )->order ( 'id DESC' )->limit ( 2 )->select();
    	
    	$this->bcip=$ip[0];
    	$this->scip=$ip[1];
    	$this->jtzchy = M('user')->where("`UE_regTime`> '".$startTime."' AND `UE_regTime` < '".$endTime."'")->count("UE_ID");
    	 
		 //今日注册会员人数
		 $jrzcrs= M('user')->where("`UE_regTime`> '".$startTime."' AND `UE_regTime` < '".$endTime."'")->count("UE_ID");
    	//今天激活會員
    	$this->jtjhhy = M('user')->where("`UE_activeTime`> '".$startTime."' AND `UE_activeTime` < '".$endTime."'")->count("UE_ID");
    	 
    	//昨天註冊會員
    	$this->ztzchy = M('user')->where("`UE_regTime`> '".$startTimed."' AND `UE_regTime` < '".$endTimed."'")->count("UE_ID");
    	
    	//昨天激活會員
    	$this->ztjhhy = M('user')->where("`UE_activeTime`> '".$startTimed."' AND `UE_activeTime` < '".$endTimed."'")->count("UE_ID");
    	 

    	//總會員
    	$this->zuser = M('user')->where("`UE_ID`> '0'")->count("UE_ID");
    	
    	//總激活會員
    	$this->zjhuser = M('user')->where("`UE_ID`> '0' AND `UE_check` = '1'")->count("UE_ID");
    	
    	//總出局會員
    	$this->zcjuser = M('user')->where("`UE_ID`> '0' AND `UE_check` = '1' AND `UE_stop` = '0'")->count("UE_ID");
    	
    	//總金幣
    	$this->zjb = M('user')->sum('UE_money');
    	
    	//總銀幣
    	$this->zyb = M('user')->sum('ybhe');
    	
    	//總鑽石幣
    	$this->zzsb = M('user')->sum('zsbhe');
    	
    	//求购数量
		$this->jysl=M('ppdd')->where(array("`jydate`> '".$startTime."' AND `jydate` < '".$endTime."'",'zt'=>2))->sum('lkb');
		//交易金额
    	$this->jyje=M('ppdd')->where(array("`jydate`> '".$startTime."' AND `jydate` < '".$endTime."'",'zt'=>2))->sum('jb');
		
		
		$count=M('shop_orderform')->where(array('zt'=>1))->sum('kjsl');
		//dump($count);die();
		$num=$_POST['num'];
		$zt = $_POST['zt'];
		//dump($_POST);
		if($num>0){
			$map['num'] = $num;
			M('slkz')->add($map);
		}
		$sl=M('slkz')->order('id desc')->find();
		//dump($sl['num']);
		$xssl=$count+$sl['num'];
		
		//每日交易量
		$addnum=$_POST['addnum'];
		$time=date('Y-m-d 00:00:00',time());
		$time1=date('Y-m-d 23:59:59',time());
		
		$maps['jydate']=array(array('gt',$time),array('lt',$time1));
		//dump($map);
		$liang=M('ppdd')->where($maps)->sum('lkb');
		if($addnum>0){
			$mapp['num']=$addnum;
			M('jyl')->add($mapp);
		}
		$jy=M('jyl')->order('id desc')->find();
		$xsjyl=$liang+$jy['num'];
		
		
		$this->assign('xssl',$xssl);
		$this->assign('qwsl',$count);
		//每日交易量
		$this->assign('xsjyl',$xsjyl);
		$this->assign('sjjyl',$liang);
		
    	$this->display('index/index');
    }
    function counts(){
		if(!empty($_GET)){
			$today = $_GET['dir'];
			$today = date('Y-m-d',$today);
			//dump($today);die;
		}else{
			$today = (date('Y-m-d', time()));
		}
		//dump(UNIX_TIMESTAMP('$today 00:00'));
		//$tomorrow = mktime(0,0,0,date("m"),date("d")+1,date("Y"));
		//$tomorrow = strtotime("$today",strtotime( "+1 day");
		//$mo = date("Y-m-d", $tomorrow);
		$mo = date('Y-m-d',strtotime("$today +1 day"));
		//dump($mo);
		$aa = M('user')->where(array("UNIX_TIMESTAMP('$today 00:00')<UNIX_TIMESTAMP(UE_regTime) and UNIX_TIMESTAMP(UE_regTime)<UNIX_TIMESTAMP('$mo 00:00')"))->count();
		$coun = M('user')->count();
		
		$tgbz_jb = M('ppdd')->SUM('jb');
		$jsbz_jb = M('ppdd')->SUM('jb');
		//出售中
		$csz = M('ppdd')->where(array('datatype'=>'cslkb','zt'=>'0'))->sum('lkb');
		if($csz==""){
			$csz=0;
		}
		//求购中
		$qgz = M('ppdd')->where(array('datatype'=>'qglkb','zt'=>'0'))->sum('lkb');
		if($qgz==""){
			$qgz=0;
		}
		//交易完成
		$jywc = M('ppdd')->where(array('datatype'=>'qglkb','zt'=>'2'))->sum('lkb');
		if($jywc==""){
			$jywc=0;
		}
		$time=date('Y-m-d 00:00:00',time());
		$time1=date('Y-m-d 23:59:59',time());
		$map['jydate']=array(array('gt',$time),array('lt',$time1));
		$map['zt'] = '2';
		$jrjygec=M('ppdd')->where($map)->sum('lkb');
		$jrje = M('ppdd')->where($map)->sum('jb');
		$away_in = M('ppdd')->where(array('zt'=>'2'))->sum('jb');
		
		$come_in = M('ppdd')->where(array('zt'=>'2'))->sum('jb');
		/* dump($tgbz_jb);
		dump($jl) */;
		//$times = (date('Y-m-d H:i:s', time()));
		
		/* $ab = tgzb_jd_jb($i);
		$lx = tgzb_jd_jb1($i); */
		$lx = M('ppdd')->where(array('zt'=>'1'))->sum('jb');
		$this->assign("today",$today);
		/* $this->assign("ab",$ab);*/
		$this->assign("jywc",$jywc); 
		$this->assign("aa",$aa);
		$this->assign("coun",$coun);
		$this->assign("tgbz_jb",$jrjygec);
		$this->assign("jsbz_jb",$jrje);
		$this->assign("csz",$csz);
		$this->assign("qgz",$qgz);
		$this->assign("come_in",$come_in);
		$this->assign("away_in",$away_in);
		
		
		$this->display("counts");
	}
    public function gb(){
    	 

    	M('system')->where(array('SYS_ID'=>1))->save(array('zt'=>1));
    	// 		$time2 = date('H');
    	$this->success('关闭成功!');
    	 

    }
    public function kq(){
    
    
    	M('system')->where(array('SYS_ID'=>1))->save(array('zt'=>0));
    	// 		$time2 = date('H');
    	$this->success('开启成功!');
    
    
    }
    public function top(){
    	$this->display('index/top');
    }
    public function team(){
    	$this->user=I('get.user','0');
    	$this->display('index/team');
    }
    public function left(){
    	$this->display('index/left');
    }
    public function user_xg(){
    	
    	if(I('get.user')<>''){
    		$this->userdata = M ( 'user' )->where ( array (
    				'UE_account' => I('get.user')
    		) )->find ();
    		$this->display('index/user_xg');
    	}else {
    		$this->error('非法操作!');
    	}
    	
    	
    	
    }
    public function tgsy(){
		$a=tdj;
		$b=jlj;
		$account=$_GET['user'];

		$map['UG_dataType']=array(array('eq',$a),array('eq',$b),'or');
		$map['UG_account']=$account;
		
		$count = M('userget')->where ($map)->count();
	
		// 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	
		$total=M('userget')->where($map)->sum('UG_money');
		
    	$p = getpage($count,20);
    	
    	$list = M('userget')->where ( $map )->order ( 'UG_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
		//dump($list);die();
    	$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		$this->assign('total',$total);
		$this->display('index/tgsy');
		
	}
	public function kcsy(){
		$account = $_GET['user'];
		$map['UG_account'] = $account;
		$map['UG_dataType'] = kjsr;
		$count = M('userget')->where($map)->count();
		$p = getpage($count,20);
		$list = M('userget')->where ( $map )->order ( 'UG_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
		$total=M('userget')->where($map)->sum('UG_money');
		$this->assign('total',$total);
    	$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		$this->display('index/kcsy');
	}
	public function mytuandui1(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			
		
		
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$a['sfjl']  =$n['sfjl'];
				$a['ue_status'] = $n['ue_status'];
				$a['ue_level'] = $n['ue_level'];
				$a['ue_accname']=$n['ue_accname'];
				$a['kjzt'] =$n['kjzt'];
				$a['ue_regtime']=$n['ue_regtime'];
				$b[]=$a;
			 }
			  
		}
		
		$count=count($b);
		$this->assign('count1',$count);
		$this->assign('list',$b);
		$this->display();
	}
	public function mytuandui2(){
		//三代
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				
				$c['sfjl']  =$value['sfjl'];
				$c['ue_status'] = $value['ue_status'];
				$c['ue_level'] = $value['ue_level'];
				$c['ue_accname']=$value['ue_accname'];
				$c['kjzt'] =$value['kjzt'];
				$c['ue_regtime']=$value['ue_regtime'];
				
				$d[]=$c;
			}	
		}
		$count=count($d);
		$this->assign('count2',$count);
		$this->assign('list',$d);
		$this->display();
	}
	
	public function mytuandui3(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				
				
				$d['sfjl']  =$value1['sfjl'];
				$d['ue_status'] = $value1['ue_status'];
				$d['ue_level'] = $value1['ue_level'];
				$d['ue_accname']=$value1['ue_accname'];
				$d['kjzt'] =$value1['kjzt'];
				$d['ue_regtime']=$value1['ue_regtime'];
				
				
				$e[]=$d;
			}	
		}
		$count=count($e);
		$this->assign('count3',$count);
		$this->assign('list',$e);
		$this->display();
	}
	 public function mytuandui4(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				
				
				
				$f['sfjl']  =$value2['sfjl'];
				$f['ue_status'] = $value2['ue_status'];
				$f['ue_level'] = $value2['ue_level'];
				$f['ue_accname']=$value2['ue_accname'];
				$f['kjzt'] =$value2['kjzt'];
				$f['ue_regtime']=$value2['ue_regtime'];
				
				
				
				$g[]=$f;
			}	
		}
		$count=count($g);
		$this->assign('count4',$count);
		$this->assign('list',$g);
		$this->display();
	}
	public function mytuandui5(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				
				
				$h['sfjl']  =$value3['sfjl'];
				$h['ue_status'] = $value3['ue_status'];
				$h['ue_level'] = $value3['ue_level'];
				$h['ue_accname']=$value3['ue_accname'];
				$h['kjzt'] =$value3['kjzt'];
				$h['ue_regtime']=$value3['ue_regtime'];
				
				
				$i[]=$h;
			}	
		}
		$count=count($i);
		$this->assign('count5',$count);
		$this->assign('list',$i);
		$this->display();
	}
	public function mytuandui6(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		/* 七代 */
		foreach($i as $val5){
			$res5=$user->where(array('UE_accName'=>$val5['ue_account']))->select();
			foreach($res5 as $value5){
				$j['ue_account']=$value5['ue_account'];
				$j['ue_money'] = $value5['ue_money'];
				$j['wx_avatar'] = $value5['wx_avatar'];
				$j['ue_truename'] = $value5['ue_truename'];
				
				
				$j['sfjl']  =$value5['sfjl'];
				$j['ue_status'] = $value5['ue_status'];
				
				$j['ue_level'] = $value5['ue_level'];
				$j['ue_accname']=$value5['ue_accname'];
				$j['kjzt'] =$value5['kjzt'];
				$j['ue_regtime']=$value5['ue_regtime'];
				
				
				
				$k[]=$j;
			}	
		}
		$count=count($k);
		$this->assign('count6',$count);
		$this->assign('list',$k);
		$this->display();
	}
	public function mytuandui7(){
		
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		/* 七代 */
		foreach($i as $val5){
			$res5=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res5 as $value5){
				$j['ue_account']=$value5['ue_account'];
				$j['ue_money'] = $value5['ue_money'];
				$j['wx_avatar'] = $value5['wx_avatar'];
				$j['ue_truename'] = $value5['ue_truename'];
				$k[]=$j;
			}	
		}
		
		/* 八代 */
		foreach($k as $val6){
			$res6=$user->where(array('UE_accName'=>$val6['ue_account']))->select();
			foreach($res6 as $value6){
				$l['ue_account']=$value6['ue_account'];
				$l['ue_money'] = $value6['ue_money'];
				$l['wx_avatar'] = $value6['wx_avatar'];
				$l['ue_truename'] = $value6['ue_truename'];
				
				
				$l['sfjl']  =$value6['sfjl'];
				$l['ue_status'] = $value6['ue_status'];
				$l['ue_level'] = $value6['ue_level'];
				$l['ue_accname']=$value6['ue_accname'];
				$l['kjzt'] =$value6['kjzt'];
				$l['ue_regtime']=$value6['ue_regtime'];
				$m[]=$l;
			}	
		}
		$count=count($m);
		$this->assign('count7',$count);
		$this->assign('list',$m);
		$this->display();
	}
	public function mytuandui(){
		$account=$_GET['user'];
		$user=M('user');
		/* 一代 */
		$count=M('user')->where(array('UE_accName'=>$account))->count();
		$p = getpage($count,20);
		$result=M('user')->where(array('UE_accName'=>$account))->select();//一代
		/* 二代 */
		foreach($result as $v){
			
			 $results=$user->where(array('UE_accName'=>$v['ue_account']))->select();
			 foreach($results as $n){
				$a['ue_account']=$n['ue_account'];
				$a['ue_money'] = $n['ue_money'];
				$a['wx_avatar'] = $n['wx_avatar'];
				$a['ue_truename'] = $n['ue_truename'];
				$b[]=$a;
			 }
			  
		}
	/* 三代 */
	foreach($b as $val){
			$res=$user->where(array('UE_accName'=>$val['ue_account']))->select();
			foreach($res as $value){
				$c['ue_account']=$value['ue_account'];
				$c['ue_money'] = $value['ue_money'];
				$c['wx_avatar'] = $value['wx_avatar'];
				$c['ue_truename'] = $value['ue_truename'];
				$d[]=$c;
			}	
		}
		/* 四代 */
		foreach($d as $val1){
			$res1=$user->where(array('UE_accName'=>$val1['ue_account']))->select();
			foreach($res1 as $value1){
				$d['ue_account']=$value1['ue_account'];
				$d['ue_money'] = $value1['ue_money'];
				$d['wx_avatar'] = $value1['wx_avatar'];
				$d['ue_truename'] = $value1['ue_truename'];
				$e[]=$d;
			}	
		}
		/* 五代 */
		foreach($e as $val2){
			$res2=$user->where(array('UE_accName'=>$val2['ue_account']))->select();
			foreach($res2 as $value2){
				$f['ue_account']=$value2['ue_account'];
				$f['ue_money'] = $value2['ue_money'];
				$f['wx_avatar'] = $value2['wx_avatar'];
				$f['ue_truename'] = $value2['ue_truename'];
				$g[]=$f;
			}	
		}
		/* 六代 */
		foreach($g as $val3){
			$res3=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res3 as $value3){
				$h['ue_account']=$value3['ue_account'];
				$h['ue_money'] = $value3['ue_money'];
				$h['wx_avatar'] = $value3['wx_avatar'];
				$h['ue_truename'] = $value3['ue_truename'];
				$i[]=$h;
			}	
		}
		/* 七代 */
		foreach($i as $val5){
			$res5=$user->where(array('UE_accName'=>$val3['ue_account']))->select();
			foreach($res5 as $value5){
				$j['ue_account']=$value5['ue_account'];
				$j['ue_money'] = $value5['ue_money'];
				$j['wx_avatar'] = $value5['wx_avatar'];
				$j['ue_truename'] = $value5['ue_truename'];
				$k[]=$j;
			}	
		}
		/* 八代 */
		foreach($k as $val6){
			$res6=$user->where(array('UE_accName'=>$val6['ue_account']))->select();
			foreach($res6 as $value6){
				$l['ue_account']=$value6['ue_account'];
				$l['ue_money'] = $value6['ue_money'];
				$l['wx_avatar'] = $value6['wx_avatar'];
				$l['ue_truename'] = $value6['ue_truename'];
				$m[]=$l;
			}	
		}
		
		$this->assign('list',$result);//一代
		$this->assign('list1',$b);
		$this->assign('list2',$d);
		$this->assign('list3',$e);
		$this->assign('list5',$g);
		$this->assign('list6',$i);//六代
		$this->assign('list7',$k);
		$this->assign('list8',$m);
		$this->assign('page',$p->show());
		
		$this->display();
	}
    
    public function admin_xg(){
    	 
    	if(I('get.user')<>''){
    		$this->userdata = M ( 'member' )->where ( array (
    				'MB_username' => I('get.user')
    		) )->find ();
    		$this->display('index/admin_xg');
    	}else {
    		$this->error('非法操作!');
    	}
    	 
    	 
    	 
    }
    public function user_xx(){
      if(I('get.user')<>''){
        $User=M('user');
        $map['UE_accName']=I('get.user');
        $count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
        
        $p = getpage($count,20);
        $list = $User->where ( $map )->order ( 'UE_ID' )->limit ( $p->firstRow, $p->listRows )->select ();

        $this->assign('count',$count);
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
            // $this->userdata = M ( 'user' )->where ( array (
            //         'UE_account' => I('get.user')
            // ) )->find ();
            // $this->display('index/user_xg');
        }else {
            $this->error('非法操作!');
        }
        $this->display('index/user_xx');
    }
    public function tscl(){
		$id=$_GET['id'];
		$oob=M('tousu')->where(array('id'=>$id))->find();
		if($oob['status']==1){
			die("<script>alert('请勿重复处理');history.back(-1);</script>");
		}
	
		$result= M('user')->where(array('UE_account'=>$oob['buser']))->data(array('UE_status'=>3))->save();
		$res = M('tousu')->where(array('id'=>$id))->data(array('status'=>1))->save();
		if($result){
			die("<script>alert('该帐号已被冻结');history.back(-1);</script>");
		}
	}
	public function tsdel(){
		$id=$_GET['id'];
		$oob=M('tousu')->where(array('id'=>$id))->delete();
		if($oob){
			die("<script>alert('删除成功');history.back(-1);</script>");
		}
		
	}
    public function usercl(){
		 //dump($_POST);die();
    	 $data['UE_check']=I('post.UE_check');
    	 //$data['sfjl']=I('post.UE_stop');
         //$data['sfjl']=I('post.UE_stop1');
         $data['jl_level']=I('post.UE_stop1');
    	 $data['UE_status']=I('post.UE_dj');
    	 if(I('post.UE_password')<>''){$data['UE_password']=md5(I('post.UE_password'));}
    	 if(I('post.UE_secpwd')<>''){$data['UE_secpwd']=md5(I('post.UE_secpwd'));}
    	 $data['UE_truename']=I('post.UE_truename');
    	 $data['idcard']=I('post.idcard');
		 $data['zfb'] = I('post.zfbb');
		 $data['weixin']=I('post.weixin');
    	 $data['email']=I('post.email');
    	 $data['UE_qq']=I('post.UE_qq');
    	 $data['phone']=I('post.UE_phone');
		 $data['UE_theme']=I('post.UE_theme');
		 $data['level'] = I('post.level');
		 $data['yhmc'] = I('post.yhmc');
		 $data['yhzh'] = I('post.yhzh');
		 $data['zhxm'] = I('post.zhxm');
		 $data['btcaddress'] = I('post.btc');
		 $data['area'] = I('post.area');
		/*  $data['UE_money']=I('post.jb'); */
	     
         //$data['UE_level']=I('post.star');
		 
    	// dump(I('post.UE_account'));die;
    	 if(M('user')->where(array('UE_account'=>I('post.UE_account')))->save($data)){
    	 	$this->success('修改成功!');
    	 }else{
    	 	$this->success('修改失败!');
    	 }
    }
    
    
    public function djhy(){
		$result=M('user')->where(array('UE_account'=>$_GET['user']))->data(array('UE_status'=>3))->save();
		if($result){
			$this->success('已冻结');
		}else{
			die("<script>alert('冻结失败');history.back(-1);</script>");
		}
	}
	public function jdhy(){
		$result=M('user')->where(array('UE_account'=>$_GET['user']))->data(array('UE_status'=>1))->save();
		if($result){
			$this->success('已解冻');
		}else{
			die("<script>alert('解冻失败');history.back(-1);</script>");
		}
	}
    public function admincl(){
    
    	
    
    	$data['MB_right']=I('post.MB_right');
    	if(I('post.MB_userpwd')<>''){$data['MB_userpwd']=authcode(I('post.MB_userpwd'));}
    	//dump($data);die;
    	if(M('member')->where(array('MB_username'=>I('post.MB_username')))->save($data)){
    		$this->success('修改成功!','/admin.php/Home/Index/adminlist');
    	}else{
    		$this->success('修改失败!');
    	}
    }
    
    
    
    public function adminadd(){
		$data['MB_username']=I('post.MB_username');
		$data['MB_time']=time();
    	$data['MB_right']=I('post.MB_right');
    	$data['MB_userpwd']=authcode(I('post.MB_userpwd'));
    	if(I('post.MB_username')<>''&&I('post.MB_right')<>''&&I('post.MB_userpwd')<>''){
    	//dump($data);die;
    	if(M('member')->add($data)){
    		$this->success('添加成功!','/admin.php/Home/Index/adminlist');
    	}else{
    		$this->success('添加失败!');
    	}
    	}else{
    		$this->success('数据不能为空!');
    	}
    }
    
    
    
    public function tousu(){
		$tousu=M('tousu');
		$count=$tousu->count();
		$p=getpage($count,20);
		$list=$tousu->order('id')->limit($p->firstRow,$p->listRows)->order('id desc')->select();
		$this->assign('count',$count);
		$this->assign('page',$p->show());
		$this->assign('list',$list);
		$this->display(index/tousu);
	}
    public function userlist(){
    	$paixu=I('post.paixu');
    	
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'post.user' );
    	
    	$a=strlen($data);
	
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
    	if($a){
			$map['UE_account']=$data;
		}
		 $na=M('user')->where(array('UE_account'=>$data))->find();
        // $nas=M('user')->where(array('UE_truename'=>$data))->find();
        // dump($nas);die();
    	/* if($a==6){
    		if($na){
                $map['UE_account']=$data;
            }else{
                $map['UE_truename']=$data;
            }
    	} */
        // $nam=$User->where(array('UE_truename'=>$data))->find();
        // dump($nam);die();
        /* if($a==9){
            $map['UE_truename']=$data;
        } */
    	/* if($a==6){
    		$map['UE_account']=$data;
    	} */
    	if(I ( 'get.ip' )<>''){
    		$map['UE_regIP']=I ( 'get.ip' );
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	
    	$p = getpage($count,20);
    	
    	$list = $User->where ( $map )->order ( 'UE_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
		if($paixu!=""){
			$list = $User->where ( $map )->order ( 'UE_money desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		}
    	$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	
    	
    	
    	$this->display('index/userlist');
    }
     //发送消息
    public function kefu($content,$id){
		
		$guanliyuan=M('user')->where('UE_ID='.$id)->select();
		foreach ($guanliyuan as $key => $value) {
                # code
			$data = array();
			$data['touser'] = $value ["openid"];
			$data['msgtype'] = 'text';
			$data['text']['content'] = $content;
			import ( 'Wechat', APP_PATH . 'Common/Wechat', '.class.php' );
			$config = M ( "wxconfig" )->where ( array ("id" => "1" ) )->find ();
		$options = array (
				'token' => $config ["token"], // 填写你设定的key
				'encodingaeskey' => $config ["encodingaeskey"], // 填写加密用的EncodingAESKey
				'appid' => $config ["appid"], // 填写高级调用功能的app id
				'appsecret' => $config ["appsecret"], // 填写高级调用功能的密钥
				'partnerid' => $config ["partnerid"], // 财付通商户身份标识
				'partnerkey' => $config ["partnerkey"], // 财付通商户权限密钥Key
				'paysignkey' => $config ["paysignkey"]  // 商户签名密钥Key
        );
		$weObj = new Wechat ( $options );
			$weObj->sendCustomMessage($data);
		}
	}
    public function adminlist(){
    	 
    	 
    	$User = M ( 'member' ); // 實例化User對象
    	$data = I ( 'post.user' );
    	 
    	 
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
    	 
    	if($data<>''){
    		$map['MB_username']=$data;
    	}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	 
    	$p = getpage($count,20);
    	 
    	$list = $User->where ( $map )->order ( 'MB_ID' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	 
    	 
    	 
    	$this->display('index/adminlist');
    }
    
    public function wxtjhy(){
		
		
		$this->display();
	}
    
    public function userdel(){
    	 
    	 
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    	 
    	 
    	$userxx = M('user')->where(array('UE_ID'=>$data))->find();
    	 
    	if($data<>''){
    		M('user')->where(array('UE_ID'=>$data,'UE_check'=>'0'))->delete();
    		$this->success('删除成功!');
    	}else{
    		$this->success('公司账号不能删除!');
    	}
    	

    }
    public function ppdd_list_del(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	$userxx = M('ppdd')->where(array('id'=>$data))->find();
    
    	if($data<>''&& $userxx['id']<>''){
    		M('ppdd')->where(array('id'=>$data))->delete();
    		M('tgbz')->where(array('id'=>$userxx['p_id']))->delete();
    		M('jsbz')->where(array('id'=>$userxx['g_id']))->delete();
    		$this->success('删除成功!');
    	}else{
    		$this->success('订单不存在!');
    	}
    	 
    
    }
    
    public function tgbz_list_del(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	$userxx = M('tgbz')->where(array('id'=>$data))->find();
    
    	if($data<>''&& $userxx['id']<>''){
    		
    		M('tgbz')->where(array('id'=>$userxx['id']))->delete();
    		
    		$this->success('删除成功!');
    	}else{
    		$this->success('订单不存在!');
    	}
    
    
    }
    public function jsbz_list_del(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	$userxx = M('jsbz')->where(array('id'=>$data))->find();
    
    	if($data<>''&& $userxx['id']<>''){
    
    		M('jsbz')->where(array('id'=>$userxx['id']))->delete();
    
    		$this->success('删除成功!');
    	}else{
    		$this->success('订单不存在!');
    	}
    
    
    }
    public function admindel(){
    
    
    	$User = M ( 'member' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	$userxx = M('member')->where(array('MB_ID'=>$data))->find();
    
    	if($data<>''&& $userxx['mb_username']<>''){
    		M('member')->where(array('MB_ID'=>$data))->delete();
    		$this->success('删除成功!','/admin.php/Home/Index/adminlist');
    	}else{
    		$this->success('不能删除!');
    	}
    	 
    
    }
    
    
    
    public function usermb(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	$userxx = M('user')->where(array('UE_ID'=>$data))->find();
    
    	if($data<>''&& $userxx['ue_account']<>''){
    		if(M('user')->where(array('UE_ID'=>$data))->save(array('UE_question'=>'','UE_question2'=>'','UE_question3'=>'','UE_answer'=>'','UE_answer2'=>'','UE_answer3'=>'')))
    		{
    			$this->success('成功!');
    		}else{
    			$this->success('失败!');
    		}
    	}else{
    		$this->success('用户不存在!');
    	}
    	 
    
    }
    
    
public function userbtc(){
    	
    	
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.cz' );
    
    	
    	if ($data=='n') {
    		$map['btbdz']= '0';
    	}elseif($data=='y'){
    		$map['btbdz']= array('neq','0');
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	
    	$p = getpage($count,20);
    	
    	$list = $User->where ( $map )->order ( 'UE_ID' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	
    	
    	
    	$this->display('index/userbtc');
    }
    

    
    public function rggl(){
    	 
    	 
    	$User = M ( 'userjyinfo' ); // 實例化User對象
    	$data = I ( 'get.cz' );
    
    	 
    	if ($data=='n') {
    		$map['UJ_jbmcStage']= '0';
    	}elseif($data=='y'){
    		$map['UJ_jbmcStage']= '1';
    	}
    	$map['UJ_dataType']= 'rg';
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	 
    	$p = getpage($count,20);
    	 
    	$list = $User->where ( $map )->order ( 'UJ_ID' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	 
    	 
    	 
    	$this->display('index/rggl');
    }
    
    public function rggldel(){
    
    
    	$data = I ( 'get.id' );
    
    
    	if($data<>''){
    		if(M('userjyinfo')->where(array('UJ_ID'=>$data))->delete() ){
    		$this->success('删除成功');
    		}else{
    		$this->success('删除失败');
    		}
    	}
    }
    
    
    
    public function rgglsh(){
    
    
    	$data = I ( 'get.id' );
    
    
    	if($data<>''){
    		
    		$ddxx = M('userjyinfo')->where(array('UJ_ID'=>$data))->find();
    		
    		if($ddxx['uj_style']=='rgzsb'){
    			
    			M('user')->where(array('UE_account'=>$ddxx['uj_usercount']))->setInc('zsbhe',$ddxx['uj_jbcount']);
    			$userxx=M('user')->where(array('UE_account'=>$ddxx['uj_usercount']))->find();
    			$note3 = "原始鑽石幣購買";
    			$record3 ["UG_account"] = $ddxx['uj_usercount']; // 登入轉出賬戶
    			$record3 ["UG_type"] = 'zsb';
    			$record3 ["zsb"] = $ddxx['uj_jbcount']; // 金幣
    			$record3 ["zsb1"] = $ddxx['uj_jbcount']; //
    			$record3 ["zsbhe"] = $userxx['zsbhe']; // 當前推薦人的金幣餘額
    			$record3 ["UG_dataType"] = 'rg'; // 金幣轉出
    			$record3 ["UG_note"] = $note3; // 推薦獎說明
    			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
    			$reg4 = M ( 'userget' )->add ( $record3 );
    			M('userjyinfo')->where(array('UJ_ID'=>$data))->save(array('UJ_jbmcStage'=>'1'));
    			$this->success('处理成功');
    			
    		}elseif($ddxx['uj_style']=='rgyb'){
    			
    			
    			M('user')->where(array('UE_account'=>$ddxx['uj_usercount']))->setInc('ybhe',$ddxx['uj_jbcount']);
    			$userxx=M('user')->where(array('UE_account'=>$ddxx['uj_usercount']))->find();
    			$note3 = "原始银幣購買";
    			$record3 ["UG_account"] = $ddxx['uj_usercount']; // 登入轉出賬戶
    			$record3 ["UG_type"] = 'yb';
    			$record3 ["yb"] = $ddxx['uj_jbcount']; // 金幣
    			$record3 ["yb1"] = $ddxx['uj_jbcount']; //
    			$record3 ["ybhe"] = $userxx['ybhe']; // 當前推薦人的金幣餘額
    			$record3 ["UG_dataType"] = 'rg'; // 金幣轉出
    			$record3 ["UG_note"] = $note3; // 推薦獎說明
    			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
    			$reg4 = M ( 'userget' )->add ( $record3 );
    			M('userjyinfo')->where(array('UJ_ID'=>$data))->save(array('UJ_jbmcStage'=>'1'));
    			$this->success('处理成功');
    			
    			
    		}
    		
    		
    		
    		
    		
    	}
    }
 //------------------------------------------//
     public function klinea(){ 
    	$User = M ( 'date' ); // 實例化User對象
    		$map['id']= 'fszs';
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	 
    	$p = getpage($count,15);
    	 
    	$list = $User->order ( 'ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	 
    	 
    	 
    	$this->display('index/klinea');
    }

//插入数据
    public function klineacl(){
		$data['price']=I('post.price');
		$data['date']=time();
    	if(I('post.price')<>''){

    	if(M('date')->add($data)){
    		$this->success('添加成功!','/admin.php/Home/Index/klinea');
    	}else{
    		$this->success('添加失败!');
    	}
    	}else{
    		$this->success('数据不能为空!');
    	}
    }
	
	
//---------------------------------------------// 
    
    
    public function jbzs(){
    	 
    	 
    	$User = M ( 'userget' ); // 實例化User對象
    	
    
    	 
    	
    		$map['UG_dataType']= 'xtzs';
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	 
    	$p = getpage($count,20);
    	 
    	$list = $User->where ( $map )->order ( 'UG_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	 
    	 
    	 
    	$this->display('index/jbzs');
    }


    public function jfzs(){
         
         
        $User = M ( 'userget' ); // 實例化User對象
        
    
         
        
        $map['UG_dataType']= 'xtzsjf';
        
        $count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
         
        $p = getpage($count,20);
         
        $list = $User->where ( $map )->order ( 'UG_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
         
         
         
        $this->display('index/jfzs');
    }

    public function ggfzs(){
         
         
        $User = M ( 'userget' ); // 實例化User對象
        
    
         
        
        $map['UG_dataType']= 'xtzsggf';
        
        $count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
         
        $p = getpage($count,20);
         
        $list = $User->where ( $map )->order ( 'UG_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
         
         
         
        $this->display('index/ggfzs');
    }
    public function duihuan(){
        $User = M ( 'duihuanjf' );
        $count = $User->where ( array('status'=>1))->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
         $count1 = $User->count (); 
        $p = getpage($count,15);
         $p1= getpage($count1,15);
        $list = $User->where ( array('status'=>1))->limit ( $p->firstRow, $p->listRows )->select ();
         $list1= $User->limit ( $p1->firstRow, $p1->listRows )->select ();
        $this->assign ( 'list', $list ); // 賦值數據集
         $this->assign ( 'list1', $list1);
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
         $this->assign ( 'page1', $p1->show() ); 
         
         
        $this->display('index/duihuan');
    }
    public function tixian(){
        $User = M ( 'tixian' );
        $count = $User->where ( array('status'=>1 ))->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
          $count1 = $User->count (); 
        $p = getpage($count,15);
        $p1= getpage($count1,15);
         
        $list = $User->where ( array('status'=>1))->limit ( $p->firstRow, $p->listRows )->select ();
        $list1= $User->order('id desc')->limit ( $p1->firstRow, $p1->listRows )->select ();
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'list1', $list1);
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
         $this->assign ( 'page1', $p1->show() ); // 賦值分頁輸出
         
         
        $this->display('index/tixian');
    }
    public function tixians(){
    	$User = M ( 'tixian' );
        $count = $User->where ( array('status'=>1 ))->count (); // 查詢滿足要求的總記錄數
        //$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
          $count1 = $User->count (); 
        $p = getpage($count,15);
        $p1= getpage($count1,15);
         
        $list = $User->where ( array('status'=>1))->limit ( $p->firstRow, $p->listRows )->select ();
        $list1= $User->order('id desc')->limit ( $p1->firstRow, $p1->listRows )->select ();
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'list1', $list1);
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
         $this->assign ( 'page1', $p1->show() ); // 賦值分頁輸出
    	$this->display();
    }
    public function fwzx(){
        $fwzx = M ( 'fwzx' );
        $count = $fwzx->where ( array('status'=>1))->count();
        $count1 = $fwzx->count ();

         $p = getpage($count,15);
         $p1= getpage($count1,15);

        $list = $fwzx->where ( array('status'=>1))->limit ( $p->firstRow, $p->listRows )->select();
        // dump($list);die();
        $list1= $fwzx->limit ( $p1->firstRow, $p1->listRows )->select ();
        // dump($list1);die();
        $this->assign ( 'list', $list ); // 賦值數據集
        $this->assign ( 'list1', $list1);
        $this->assign ( 'page', $p->show() ); // 賦值分頁輸出
        $this->assign ( 'page1', $p1->show()); // 賦值分頁輸出
         
         
        
        $this->display('index/fwzx');

    }
    public function pass(){
        $id=$_GET['id'];
        $time=date("Y-m-d H:i:s",time());
        $re=M('duihuanjf')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
        if($re){

            $this->success('审核成功。');
         }else{
            die("<script>alert('审核失败，请检查！');history.back(-1);</script>");
         }
    }
     public function passtixian(){
        $id=$_GET['id'];
        $time=date("Y-m-d H:i:s",time());
        $re=M('tixian')->where(array('id'=>$id))->data(array('status'=>2,'pass_time'=>$time))->save();
        if($re){
			$tx=M('usergett')->where(array('tid'=>$id))->data(array('status'=>2))->save();

            $this->success('审核成功。');
         }else{
            die("<script>alert('审核失败，请检查！');history.back(-1);</script>");
         }
    }
    public function passfwzx(){
        $id=$_GET['id'];
        // dump($id);die();
        $re=M('fwzx')->where(array('id'=>$id))->data(array('status'=>2))->save();
        if($re){
        
         // $res=M ( 'user' )->where ( array ('UE_ID' => $_SESSION ['uid']) )->find();
        $re=M('user')->where(array(array ('UE_ID' => $_SESSION ['uid'])))->data(array('sfjl1'=>1))->save();

         // dump($res);die();
            $this->success('审核成功');
        }else{
            die("<script>alert('审核失败，请检查！');history.back(-1);</script>");
        }
    }
    public function nopass(){
        $id=$_GET['id'];
        $time=date("Y-m-d H:i:s",time());
        $ob=M('duihuanjf')->where(array('id'=>$id))->find();
        $re=M('user')->where(array('UE_ID'=>$ob['ue_id']))->data(array(
         'UE_money'=>$ob['ue_integral']+$ob['duihuan_jf']))->save();
        $obb=M('user')->where(array('UE_ID'=>$ob['ue_id']))->find();
        $ree=M('duihuanjf')->where(array('id'=>$id))->data(array(
         'UE_integral'=>$obb['ue_integral'],'pass_time'=>$time,'status'=>3))->save();
        if($re && $ree){
            $this->success('已拒绝。');
         }else{
            die("<script>alert('拒绝失败，请检查！');history.back(-1);</script>");
         }
    }
    public function nopassfwzx(){
        $id=$_GET['id'];
        // $ob=M('fwzx')->where('id'=>$id)->find();
        $re=M('fwzx')->where(array('id'=>$id))->data(array('status'=>3))->save();

        if($re){
            $re=M('fwzx')->where(array('id'=>$id))->data(array('status'=>3))->delete();
            $this->success('已拒绝。');
         }else{
            die("<script>alert('拒绝失败，请检查！');history.back(-1);</script>");
         }
    }
     public function nopasstixian(){
         $id=$_GET['id'];
        $time=date("Y-m-d H:i:s",time());
		$ob=M('tixian')->where(array('id'=>$id))->find();
		$user_xz1=M('user')->where(array('UE_account'=>$ob['ue_account']))->find();
        $re=M('user')->where(array('UE_ID'=>$ob['ue_id']))->data(array(
         'UE_money'=>$ob['ue_money']+$ob['duihuan_money']))->save();
        $obb=M('user')->where(array('UE_ID'=>$ob['ue_id']))->find();
        $ree=M('tixian')->where(array('id'=>$id))->data(array(
         'UE_money'=>$obb['ue_money'],'pass_time'=>$time,'status'=>3))->save();
		 
		 $tx=M('usergett')->where(array('tid'=>$id))->find();
        $rrr=M('usergett')->where(array('tid'=>$id))->data(array('status'=>3))->save();
       // $ti=M('usergett')->where(array('tid'=>$id))->setInc(UG_balance,$ob['duihuan_money']);
			
		$user_xz=M('user')->where(array('UE_account'=>$ob['ue_account']))->find();
		$note3 = "奖金提现退回";
		$record3["UG_account"]=$ob['ue_account'];//登入提现账户
		$record3["UG_type"] = 'jb';
		$record3["UG_allGet"]= $user_xz1['ue_money'];//金币
		$record3["UG_money"]= '+'.$ob['duihuan_money'];
		$record3["UG_balance"]=$user_xz['ue_money'];//当前推荐人的金币余额
		$record3["UG_dataType"]='jjtx';
		$record3["UG_note"]=$note3;//奖金提现说明
		$record3["UG_getTime"]=date('Y-m-d H:i:s',time());//操作时间
		$reg4=M('userget')->add($record3);
		
        if($re && $ree){
            $this->success('已拒绝。');
         }else{
            die("<script>alert('拒绝失败，请检查！');history.back(-1);</script>");
         }
    }
    public function userbtccl(){
    	 
    	 
    	$User = M ( 'user' ); // 實例化User對象
    	//dump(I('post.UE_ID'));die;
    	if(I('post.UE_ID')<>''&&I('post.btbdz')<>'0'){
    		if($User->where(array('UE_ID'=>I('post.UE_ID')))->save(array('btbdz'=>I('post.btbdz')))){
    			$this->success('修改成功!');
    		}else{
    			$this->success('修改失败!');
    		}
    	}else{
    		$this->success('您没修改内容!');
    	}

    }
    
    
    public function jbzscl(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	//dump(I('post.UE_ID'));die;
    	if(I('post.lx')=='jb'){
    		if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
    			$user_zq=M('user')->where(array('UE_account'=>I('post.user')))->find();
    			if($User->where(array('UE_account'=>I('post.user')))-> setInc('UE_money',I('post.sl'))){
    			
    			
    			$userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
    			$note3 = "系统操作（莱肯币）";
    			$record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
    			$record3 ["UG_type"] = 'lkb';
    			$record3 ["UG_money"] = I('post.sl'); // 金幣
    			$record3 ["UG_allGet"] = $user_zq['ue_money']; //
    			$record3 ["UG_balance"] = $userxx['ue_money']; // 當前推薦人的金幣餘額
    			$record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
    			$record3 ["UG_note"] = $note3; // 推薦獎說明
    			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
				$record3["UG_othraccount"] = $userxx['ue_truename'];
    			$reg4 = M ( 'userget' )->add ( $record3 );
    			
    			
    			$this->success('GEC赠送成功!');
    		}else{
    			$this->success('GEC赠送失败!');
    		}
    		}else{
    			$this->success('用户 名不存在或填写有误!');
    		}
    		
    			
    		
    	}elseif(I('post.lx')=='yb'){
    	if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
    		if($User->where(array('UE_account'=>I('post.user')))-> setInc('ybhe',I('post.sl'))){
    			$userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
    			$note3 = "系统赠送";
    			$record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
    			$record3 ["UG_type"] = 'yb';
    			$record3 ["yb"] = I('post.sl'); // 金幣
    			$record3 ["yb1"] = I('post.sl'); //
    			$record3 ["ybhe"] = $userxx['ybhe']; // 當前推薦人的金幣餘額
    			$record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
    			$record3 ["UG_note"] = $note3; // 推薦獎說明
    			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
    			$reg4 = M ( 'userget' )->add ( $record3 );
    			
    			
    			$this->success('银币赠送成功!');
    		}else{
    			$this->success('银币赠送失败!');
    		}
    		}else{
    			$this->success('用户 名不存在或填写有误!');
    		}
    	}elseif(I('post.lx')=='zsb'){
    	if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
    		if($User->where(array('UE_account'=>I('post.user')))-> setInc('zsbhe',I('post.sl'))){
    			$userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
    			$note3 = "系统赠送";
    			$record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
    			$record3 ["UG_type"] = 'zsb';
    			$record3 ["zsb"] = I('post.sl'); // 金幣
    			$record3 ["zsb1"] = I('post.sl'); //
    			$record3 ["zsbhe"] = $userxx['zsbhe']; // 當前推薦人的金幣餘額
    			$record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
    			$record3 ["UG_note"] = $note3; // 推薦獎說明
    			$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
    			$reg4 = M ( 'userget' )->add ( $record3 );
    			
    			
    			$this->success('钻石币赠送成功!');
    		}else{
    			$this->success('钻石币赠送失败!');
    		}
    		}else{
    			$this->success('用户 名不存在或填写有误!');
    		}
    	}
    
    }
    
 public function jfzscl(){
    
    
        $User = M ( 'user' ); // 實例化User對象
        //dump(I('post.UE_ID'));die;
        if(I('post.lx')=='jf'){
            if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
                $user_zq=M('user')->where(array('UE_account'=>I('post.user')))->find();
                if($User->where(array('UE_account'=>I('post.user')))-> setInc('UE_integral',I('post.sl'))){
                
                
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统操作（积分）";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'jf';
                $record3 ["UG_money"] = I('post.sl'); // 金幣
                $record3 ["UG_allGet"] = $user_zq['ue_integral']; //
                $record3 ["UG_balance"] = $userxx['ue_integral']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzsjf'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('积分赠送成功!');
            }else{
                $this->success('积分赠送失败!');
            }
            }else{
                $this->success('用户 名不存在或填写有误!');
            }
            
                
            
        }elseif(I('post.lx')=='yb'){
        if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
            if($User->where(array('UE_account'=>I('post.user')))-> setInc('ybhe',I('post.sl'))){
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统赠送";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'yb';
                $record3 ["yb"] = I('post.sl'); // 金幣
                $record3 ["yb1"] = I('post.sl'); //
                $record3 ["ybhe"] = $userxx['ybhe']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('银币赠送成功!');
            }else{
                $this->success('银币赠送失败!');
            }
            }else{
                $this->success('用户 名不存在或填写有误!');
            }
        }elseif(I('post.lx')=='zsb'){
        if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
            if($User->where(array('UE_account'=>I('post.user')))-> setInc('zsbhe',I('post.sl'))){
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统赠送";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'zsb';
                $record3 ["zsb"] = I('post.sl'); // 金幣
                $record3 ["zsb1"] = I('post.sl'); //
                $record3 ["zsbhe"] = $userxx['zsbhe']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('钻石币赠送成功!');
            }else{
                $this->success('钻石币赠送失败!');
            }
            }else{
                $this->success('用户 名不存在或填写有误!');
            }
        }
    
    }

    public function ggfzscl(){
    
    
        $User = M ( 'user' ); // 實例化User對象
        //dump(I('post.UE_ID'));die;
        if(I('post.lx')=='ggf'){
            if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
                $user_zq=M('user')->where(array('UE_account'=>I('post.user')))->find();
                if($User->where(array('UE_account'=>I('post.user')))-> setInc('ggf',I('post.sl'))){
                
                
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统操作（购物券）";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'ggf';
                $record3 ["UG_money"] = I('post.sl'); // 金幣
                $record3 ["UG_allGet"] = $user_zq['ggf']; //
                $record3 ["UG_balance"] = $userxx['ggf']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzsggf'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('广告费赠送成功!');
            }else{
                $this->success('广告费赠送失败!');
            }
            }else{
                $this->success('用户名不存在或填写有误!');
            }
            
                
            
        }elseif(I('post.lx')=='yb'){
        if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
            if($User->where(array('UE_account'=>I('post.user')))-> setInc('ybhe',I('post.sl'))){
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统赠送";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'yb';
                $record3 ["yb"] = I('post.sl'); // 金幣
                $record3 ["yb1"] = I('post.sl'); //
                $record3 ["ybhe"] = $userxx['ybhe']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('银币赠送成功!');
            }else{
                $this->success('银币赠送失败!');
            }
            }else{
                $this->success('用户 名不存在或填写有误!');
            }
        }elseif(I('post.lx')=='zsb'){
        if(I('post.sl')<>''&& $User->where(array('UE_account'=>I('post.user')))->find()<>0 && preg_match ( '/^[0-9-]{1,20}$/', I('post.sl') )){
            if($User->where(array('UE_account'=>I('post.user')))-> setInc('zsbhe',I('post.sl'))){
                $userxx=M('user')->where(array('UE_account'=>I('post.user')))->find();
                $note3 = "系统赠送";
                $record3 ["UG_account"] = I('post.user'); // 登入轉出賬戶
                $record3 ["UG_type"] = 'zsb';
                $record3 ["zsb"] = I('post.sl'); // 金幣
                $record3 ["zsb1"] = I('post.sl'); //
                $record3 ["zsbhe"] = $userxx['zsbhe']; // 當前推薦人的金幣餘額
                $record3 ["UG_dataType"] = 'xtzs'; // 金幣轉出
                $record3 ["UG_note"] = $note3; // 推薦獎說明
                $record3["UG_getTime"]      = date ( 'Y-m-d H:i:s', time () ); //操作時間
                $reg4 = M ( 'userget' )->add ( $record3 );
                
                
                $this->success('钻石币赠送成功!');
            }else{
                $this->success('钻石币赠送失败!');
            }
            }else{
                $this->success('用户 名不存在或填写有误!');
            }
        }
    
    }

    public function tj_zrjj_cl(){
    	header("Content-Type:text/html; charset=utf-8");
    
    	if(IS_POST){

    		
    		
    		//时间
    		$NowTime = date('Y-m-d H:i:s',time());
    		
    		$gxTime	= $NowTime;//每日分紅的時間
    		//echo $gxTime;
    		
    		$year = date("Y");
    		$month = date("m");
    		$day = date("d");
    		
    		$dayBegin = mktime(0,0,0,$month,$day,$year);//當天開始時間戳
    		$dayEnd = mktime(23,59,59,$month,$day,$year);//當天結束時間戳
    		
    		$startTime = date('Y-m-d H:i:s',$dayBegin);
    		$endTime=date('Y-m-d H:i:s',$dayEnd);
    		
    		$startTimed = date('Y-m-d H:i:s',$dayBegin);
    		$endTimed=date('Y-m-d H:i:s',$dayEnd);
    		

    		
    		//时间
    		
    		
    		//昨天开始
    		
    		$year = date("Y");
    		$month = date("m");
    		$day = date("d");
    		
    		$dayBegin = mktime(0,0,0,$month,$day,$year)-86400;//當天開始時間戳
    		$dayEnd = mktime(23,59,59,$month,$day,$year)-86400;//當天結束時間戳
    		
    		$startTime = date('Y-m-d H:i:s',$dayBegin);
    		$endTime=date('Y-m-d H:i:s',$dayEnd);
    		
    		$startTimed = date('Y-m-d H:i:s',$dayBegin);
    		$endTimed=date('Y-m-d H:i:s',$dayEnd);
    		
    		//echo $startTimed."<br>";
    		//echo $endTimed."<br>";die;
    		
    		
    		//昨天结束
    		$otsystem=M('system')->where("SYS_ID ='1'")->find();
    		
    		$res=M('user')->where("UE_check ='1' and UE_activeTime > '".$startTimed."' and UE_activeTime < '".$endTimed."'")->select();
    		
    		//dump($otsystem);die; echo $val['ue_accname'];
    		$tjj_tj = 0;
    		$tjj1_tj = 0;
    		$tjj2_tj = 0;
    		$bdj_tj = 0;
    		foreach($res as $val){
    			if($val['ue_accname']<>''){
    				$tjr_1 =M('user')->where("UE_account='".$val['ue_accname']."'")->find();
    				$tjr_1_he=$tjr_1['ue_money']+$otsystem['a_kd_zsb']*2*$otsystem['a_ztj'];
    				M('user')->where("UE_account='".$tjr_1['ue_account']."'")->save(array('UE_money'=>$tjr_1_he));
    				
    				

    				$record3 ["UG_account"] = $tjr_1['ue_account']; 
    				$record3 ["UG_type"] = 'jb';
    				$record3 ["UG_money"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj']; 
    				$record3 ["UG_allGet"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj']; 
    				$record3 ["UG_balance"] = $tjr_1_he; 
    				$record3 ["UG_dataType"] = 'tjj1'; 
    				$record3 ["UG_note"] = '推荐奖'; 
    				$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); 
    				M ( 'userget' )->add ( $record3 );
    				
    				$tjj_tj = $tjj_tj+ 1;
    				
    				
    				if($tjr_1['ue_accname']<>''){
    					
    					$tjr_2 =M('user')->where("UE_account='".$tjr_1['ue_accname']."'")->find();
    					$tjr_2_he=$tjr_2['ybhe']+$otsystem['a_kd_zsb']*2*$otsystem['a_ztj2'];
    					M('user')->where("UE_account='".$tjr_2['ue_account']."'")->save(array('ybhe'=>$tjr_2_he));
    					
    					
    					
    					$record3 ["UG_account"] = $tjr_2['ue_account'];
    					$record3 ["UG_type"] = 'yb';
    					$record3 ["yb"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj2'];
    					$record3 ["yb1"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj2'];
    					$record3 ["ybhe"] = $tjr_2_he;
    					$record3 ["UG_dataType"] = 'tjj2';
    					$record3 ["UG_note"] = '间推奖';
    					$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () );
    					M ( 'userget' )->add ( $record3 );
    					
    					$tjj1_tj = $tjj1_tj+1;
    					
    					if($tjr_2['ue_accname']<>''){
    							
    						$tjr_3 =M('user')->where("UE_account='".$tjr_2['ue_accname']."'")->find();
    						$tjr_3_he=$tjr_3['ybhe']+$otsystem['a_kd_zsb']*2*$otsystem['a_ztj3'];
    						M('user')->where("UE_account='".$tjr_3['ue_account']."'")->save(array('ybhe'=>$tjr_3_he));
    							
    							
    							
    						$record3 ["UG_account"] = $tjr_3['ue_account'];
    						$record3 ["UG_type"] = 'yb';
    						$record3 ["yb"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj3'];
    						$record3 ["yb1"] = $otsystem['a_kd_zsb']*2*$otsystem['a_ztj3'];
    						$record3 ["ybhe"] = $tjr_3_he;
    						$record3 ["UG_dataType"] = 'tjj3';
    						$record3 ["UG_note"] = '间间推奖';
    						$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () );
    						M ( 'userget' )->add ( $record3 );
    							
    						$tjj2_tj = $tjj2_tj+1;
    							
    					}
    					
    					
    				}
    				
    				
    				
    				dump($tjr_1_he);die;
    			}
    			
    		}
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		
    		

//     	set_time_limit(10);    
//  ob_end_clean();     //在循环输出前，要关闭输出缓冲区   

//  echo str_pad('',1024);   
//  //浏览器在接受输出一定长度内容之前不会显示缓冲输出，这个长度值 IE是256，火狐是1024   
//  for($i=1;$i<=100;$i++){    
//   echo $i.'<br/>';    
//   flush();    //刷新输出缓冲   
   
//  }    
    		

    	
    	}
    
    }
    
    
    
    
    public function pin_add(){
    
    
    	$this->display('index/pin_add');
    }
    
    
    public function pin_add_cl() {
    
    	if (IS_POST) {
    		$data_P = I ( 'post.' );
    		//dump($data_P);die;

    		$user = M ( 'user' )->where ( array (
    				UE_account => $data_P['user']
    		) )->find ();
    		
    		if (! $user) {
    			$this->error('用户 不存在！');
    		}elseif (! preg_match ( '/^[0-9.]{1,10}$/', $data_P ['sl'] )) {
    			$this->error('请填生成数量！');
    		} else {
    $cgsl=0;
            for ($i=0;$i<$data_P ['sl'];$i++){
    			$pin=md5(sprintf("%0".strlen(9)."d", mt_rand(0,99999999999)));
    			//$pin=0;
    			if(!M('pin')->where(array('pin'=>$pin))->find()){
    				$data['user']=$data_P['user'];
    				$data['pin']=$pin;
    				$data['zt']=0;
    				$data['sc_date']=date ( 'Y-m-d H:i:s', time () );
    				if(M('pin')->add($data)){
    					$cgsl++;
    				}
    			}
            }
            $this->success('成功添加激活码'.$cgsl.'个');
    		}
    	}
    }
    
    
    public function pin_list(){
    	 
    	 
    	$User = M ( 'pin' ); // 實例化User對象
    	$data = I ( 'post.user' );
    	 
    	 
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
    	 if(I ( 'get.cz' )==0){
    	 	$map['zt']=0;
    	 }
    	 if(I ( 'get.cz' )==1){
    	 	$map['zt']=1;
    	 }
    	if($data<>''){
    		$map['user']=$data;
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    	 
    	$p = getpage($count,20);
    	 
    	$list = $User->where ( $map )->order ( 'id DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    	 
    	 
    	 
    	$this->display('index/pin_list');
    }
    public function pin_del(){
    
    
    	$User = M ( 'user' ); // 實例化User對象
    	$data = I ( 'get.id' );
    
    
    	
    		if(M('pin')->where(array('id'=>$data))->delete()){
    			$this->success('删除成功!');
    		}else{
    			$this->success('删除失败!');
    		}
    		
    	 
    
    }
    public function csdd(){
		$start=I('post.start');
		$end=I('post.end');
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
        //$this->z_jgbz=$User->sum('jb');
		
		
		if($data){
			$map['p_user']=$data;
			$map['datatype']="cslkb";
		}else{
			$map['zt']=0;
			$map['datatype']="cslkb";
		}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		$countlkb = $User->where($map)->sum('lkb');
		$jb = $User->where($map)->sum('jb');
		
		 //今日注册会员人数
		 //$jrzcrs= M('user')->where("`UE_regTime`> '".$startTime."' AND `UE_regTime` < '".$endTime."'")->count("UE_ID");
		if($start && $end){
			$list= M('ppdd')->where("`date`> '".$start."' AND `date` < '".$end."' AND `zt`=0")->select();
			
		}
		
		
		$this->assign('countlkb',$countlkb);
		$this->assign('countjb',$jb);
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		
		$this->assign('count',$count);
    
    
    
    	$this->display('index/csdd');
	}
    
    /* NOTED BY SKYRIM: 提供帮助、列表 */
    public function qiugou(){
		$start=I('post.start');
		$end=I('post.end');
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
        //$this->z_jgbz=$User->sum('jb');
		
		
		if($data){
			$map['p_user']=$data;
			$map['datatype']="qglkb";
		}else{
			$map['zt']=0;
			$map['datatype']="qglkb";
		}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		$countlkb = $User->where($map)->sum('lkb');
		$jb = $User->where($map)->sum('jb');
		
		 //今日注册会员人数
		 //$jrzcrs= M('user')->where("`UE_regTime`> '".$startTime."' AND `UE_regTime` < '".$endTime."'")->count("UE_ID");
		if($start && $end){
			$list= M('ppdd')->where("`date`> '".$start."' AND `date` < '".$end."' AND `zt`=0")->select();
			
		}
		
		
		$this->assign('countlkb',$countlkb);
		$this->assign('countjb',$jb);
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		
		$this->assign('count',$count);
    
    
    
    	$this->display('index/qiugou');
    }
    public function chushou(){
		$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
        //$this->z_jgbz=$User->sum('jb');
    	$map['zt']=1;
		$map['g_user'] !="";
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'date ' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/chushou');
	}
	public function jiaoyi(){
		
		
		
		$User = M ( 'ppdd' ); // 實例化User對象
		$start=I('post.start');
		$end=I('post.end');
    	$data = I ( 'post.user' );
		$gname=$data;
        //$this->z_jgbz=$User->sum('jb');
		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
			$map['zt']=1;
		}else{
			$map['zt']=1;
		}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'jydate desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		
		
		$countlkb = $User->where($map)->sum('lkb');
		$jb = $User->where($map)->sum('jb');
		
		
		
		if($start && $end){
			$list= M('ppdd')->where("`date`> '".$start."' AND `date` < '".$end."' AND `zt`=1")->select();
			
		}
		
		
		
		$this->assign('countlkb',$countlkb);
		$this->assign('countjb',$jb);
		
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		
		$this->display('index/jiaoyi');
	}
    public function jywc(){
		$User = M ( 'ppdd' ); // 實例化User對象
		$start=I('post.start');
		$end=I('post.end');
    	$data = I ( 'post.user' );
		$gname=$data;
        //$this->z_jgbz=$User->sum('jb');
		
			
        //$this->z_jgbz=$User->sum('jb');
		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
			$map['zt']=2;
		}else{
			$map['zt']=2;
			$map['datatype']="qglkb";
		}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'jydate  desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		
		$countlkb = $User->where($map)->sum('lkb');
		$jb = $User->where($map)->sum('jb');
		
		
		
		
		if($start && $end){
			$list= M('ppdd')->where("`date`> '".$start."' AND `date` < '".$end."' AND `zt`=2")->select();
			
		}
		
		
		$this->assign('countlkb',$countlkb);
		$this->assign('countjb',$jb);
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		
		$this->display('index/jywc');
	}
	 public function cswc(){
		$User = M ( 'ppdd' ); // 實例化User對象
		$start=I('post.start');
		$end=I('post.end');
    	$data = I ( 'post.user' );
		$gname=$data;
        //$this->z_jgbz=$User->sum('jb');
		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
			$map['zt']=2;
		}else{
			$map['zt']=2;
			$map['datatype']="cslkb";
		}
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'jydate  desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		
		$countlkb = $User->where($map)->sum('lkb');
		$jb = $User->where($map)->sum('jb');
		
		
		
		
		if($start && $end){
			$list= M('ppdd')->where("`date`> '".$start."' AND `date` < '".$end."' AND `zt`=2")->select();
			
		}
		
		
		$this->assign('countlkb',$countlkb);
		$this->assign('countjb',$jb);
		$this->assign('count',$count);
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		
		$this->display('index/cswc');
	}
	public function qiugoudel(){
		$id=$_GET['id'];
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}
	public function csdddel(){
		$id=$_GET['id'];
		$result=M('ppdd')->where(array('id'=>$id))->find();
		$users=M('user')->where(array('UE_account'=>$result['p_user']))->find();
		$user1=M('user')->where(array('UE_account'=>$result['p_user']))->setInc('UE_money',$users['djmoney']);
		$user=M('user')->where(array('UE_account'=>$result['p_user']))->setDec('djmoney',$users['djmoney']);
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}
	public function jywcdel(){
		$id=$_GET['id'];
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}
	public function qxjy(){
		$id = $_GET['id'];
		$map['id']=$id;
		/* $data_P=$_GET['id'];
		$map['id']=$data_P;
		$map['zt']=1;
		$map['_string']="(p_user = {$_SESSION['uname']} or g_user = {$_SESSION['uname']})"; */
		$result=M('ppdd')->where($map)->find();//出售人信息
		
		 /* if(!$result){
			 $this->ajaxReturn('你暂无正在交易中的订单');

		}  */
		$oob=M('user')->where(array('UE_account'=>$result['g_user']))->setInc('UE_money',$result['lkb']);//购币人信息
		
		$obs=M('user')->where(array('UE_account'=>$result['g_user']))->setDec('djmoney',$result['lkb']);
		
		
		if($oob && $obs){
			$re=M('ppdd')->where(array('id'=>$id))->delete();
			if($re){
				$this->success('订单删除成功');
				}	
		
		}
	}
    /* NOTED BY SKYRIM: 接受帮助、列表 */
    public function jsbz_list(){
    
    
    	
    	$User = M ( 'jsbz' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
        $this->z_jgbz=$User->sum('jb');
        $this->z_jgbz2=$User->where(array('zt'=>'1'))->sum('jb');
        $this->z_jgbz3=$User->where(array('zt'=>array('neq','1')))->sum('jb');
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));

    		$map['zt']=0;

    	if(I ( 'get.cz' )==1){
    		$map['zt']=1;
    	}
    	if($data<>''){
    		$map['user']=$data;
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'date ' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/jsbz_list');
    }
    
    
    
    public function ppdd_list(){
    
    
    	 
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	if($data<>''){
    		$map['id']=$data;
    	}else{
    
    	$map['zt']=array('neq',2);
    
    	if(I ( 'get.cz' )==1){
    		$map['zt']=array('eq',2);;
    	}
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'date ' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    	/**/
    	$ppddNum = M('ppdd')->where($map)->count();
    	$ppddJbSum = M('ppdd')->where($map)->sum('jb');
    	$this->assign('ppddNum',$ppddNum);
    	$this->assign('ppddJbSum',$ppddJbSum);
    	/**/
    	   
    
    	$this->display('index/ppdd_list');
    }
    
    
    
    
    public function ts1_list(){
    
    
    
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	
    	$map['zt']=array('neq',2);
    	$map['ts_zt']=array('eq',1);;
    	
    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/ts1_list');
    }
    
    
    
    
    
        
    public function ts3_list(){
    
    
    
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	 
    	$map['zt']=array('neq',2);
    	$map['ts_zt']=array('eq',2);;
    	 
    	 
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/ts3_list');
    }
    
    public function ts2_list(){
    
    
    
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	 
    	$map['zt']=array('neq',2);
    	$map['ts_zt']=array('eq',3);;
    	 
    	 
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/ts2_list');
    }
    
    
    
    
    
    
    public function ts1_list_cl(){
    
    $ppddxx=M('ppdd')->where(array('id'=>I('get.id')))->find();
    M('tgbz')->where(array('id'=>$ppddxx['p_id']))->save(array('zt'=>0,'qr_zt'=>0));
    M('jsbz')->where(array('id'=>$ppddxx['g_id']))->save(array('zt'=>0,'qr_zt'=>0));
    M('ppdd')->where(array('id'=>I('get.id')))->delete();
    $this->success('重新匹配成功');
    }
    
    
    public function ts3_list_cl(){
    
    	$ppddxx=M('ppdd')->where(array('id'=>I('get.id')))->find();
    	M('tgbz')->where(array('id'=>$ppddxx['p_id']))->save(array('zt'=>0,'qr_zt'=>0));
    	M('jsbz')->where(array('id'=>$ppddxx['g_id']))->save(array('zt'=>0,'qr_zt'=>0));
    	M('ppdd')->where(array('id'=>I('get.id')))->delete();
    	M('user_jj')->where(array('r_id'=>$ppddxx['id']))->delete();
    	M('user_jl')->where(array('r_id'=>$ppddxx['id']))->delete();
    	$this->success('重新匹配成功');
    }
    
    
    
    
    public function ts2_list_cl(){
    
    	$ppddxx=M('ppdd')->where(array('id'=>I('get.id')))->find();
    	M('tgbz')->where(array('id'=>$ppddxx['p_id']))->save(array('zt'=>0,'qr_zt'=>0));
    	M('jsbz')->where(array('id'=>$ppddxx['g_id']))->save(array('zt'=>0,'qr_zt'=>0));
    	M('ppdd')->where(array('id'=>I('get.id')))->delete();
    	$this->success('重新匹配成功');
    }
    
    
    
    
    
    
    
    public function tgbz_list_sd(){
    	if(I ( 'get.id' )<>''){
			if(!stristr($_SERVER['HTTP_REFERER'],ACTION_NAME))//初始化选中值
			{
				$_SESSION['check_p']['check_id']=",";
				$_SESSION['check_p']['check_money']=0;
			}
			$tgbzuser=M('tgbz')->where(array('id'=>I ( 'get.id' )))->find();
			$this->tgbzuser=$tgbzuser;
			if($tgbzuser['zffs1']=='1'){$zffs1='1';}else{$zffs1='5';}
			if($tgbzuser['zffs2']=='1'){$zffs2='1';}else{$zffs2='5';}
			if($tgbzuser['zffs3']=='1'){$zffs3='1';}else{$zffs3='5';}
			$User = M ( 'jsbz' ); // 實例化User對象
			$data = I ( 'post.user' );
			
			
			$where['zffs1']  = $zffs1;
			$where['zffs2']  = $zffs2;
			$where['zffs3']  = $zffs3;
			$where['_logic'] = 'or';
			$map['_complex'] = $where;
			$map['zt']=0;
	
			$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
			//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
		
			$p = getpage($count,20);
		
			$list = $User->where ( $map )->order ( 'date ' )->limit ( $p->firstRow, $p->listRows )->select ();
			//dump($list);die;
			$this->assign ( 'list', $list ); // 賦值數據集
			$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
			
			//已选择的数据 
			if(!empty($_SESSION['check_p']['check_money']))
			{
				$this->assign ('check_array', explode(",",$_SESSION['check_p']['check_id']));
			}
			$this->assign ( 'check_id', $_SESSION['check_p']['check_id']);
			$this->assign ( 'check_money', $_SESSION['check_p']['check_money']);
			
		
			$this->display('index/tgbz_list_sd');
    	}
    }
	//记录选中的_SESSION
    public function tgbz_list_sd_cookie()
	{
		$_SESSION['check_p']['check_id']=I('get.id');
		$_SESSION['check_p']['check_money']=I('get.money');
	}
    
    public function jsbz_list_sd(){
    	if(I ( 'get.id' )<>''){
    		if(!stristr($_SERVER['HTTP_REFERER'],ACTION_NAME))//初始化选中值
			{
				$_SESSION['check_p']['check_id']=",";
				$_SESSION['check_p']['check_money']=0;
			}
    		$tgbzuser=M('jsbz')->where(array('id'=>I ( 'get.id' )))->find();
    		$this->tgbzuser=$tgbzuser;
    		if($tgbzuser['zffs1']=='1'){$zffs1='1';}else{$zffs1='5';}
    		if($tgbzuser['zffs2']=='1'){$zffs2='1';}else{$zffs2='5';}
    		if($tgbzuser['zffs3']=='1'){$zffs3='1';}else{$zffs3='5';}
    		$User = M ( 'tgbz' ); // 實例化User對象
    		$data = I ( 'post.user' );
    		 
    		 
    		$where['zffs1']  = $zffs1;
    		$where['zffs2']  = $zffs2;
    		$where['zffs3']  = $zffs3;
    		$where['_logic'] = 'or';
    		$map['_complex'] = $where;
    		$map['zt']=0;
    
    		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    		//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    		$p = getpage($count,20);
    
    		$list = $User->where ( $map )->order ( 'date ' )->limit ( $p->firstRow, $p->listRows )->select ();
    		//dump($list);die;
    		$this->assign ( 'list', $list ); // 賦值數據集
    		$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    		//已选择的数据 
			if(!empty($_SESSION['check_p']['check_money']))
			{
				$this->assign ('check_array', explode(",",$_SESSION['check_p']['check_id']));
			}
			$this->assign ( 'check_id', $_SESSION['check_p']['check_id']);
			$this->assign ( 'check_money', $_SESSION['check_p']['check_money']);
    
    
    		$this->display('index/jsbz_list_sd');
    	}
    }
    
    
    
    
    
    
 public function tgbz_list_sd_cl(){
    	$data=I('post.');
    	$arr = explode(',',I('post.arrid'));
    	// deleted by skyrim
    	// purpose: arr isn't money
    	// version: 7
    	// // added by skyrim
    	// // purpose: check money in range
    	// // version: 4
		// $settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		// var_dump( $arr );
		// foreach( $arr as $q ){
		// 	var_dump( $q  );
		// 	if( $settings['supply_money_upper_limit'] < $q || $q < $settings['supply_money_lower_limit'] ){
		// 		echo ';金额不在范围内';
		// 	//	$this->error('金额不在范围内!');
		// 		
		// 		return;
		// 	}
		// }
    	// // added ends
    	// deleted ends
    	//dump($arr);
    	$p_user=M('tgbz')->where(array('id'=>$data['pid']))->find();
    	global $p_id2;
    	$p_id2=$data['pid'];
    	if($data['arrzs']<>$data['jb']){
    		$this->success('匹配金额不等!');
    	}else{
    		$pipeits = 0;
    		
    		
    		foreach($arr as $val){
    			$g_user=M('jsbz')->where(array('id'=>$val))->find();
    			//echo $g_user['user'].'<br>';
    			//echo $p_user['user'].'<br>';die;
    			if($g_user['user']==$p_user['user']){
    				$sfxd = '1';break;
    			}else{
    				$sfxd = '0';
    			}
    		}
    		
    		if($sfxd == '0'){
    		
    		foreach($arr as $val){
    			
    			if($val<>''){
    				//$p_id2充值ID ,$val提现ID
    				
    		    if(ppdd_add($p_id2,$val)){
    		    	$pipeits++;
    		    	M('tgbz')->where(array('id'=>$data['pid']))->setInc('cf_ds',1);
    		    }
    			}
    		}
    		}else{
    		    $usercf='用户名重复';
    		}
    		if($pipeits<>'0'){
    		$p_user1=M('tgbz')->where(array('id'=>$data['pid']))->find();
    		$tj_ppdd=M('ppdd')->where(array('p_id'=>$p_user1['id']))->select();
    		
    		foreach($tj_ppdd as $value){
    		
    		$data2['zffs1']=$p_user1['zffs1'];
    		$data2['zffs2']=$p_user1['zffs2'];
    		$data2['zffs3']=$p_user1['zffs3'];
    		$data2['user']=$p_user1['user'];
    		$data2['jb']=$value['jb'];
    		$data2['user_nc']=$p_user1['user_nc'];
    		$data2['user_tjr']=$p_user1['user_tjr'];
    		$data2['date']=$p_user1['date'];
    		$data2['zt']=$p_user1['zt'];
    		$data2['qr_zt']=$p_user1['qr_zt'];
    		$varid = M('tgbz')->add($data2);
    		
    		M('ppdd')->where(array('id'=>$value['id']))->save(array('p_id'=>$varid));
    		
    		}
    		
    		M('tgbz')->where(array('id'=>$data['pid']))->delete();
    		M('user_jj')->where(array('tgbz_id'=>$data['pid']))->save(array('zt'=>3));
    		}
    		$_SESSION['check_p']['check_id']=",";
			$_SESSION['check_p']['check_money']=0;
    		
    		$this->success('匹配成功!拆分成'.$pipeits.'条订单,'.$usercf.'!');
    	}
    }
    
    
    /* NOTED BY SKYRIM: 接受帮助、手动处理*/
    public function jsbz_list_sd_cl(){
    	$data=I('post.');
    	$arr = explode(',',I('post.arrid'));//充值IP
    	// deleted by skyrim
    	// purpose: arr isn't money
    	// version: 7
    	// // added by skyrim
    	// // purpose: check money in range
    	// // version: 4
		// $settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		// 
		// foreach( $arr as $q ){
		// 	if( $settings['supply_money_upper_limit'] < $q || $q < $settings['supply_money_lower_limit'] ){
		// 		$this->error('金额不在范围内!');
		// 		
		// 		return;
		// 	}
		// }
    	// // added ends
    	// deleted ends
    	//dump($arr);
    	$p_user=M('jsbz')->where(array('id'=>$data['pid']))->find();//提现订单
    	global $p_id2;
    	$p_id2=$data['pid'];//提现ID
    	if($data['arrzs']<>$data['jb']){
    		$this->success('匹配金额不等!');
    	}else{
    		$pipeits = 0;
    
    
    		foreach($arr as $val){
    			$g_user=M('tgbz')->where(array('id'=>$val))->find();
    			//echo $g_user['user'].'<br>';
    			//echo $p_user['user'].'<br>';die;
    			if($g_user['user']==$p_user['user']){
    				$sfxd = '1';break;
    			}else{
    				$sfxd = '0';
    			}
				
    		}
    
    		if($sfxd == '0'){
    
    			foreach($arr as $val){
    				 
    				if($val<>''){
                         //$val充值人  ,$p_id2提现人
    					if(ppdd_add2($val,$p_id2)){
    						$pipeits++;
    						//M('jsbz')->where(array('id'=>$data['pid']))->setInc('cf_ds',1);
    					}
    				}
    			}
    		}else{
    			$usercf='用户名重复';
    		}
    		
    		
    		
    		//拆分充值
    		if($pipeits<>'0'){
    		
    		$p_user1=M('jsbz')->where(array('id'=>$data['pid']))->find();
    		$tj_ppdd=M('ppdd')->where(array('g_id'=>$p_user1['id']))->select();
    		
    		foreach($tj_ppdd as $value){
    		
    			$data2['zffs1']=$p_user1['zffs1'];
    			$data2['zffs2']=$p_user1['zffs2'];
    			$data2['zffs3']=$p_user1['zffs3'];
    			$data2['user']=$p_user1['user'];
    			$data2['jb']=$value['jb'];
    			$data2['user_nc']=$p_user1['user_nc'];
    			$data2['user_tjr']=$p_user1['user_tjr'];
    			$data2['date']=$p_user1['date'];
    			$data2['zt']=$p_user1['zt'];
    			$data2['qr_zt']=$p_user1['qr_zt'];
    			$varid = M('jsbz')->add($data2);
    		
    			M('ppdd')->where(array('id'=>$value['id']))->save(array('g_id'=>$varid));
    			
    		}
    		
    		M('jsbz')->where(array('id'=>$data['pid']))->delete();
    		}
    		
    		//拆分充值
    		
    		
    		$_SESSION['check_p']['check_id']=",";
			$_SESSION['check_p']['check_money']=0;
    		
    		
    		$this->success('匹配成功!拆分成'.$pipeits.'条订单,'.$usercf.'!');
    	}
    }
    
    
    
    public function zdpp_cl(){
    	

    	$tgbz_user = M('tgbz')->where (array('zt'=>'0'))->select();
    	$pipeits = 0;
    	foreach($tgbz_user as $val){
    		
    	//dump();die;
    	$jsbz_list=tgbz_zd_cl($val['id']);
    	foreach($jsbz_list as $val1){
    		//echo $val['jb'].'--<br>';
    		//echo $val1['jb'].'<br>';
    		
    		if($val['jb']==$val1['jb']&&$val['user']<>$val1['user']){//如果匹配成功处理
    			if(ppdd_add($val['id'],$val1['id'])){
    				$pipeits++;
    				M('tgbz')->where(array('id'=>$val['id']))->save(array('cf_ds'=>'1'));
    				break;
    			}
    		}
    		
    	}

    	}
    	echo('成功匹配订单'.$pipeits.'条');
    	
    	
    }
    
    public function zdpp_cl2(){
    	 
    
    	$tgbz_user = M('tgbz')->where (array('zt'=>'0'))->select();
    	$pipeits = 0;
    	foreach($tgbz_user as $val){
    
    		//dump();die;
    		$jsbz_list=tgbz_zd_cl($val['id']);
    		$i='0';
    		foreach($jsbz_list as $val1){
    			if($val['user']<>$val1['user']){
    			$jsbz_list2[$i]=$val1['id'];
    			$i++;
    			}
    		}
    		//echo $val['jb'];die;
    		//dump($jsbz_list2);die;
    		
    		$xypipeije=$val['jb'];
    		$data=$jsbz_list2;
    		$tj=count($data);
    		//echo $tj;die;
    		$sf_tcpp='0';
    		for ($b=0;$b<$tj;$b++){
    			if($sf_tcpp=='1'){break;}
    			$tj_j=$tj-1;
    			//echo '===========<br>';
    			for ($i=0;$i<$tj;$i++){
    				if($b<$i){
    					$pipeihe=jsbz_jb($data[$b])+jsbz_jb($data[$tj_j]);
    					if($pipeihe==$xypipeije){
    						$g_a =$data[$b];
    						$g_b =$data[$tj_j];
    						$sf_tcpp='1';break;
    					}
    		
    						
    						
    					$tj_j--;
    				}
    			}
    		}
    		//echo $val['id'].'主<br>';
    		//echo $g_a.'<br>';
    		//echo $g_b.'<br>';
    		if($g_a<>''&&$g_b<>''){
    			
    		if(ppdd_add($val['id'],$g_a)&&ppdd_add($val['id'],$g_b)){
    			$pipeits++;
    			M('tgbz')->where(array('id'=>$val['id']))->save(array('cf_ds'=>'1'));
    			echo '主ID:'.$val['id'].'金币:'.$val['jb'].'=副A:'.$g_a.'金币:'.jsbz_jb($g_a).'+副B:'.$g_b.'金币:'.jsbz_jb($g_b).'<br>';
    		}
    		}
    		
              //拆分充值
    	if($sf_tcpp=='1'){
    		$p_user1=M('tgbz')->where(array('id'=>$val['id']))->find();
    		$tj_ppdd=M('ppdd')->where(array('p_id'=>$p_user1['id']))->select();
    		
    		foreach($tj_ppdd as $value){
    		
    			$data2['zffs1']=$p_user1['zffs1'];
    			$data2['zffs2']=$p_user1['zffs2'];
    			$data2['zffs3']=$p_user1['zffs3'];
    			$data2['user']=$p_user1['user'];
    			$data2['jb']=$value['jb'];
    			$data2['user_nc']=$p_user1['user_nc'];
    			$data2['user_tjr']=$p_user1['user_tjr'];
    			$data2['date']=$p_user1['date'];
    			$data2['zt']=$p_user1['zt'];
    			$data2['qr_zt']=$p_user1['qr_zt'];
    			$varid = M('tgbz')->add($data2);
    		
    			M('ppdd')->where(array('id'=>$value['id']))->save(array('p_id'=>$varid));
    		
    		}
    		
    		M('tgbz')->where(array('id'=>$val['id']))->delete();
    		
    		}
              //拆分充值
    
    	}
    	echo('成功匹配订单'.$pipeits.'条');
    	 
    	 
    }
    public function tgbz_list_cf(){
    
    
    	$User = M ( 'tgbz' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	$this->z_jgbz=$User->sum('jb');
    	$this->z_jgbz2=$User->where(array('qr_zt'=>'1'))->sum('jb');
    	$this->z_jgbz3=$User->where(array('qr_zt'=>array('neq','1')))->sum('jb');
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
    
    	$map['zt']=0;
    
    	if(I ( 'get.cz' )==1){
    		$map['zt']=1;
    	}
    	if($data<>''){
    		$map['user']=$data;
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/tgbz_list_cf');
    }
    
    public function jsbz_list_cf(){
    
    
    
    	$User = M ( 'jsbz' ); // 實例化User對象
    	$data = I ( 'post.user' );
    
    	$this->z_jgbz=$User->sum('jb');
    	$this->z_jgbz2=$User->where(array('qr_zt'=>'1'))->sum('jb');
    	$this->z_jgbz3=$User->where(array('qr_zt'=>array('neq','1')))->sum('jb');
    	//$map ['UG_dataType'] = array('IN',array('mrfh','tjj','kdj','mrldj','glj'));
    
    	$map['zt']=0;
    
    	if(I ( 'get.cz' )==1){
    		$map['zt']=1;
    	}
    	if($data<>''){
    		$map['user']=$data;
    	}
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	//$page = new \Think\Page ( $count, 3 ); // 實例化分頁類 傳入總記錄數和每頁顯示的記錄數(25)
    
    	$p = getpage($count,20);
    
    	$list = $User->where ( $map )->order ( 'id' )->limit ( $p->firstRow, $p->listRows )->select ();
    	//dump($list);die;
    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
    
    
    
    	$this->display('index/jsbz_list_cf');
    }
    
    public function tgbz_list_cf_cl(){
    	$data=I('post.');
    	$p_user=M('tgbz')->where(array('id'=>$data['pid']))->find();
    	if (! preg_match ( '/^[0-9,]{1,100}$/', I('post.arrid') )) {
    		$this->error( '格式不对!' );
    		die;
    	}
    	$arr = explode(',',I('post.arrid'));
    	//dump($arr);
    	if(array_sum($arr)<>$p_user['jb']){
    		$this->error( '拆分金额不对!' );
    		die;
    	}
    	// added by skyrim
    	// purpose: check money in range
    	// version: 4
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		
		foreach( $arr as $q ){
			if( $settings['supply_money_upper_limit'] < $q || $q < $settings['supply_money_lower_limit'] ){
				$this->error('金额不在范围内!');
				
				return;
			}
		}
    	// added ends
    
    
    
    
    	$p_user1=M('tgbz')->where(array('id'=>$data['pid']))->find();
    
    	$pipeits=0;
    	foreach($arr as $value){
    		if($value<>''){
    			$data2['zffs1']=$p_user1['zffs1'];
    			$data2['zffs2']=$p_user1['zffs2'];
    			$data2['zffs3']=$p_user1['zffs3'];
    			$data2['user']=$p_user1['user'];
    			$data2['jb']=$value;
    			$data2['user_nc']=$p_user1['user_nc'];
    			$data2['user_tjr']=$p_user1['user_tjr'];
    			$data2['date']=$p_user1['date'];
    			$data2['zt']=$p_user1['zt'];
    			$data2['qr_zt']=$p_user1['qr_zt'];
    			$varid = M('tgbz')->add($data2);
    			$pipeits++;
    		}
    		 
    
    	}
    
    	M('tgbz')->where(array('id'=>$data['pid']))->delete();
    
    
    
    
    	$this->success('匹配成功!拆分成'.$pipeits.'条订单!');
    }
    
    public function jsbz_list_cf_cl(){
    	$data=I('post.');
    	$p_user=M('jsbz')->where(array('id'=>$data['pid']))->find();
    	if (! preg_match ( '/^[0-9,]{1,100}$/', I('post.arrid') )) {
    		$this->error( '格式不对!' );
    		die;
    	}
    	$arr = explode(',',I('post.arrid'));
    	//dump($arr);
    	if(array_sum($arr)<>$p_user['jb']){
    		$this->error( '拆分金额不对!' );
    		die;
    	}
    	// added by skyrim
    	// purpose: check money in range
    	// version: 4
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		
		foreach( $arr as $q ){
			if( $settings['supply_money_upper_limit'] < $q || $q < $settings['supply_money_lower_limit'] ){
				$this->error('金额不在范围内!');
				
				return;
			}
		}
    	// added ends
    	 
    	 
    	 
    	 
    	$p_user1=M('jsbz')->where(array('id'=>$data['pid']))->find();
    	 
    	$pipeits=0;
    	foreach($arr as $value){
    		if($value<>''){
    			$data2['zffs1']=$p_user1['zffs1'];
    			$data2['zffs2']=$p_user1['zffs2'];
    			$data2['zffs3']=$p_user1['zffs3'];
    			$data2['user']=$p_user1['user'];
    			$data2['jb']=$value;
    			$data2['user_nc']=$p_user1['user_nc'];
    			$data2['user_tjr']=$p_user1['user_tjr'];
    			$data2['date']=$p_user1['date'];
    			$data2['zt']=$p_user1['zt'];
    			$data2['qr_zt']=$p_user1['qr_zt'];
    			$varid = M('jsbz')->add($data2);
    			$pipeits++;
    		}
    
    		 
    	}
    	 
    	M('jsbz')->where(array('id'=>$data['pid']))->delete();
    	 
    	 
    	 
    	 
    	$this->success('匹配成功!拆分成'.$pipeits.'条订单!');
    }
     
    // added by skrim
    // purpose: custom settings
    // version: 4.0
	public function settings( $templ = '' ){

		// var_dump($_POST);exit();
		// echo $templ;exit();
		$settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		if( IS_POST ){
			if($_POST['jiaoyi_shouxu']!=""){
			$_POST['jiaoyi_shouxu']=floatval($_POST['jiaoyi_shouxu']/100.0);
			}
			if($_POST['ztlv']!=""){
				$_POST['ztlv']=floatval($_POST['ztlv']/100.0);
			}
			if($_POST['hzlv']!=""){
				$_POST['hzlv']=floatval($_POST['hzlv']/100.0);
			}
			if($_POST['cylv']!=""){
				$_POST['cylv']=floatval($_POST['cylv']/100.0);
			}
			if($_POST['hblv']!=""){
				$_POST['hblv']=floatval($_POST['hblv']/100.0);
			}
			if($_POST['gjlv']!=""){
				$_POST['gjlv']=floatval($_POST['gjlv']/100.0);
			}
			// deleted by skyrim
			// purpose: custom share
			// version: 6.0
			// foreach( $_POST['jl'] as $k=>$v ){
			// 	$_POST['jl'][$k] = $v;
			// }
			// deleted ends
			// added by skyrim
			// purpose: custom share
			// version: 6.0
			foreach( $_POST['jl_share'] as $k=>$v ){
				$_POST['jl_share'][$k] = floatval( $v ) / 100.0;
			}
			foreach( $_POST['masses_share'] as $k=>$v ){
				$_POST['masses_share'][$k] = floatval( $v ) / 100.0;
			}
			// added ends
			foreach( $settings as $k=>$v ){
				if( isset( $_POST[$k] ) ){
					$settings[$k] = $_POST[$k];
				}
			}
			$file_length = file_put_contents( dirname( APP_PATH ) . '/User/Home/Conf/settings.php', '<?php return ' . var_export( $settings, true ) . '; ?>' );
			if( $file_length ){
				$this->success('保存成功！');
			} else {
				$this->error('保存失败！请检查文件权限');
			}
			return;
		}
		
		foreach( $settings as $k=>$v ){
			// added by skyrim
			// purpose: custom share
			// version: 6.0
			if( $k == 'jl_share' || $k == 'masses_share' ){
				foreach( $v as $kk=>$vv ){
					$v[$kk] = floatval( $vv ) * 100;
				}
			}
			//var_dump( " $k ==> $v " );
			// added ends
			$this->assign( $k, $v );
		}
// added by skyrim
// purpose: seperate masses and managers
// version: 5.0
		$this->assign( 'settings', $settings );
// added ends

		$this->display( $templ );
	}
	//added ends
	public function pre_deposit(){
		$this->settings( 'pre_deposit' );
	}
	public function ktghgl(){
		$result=M('user')->where(array('UE_account'=>$_GET['user']))->data(array('ktghgl'=>2))->save();
		//dump($result);die;
		if($result){
			$this->success('已开通');
		}else{
			die("<script>alert('开通失败');history.back(-1);</script>");
		}
	}
	public function gbghgl(){
		$result=M('user')->where(array('UE_account'=>$_GET['user']))->data(array('ktghgl'=>1))->save();
		if($result){
			$this->success('已关闭');
		}else{
			die("<script>alert('关闭失败');history.back(-1);</script>");
		}
	}
	public function userlist11(){
		$paixu=I('post.paixu');
		$User = M ( 'user' ); // 實例化User對象
		$data = I ( 'post.user' );
		$a=strlen($data);
		if($a){
			$map['UE_account']=$data;
		}
		$na=M('user')->where(array('UE_account'=>$data))->find();
		if(I ( 'get.ip' )<>''){
			$map['UE_regIP']=I ( 'get.ip' );
		}
		$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數		 
		$p = getpage($count,20);
		$list = $User->where ( $map )->order ( 'UE_ID DESC' )->limit ( $p->firstRow, $p->listRows )->select ();
		//dump($list);die;
		if($paixu!=""){
			$list = $User->where ( $map )->order ( 'UE_money desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		}
		$this->assign('count',$count);
		$this->assign ( 'list', $list ); // 賦值數據集
		$this->assign ( 'page', $p->show() ); // 賦值分頁輸出
		 
		 
		 
		$this->display('index/userlist');
	}
	public function kjsy(){
		 $settings = include( dirname( APP_PATH ) . '/User/Home/Conf/settings.php' );
		 $users=M('user');
		 $userget=M('userget');
		 $shop_orderform = M('shop_orderform');
		 $map['UE_stop']=1;
		 $self = $users->where($map)->order('UE_ID DESC')->count();
		 $proall = $userget->where()->count();//s查矿车收益数据库里UG_ID等于当前会员的
		 //dump($proall);die;
		 $NowTime = $proall['ug_gettime'];//结算时间
	 	 $aab=strtotime($NowTime);//把结算时间日期转换成时间戳
		 $day1 = $aab;//结算时间戳
	 	 $day2 = time();//当前时间
 		 
		if ($day1 < $day2) {
			$tmp = $day2;
			$day2 = $day1;
			$day1 = $tmp;
		} 
		$diff = intval(($day1 - $day2) / 3600);
		
		
		//$diff = diffBetweenTwoDays($day1, $day2);//计算$day1、$day2两个日期相差的时间
		 if($diff>$proall['yxzq']){//判断相差时间大于720小时
	 		$diff=$proall['yxzq'];//就等于相差时间等于720小时
	 	}
		$lixi=$diff*$proall['lixi'];//相差时间乘以矿机收益
		$zqlx=$proall['lixi']*$proall['status'];//矿机收益乘以.......
		$kcxx= $shop_orderform->where(array('id'=>$proall['kcid']))->find();//查询矿车数据库里id等于矿车收益数据库里的kcid
		$user = $users->where(array('UE_account'=>$proall['ug_account']))->find();//查询user数据表里的会员等于矿车收益里的登录账号
		if($diff==$proall['yxzq']){//判断如果相差时间等于720小时
				$oobs= $shop_orderform->where(array('id'=>$proall['kcid']))->data(array('zt'=>2))->save();//查询矿车数据库里的id等于矿车收益数据库里的kcid，更改矿车数据库里的zt字段等于2（2=当前矿车运行完毕）
			}
		 //每点击一次矿机收益增加记录
		 if($diff>$proall['status']){
			$lixi=$lixi-$zqlx;
			$map['UG_account']=$_SESSION['uname'];
			$map['UG_getTime'] = date('Y-m-d H:i:s',time());
			$map['UG_note'] = $kcxx['project'].'收入';
			//$map['enUG_note'] = $kcxx['enproject'].award;
			$map['UG_money'] = $lixi;
			$map['gmkjh'] = $kcxx['kjbh'];
			//$map['UG_money'] = $zsl;
			$map['UG_dataType'] = 'kjsr';
			$map['nickname'] = $self['ue_truename'];//本人信息
			$map['gzzq'] = $diff;
			$cunru=$userget->add($map);
			$userss = $users->where(array('UE_account'=>$proall['ug_account']))->setInc("UE_money",$lixi);
			//遍历上级 加入奖金
			$settings = include( APP_PATH . 'Home/Conf/settings.php' );
			$ooob=$users->where(array('UE_account'=>$user['ue_accname']))->find();
					if($ooob['level']>=1){
						//$result = $users->where(array('UE_account'=>$_SESSION['uname']))->find();
						$result1 =  $users->where(array('UE_account'=>$self['ue_accname']))->find();
						$order= $shop_orderform->where(array('user'=>$self['ue_account']))->sum('sumprice');
						$order1 = $shop_orderform->where(array('user'=>$result1['ue_account']))->sum('sumprice');
						$money = $lixi;
						
						if($order>$order1){
							$money = $money/2;
						}
						$money=$money*$settings['ztlv'];
						$money=number_format($money,8);
						$tuandui=$users->where(array('UE_account'=>$self['ue_accname']))->setInc('UE_money',$money);
						$resu =	$users->where(array('UE_account'=>$self['ue_accname']))->find();
						$record3 ["UG_account"] = $result1['ue_account']; // 登入轉出賬戶
						$record3 ["UG_type"] = 'lkb';
						$record3 ["UG_allGet"] = $result1['ue_money']; // 金幣
						$record3 ["UG_money"] = '+'.$money; //
						$record3 ["UG_balance"] = $resu['ue_money']; // 當前推薦人的金幣餘額
						$record3 ["UG_dataType"] = 'tdj'; // 金幣轉出
						$record3 ["UG_note"] = "算力收益"; // 推薦獎說明
						$record3 ["enUG_note"]="award";
						$record3["UG_getTime"]		= date ( 'Y-m-d H:i:s', time () ); //操作時間
						$record3["UG_othraccount"] = $self['ue_truename'];
						$record3["nickname"] = $self['ue_truename'];
						$reg4 = $userget->add ( $record3 );
					}				
			//内容见上		
			$proall= $userget->where(array('UG_ID'=>$var))->data(array('status'=>$diff))->save();		
		}
		 return $lixi;
	 }
}