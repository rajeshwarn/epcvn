<?php
	class Default_Blocks_Static extends Zend_View_Helper_Abstract{

		public function getStatic(){
			$model = new Default_Model_UserOnline();

	        $user_online = new Zend_Session_Namespace('user_online');
	        $time = time();
	        $timecheck = $time - 600;

	        $user_online->id = Zend_Session::getId();

			$count = $model->UserOnline('count',$user_online->id);
			if($count == 0){
				$model->UserOnline('insert',$user_online->id,$time);
			}else{
				$model->UserOnline('update',$user_online->id,$time);

			}
			$model->UserOnline('delete',null,$time,$timecheck);
			echo $model->UserOnline('count_all',$user_online->id);
		}
		public function getView(){
			$model = new Default_Model_Visited();
			$time = date("Y-m-d", time());

			$visited = new Zend_Session_Namespace('visited');

			$count = $model->Visited('count',$time);
			$data = array();
			if($count == 0){
				$model->Visited('insert',$time);
	        	$visited->time = time();
			}
			if((time() - $visited->time) >= 2000){
				$model->Visited('update',$time);
				$visited->time = time();

			}
			$day = date("Y-m-d",strtotime("-1 day"));
			$week = date("Y-m-d",strtotime("-1 week"));
			$month = date('Y-m-d',strtotime("-1 month"));

			$data['day'] = $model->Visited('count_day',$time,$day);
			$data['week'] = $model->Visited('count_day',$time,$week);
			$data['month'] = $model->Visited('count_day',$time,$month);
			$data['total'] = $model->Visited('count_total');
			return $data;
		}

	}

?>