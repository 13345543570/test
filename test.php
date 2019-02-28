<?php
//测试baiyi分支 哈哈哈
//测试master1测试
defined('BASEPATH') OR exit('No direct script access allowed');
我的天啊 你真的是很棒棒呢  这样操作也挺好啊 哈哈
class Home extends Admin_Controller {
测试 2019-2-28 10:13
	//首页
	public function index()
	{
		$action = $_POST['action'];
		switch($action){
			case 'pass':
				$this->data['pageurl'] = $this->data['url_dir'].'/mfcpzixun/home/pass';
				break;
			default:
				$this->data['pageurl'] = $this->data['url_dir'].'/mfcpzixun/home/info';
		}
		$this->load->view('admin/home.php',$this->data);
	}

	//网站信息
	public function info(){

		$getdata = $this->data_model;

		$info = $getdata->get_webinfo();

		$this->data['info'] = $info;
		$this->loadview('admin/info.php',$this->data);
	}

	//管理员管理
	public function user(){
		$user=$this->data_model->get_admin();
		$role=$this->data_model->get_role();
		$this->data['role']=$role;
		$this->data['user']=$user;
		$this->loadview('admin/user.php',$this->data);
	}

	//权限管理
	public function auth(){
		$auth=$this->data_model->get_auth();
		$this->data['auth']=$auth;
		$this->loadview("admin/auth.php",$this->data);
	}

	//角色管理
	public function role(){
		$role=$this->data_model->get_role();
		$this->data['role']=$role;
		$this->loadview('admin/role.php',$this->data);
	}

	//角色名权限添加
	public function rules(){
		define('IS_POST',strtolower($_SERVER["REQUEST_METHOD"]) == 'post');
		if(IS_POST){
			$arr=$this->input->post();
			$rules=implode(',',$arr['rule_ids']);
			$arr['rules']=$rules;
			$res=$this->db->query("update `tx_role` set `rules`='{$arr['rules']}' where `role_id`='{$arr['role_id']}'");
			if($res){
				showmsg("1",'权限添加成功');
			}else{
				showmsg($_SERVER['HTTP_REFERER'],'权限添加失败');
			}

		}else{
			$role_id=$this->uri->segment(4);
			$role=$this->data_model->get_role($role_id);
			$auth=$this->data_model->get_auth();
			$rules=explode(",",$role[0]['rules']);
			$this->data['auth']=$auth;
			$this->data['rules']=$rules;
			$this->data['id']=$role_id;
			$this->loadview("admin/rules.php",$this->data);

		}
	}

	//新闻管理
	public function content_manage(){

		$typeid = $_GET['typeid'];
		$status = $_GET['status'];
		$date = $_GET['date'];
		$keywords = $_GET['keywords'];
		$page = $_GET['page']?$_GET['page']:1;

		$getdata = $this->data_model;

		$newsinfo = $getdata->get_newmanage($typeid,$status,$date,$keywords,$page);

		$url = $this->data['url_dir'].'/mfcpzixun/home/content_manage?typeid='.$typeid.'&status='.$status.'&date='.$date.'&keywords='.$keywords;

		$fenye = fenye($page,10,$newsinfo['num'],$url);

		$this->data['fenye'] = $fenye;
		$this->data['typeid'] = $typeid;
		$this->data['status'] = $status;
		$this->data['date'] = $date;
		$this->data['newsinfo'] = $newsinfo['data'];
		$this->data['type'] = $getdata->get_newtype();
		$this->data['status'] = $getdata->get_newstatus();

		$this->loadview('admin/content_manage.php',$this->data);
	}

	//新闻添加
	public function addnew(){
		$id = $_GET['id'];

		$getdata = $this->data_model;

		if($id){
			$info = $getdata->get_new($id);
			$content = $getdata->get_newcontent($id);
			$stype = $getdata->get_firsttype();
			$this->data['stype'] = $stype;
			$this->data['info'] = $info;
			$this->data['content'] = th($content);
		}else{
			$stype = $getdata->get_firsttype();
			$this->data['stype'] = $stype;
		}

		$type = $getdata->get_newtype();
		$status = $getdata->get_newstatus();

		$this->data['type'] = $type;
		$this->data['status'] = $status;

		$this->loadview('admin/addnew.php',$this->data);
	}

	//密码修改
	public function pass(){
		$this->loadview('admin/pass.php',$this->data);
	}

	//栏目管理
	public function column(){

		$getdata = $this->data_model;
		$type = $getdata->get_newtype();


		$this->data['type'] = $type;
		$this->loadview('admin/column.php',$this->data);
	}

	//二级栏目管理
	public function second_column(){
		$getdata = $this->data_model;
		$stype=$getdata->get_secondtype();
		$this->data['stype'] = $stype;
		$this->loadview('admin/second_column.php',$this->data);
	}

	//首页轮播
	public function adv(){

		$getdata = $this->data_model;

		$listdata = $getdata->get_advnew();

		$this->data['listdata'] = $listdata;

		$this->loadview('admin/adv.php',$this->data);
	}

	//图集管理
	public function img_manage(){

		$status = $_GET['status'];
		$date = $_GET['date'];
		$keywords = $_GET['keywords'];
		$page = $_GET['page']?$_GET['page']:1;

		$getdata = $this->data_model;

		$imginfo = $getdata->get_imgmanage($status,$date,$keywords,$page);

		$url = $this->data['url_dir'].'/mfcpzixun/home/img_manage?status='.$status.'&date='.$date.'&keywords='.$keywords;
		$fenye = fenye($page,10,$imginfo['num'],$url);

		$this->data['fenye'] = $fenye;
		$this->data['status'] = $status;
		$this->data['keywords'] = $keywords;
		$this->data['date'] = $date;
		$this->data['imginfo'] = $imginfo['data'];



		$this->loadview('admin/img_manage.php',$this->data);
	}

	//添加图集
	public function addimg(){

		$id = $_GET['id'];

		$getdata = $this->data_model;

		if($id){
			$info = $getdata->get_img($id);
			$content = $getdata->get_imgcontent($id);

			$this->data['info'] = $info;
			$this->data['content'] = json_decode($content);
		}

		$this->loadview('admin/addimg.php',$this->data);
	}

	//广告管理
	public function ad(){

		$getdata = $this->data_model;
		$ad = $getdata->get_ad();


		$this->data['ad'] = $ad;
		$this->loadview('admin/ad.php',$this->data);
	}
	
	//标签管理
	public function tag(){

		$getdata = $this->data_model;
		$tag = $getdata->get_tag();


		$this->data['tag'] = $tag;
		$this->loadview('admin/tag.php',$this->data);
	}

	//友情链接
	public function f_link(){
		$page = $_GET['page']?$_GET['page']:1;

		$getdata = $this->data_model;
		$f_link = $getdata->get_f_link($page);

		$url = $this->data['url_dir'].'/mfcpzixun/home/f_link?';
		$fenye = fenye($page,6,$f_link['num'],$url);
		$this->data['fenye'] = $fenye;
		$this->data['f_link'] = $f_link['data'];
		$this->loadview('admin/f_link.php',$this->data);
	}
	/*******************************生成静态文件***********************************/
    //栏目更新
    public function makeColumn(){
    	$getdata = $this->data_model;
		$type = $getdata->get_newtype();
		$stype = $getdata->get_stype();
		$this->data['type'] = $type;
		$this->data['stype'] = $stype;
		$this->loadview('admin/makeColumn.php',$this->data);
    }
    //新闻更新
    public function makeNews(){
        $this->load->helper('url');

    	$typeid = $_GET['typeid'];
		$status = $_GET['status'];
		$date = $_GET['date'];
		$keywords = $_GET['keywords'];
		$page = $_GET['page']?$_GET['page']:1;

		$getdata = $this->data_model;

		$newsinfo = $getdata->get_newmanage($typeid,$status,$date,$keywords,$page);

		$url = $this->data['url_dir'].'/mfcpzixun/home/makeNews?typeid='.$typeid.'&status='.$status.'&date='.$date.'&keywords='.$keywords;

		$fenye = fenye($page,10,$newsinfo['num'],$url);

		$this->data['fenye'] = $fenye;
		$this->data['typeid'] = $typeid;
		$this->data['status'] = $status;
		$this->data['date'] = $date;
		$this->data['newsinfo'] = $newsinfo['data'];
		$this->data['type'] = $getdata->get_newtype();
		$this->data['status'] = $getdata->get_newstatus();


		$this->loadview('admin/makeNews.php',$this->data);
    }
    //图集更新
    public function makeImgs(){
    	$this->load->helper('url');

    	$status = $_GET['status'];
		$date = $_GET['date'];
		$keywords = $_GET['keywords'];
		$page = $_GET['page']?$_GET['page']:1;

		$getdata = $this->data_model;

		$imginfo = $getdata->get_imgmanage($status,$date,$keywords,$page);

		$url = $this->data['url_dir'].'/mfcpzixun/home/makeImgs?status='.$status.'&date='.$date.'&keywords='.$keywords;

		$fenye = fenye($page,10,$imginfo['num'],$url);

		$this->data['fenye'] = $fenye;
		$this->data['status'] = $status;
		$this->data['keywords'] = $keywords;
		$this->data['date'] = $date;
		$this->data['imginfo'] = $imginfo['data'];



		$this->loadview('admin/makeImgs.php',$this->data);
    }
    /******************************开奖结果******************************/
    public function result(){
    	$type=$_GET['type']?$_GET['type']:'ssq';
    	$year=$_GET['year']?$_GET['year']:date('Y');
    	$time=$_GET['time'];
    	if($type=='ssq'){
    		if($time){
    			$query=$this->db->query("select * from tx_ssq_result where year = ".$year." and time like '".$time."' order by time desc");
				$data=$query->result_array();
				foreach($data as $key=>$val){
					$data[$key]['result']=explode(',',$val['result']);
				}
    		}else{
    			$query=$this->db->query("select * from tx_ssq_result where year = ".$year." order by time desc");
				$data=$query->result_array();
				foreach($data as $key=>$val){
					$data[$key]['result']=explode(',',$val['result']);
				}
    		}
	    	
    	}else if($type=='dlt'){
    		if($time){
    			$query=$this->db->query("select * from tx_dlt_result where year = ".$year." and time like '".$time."' order by time desc");
				$data=$query->result_array();
				foreach($data as $key=>$val){
					$data[$key]['result']=explode(',',$val['result']);
				}
    		}else{
    			$query=$this->db->query("select * from tx_dlt_result where year = ".$year." order by time desc");
				$data=$query->result_array();
				foreach($data as $key=>$val){
					$data[$key]['result']=explode(',',$val['result']);
				}
    		}
    	}
    	$this->data['type']=$type;
    	$this->data['time']=$time;
		$this->data['data']=$data;
		$this->loadview('admin/result',$this->data);
    }
    public function addresult(){
    	$type=$_GET['type'];
    	if(!$type){showmsg($_SERVER['HTTP_REFERER'],'彩种信息缺失');}
    	$id=$_GET['id'];
    	if($id){
    		if($type=='ssq'){
    			$query=$this->db->query("select * from tx_ssq_result where id = ".$id);
				$info=$query->result_array()[0];
    		}else if($type=='dlt'){
    			$query=$this->db->query("select * from tx_dlt_result where id = ".$id);
				$info=$query->result_array()[0];
    		}
    		$this->data['info']=$info;	
    	}
    	$this->data['type']=$type;
    	$this->loadview('admin/addresult',$this->data);
    }
}
