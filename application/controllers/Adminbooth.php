<?php
defined('BASEPATH') or exit('No direct script access allowed');

require __DIR__ . '/../../vendor/autoload.php';
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\Printer;
use Mike42\Escpos\Experimental\Unifont\UnifontPrintBuffer;
use Mike42\Escpos\EscposImage;

class Adminbooth extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		// Set Timezone to Asia/Tokyo
		date_default_timezone_set("Asia/Tokyo");

	}

	public function index()
	{
		$data['title'] = 'レンタルブース管理システム';
		$this->load->view('header', $data);
		$this->load->view('admin_booth', $this->initPageData());
	}

	public function userBooth()
	{
		$data['title'] = 'レンタルブース管理システム';
		$this->load->view('header', $data);
		$this->load->view('user_booth', $this->initPageData());
	}

	public function settingPage()
	{
		$data['title'] = '管理者設定画面';
		$this->load->view('header', $data);
		$this->load->view('setting_page', $data);
	}

	public function initPageData()
	{
		$data = array();
		$box = array();

		$data['list'] = $this->booth_model->all_booth_list();
		$data['trans'] = $this->booth_model->all_transaction_list();
		$data['user'] = $this->booth_model->all_user_list();

		$mode = $this->isPriceType(mdate("%Y-%m-%d %h:%i:%s"));
		$data['mode'] = $mode;

		$data['box'] = $this->booth_model->all_box_list();
		$data['price'] = $this->getPriceArrayByMode($data['box'], $mode);

		$data['work_time'] = $this->booth_model->all_time_list();

		$data['users'] = $this->booth_model->all_user_list();

		$data['list_status'] = array('0' => 'room', '1' => 'room room-entranced', '2' => 'room room-paused');
		$data['list_status_pair'] = array('0' => 'room-xs', '1' => 'room-xs room-entranced', '2' => 'room-xs room-paused');
		$data['list_status_wheel'] = array('0' => 'wheelchair-seat', '1' => 'wheelchair-seat room-entranced', '2' => 'wheelchair-seat room-paused');

		$data['remain_seat_count'] = $this->getRemainSeatCountArray();

		return $data;
	}

	public function isPriceType($input_date)
	{
		$date = strtotime($input_date);
		$hour = date('H', $date);
		$min = date('i', $date);

		$work_time = array(); 
		$work_time = $this->booth_model->get_work_time_by_id(0);
		$start_time = DateTime::createFromFormat("H:i:s", $work_time[0]['start_time']);
		$end_time = DateTime::createFromFormat("H:i:s", $work_time[0]['end_time']);

		$mode = REGULAR_MODE;
		if ($hour >= (int) $start_time->format('H') && $hour <= (int) $end_time->format('H')) {
			if ($hour == (int) $end_time->format('H')) {
				if ($min >= (int) $end_time->format('i')) {
					$mode = NIGHT_MODE;
				}
			}
		} else {
			$mode = NIGHT_MODE;
		}

		return $mode;
	}

	public function getRemainSeatCountArray()
	{
		$remain_seats_count = array();
		$remain_seats_count[0] = $this->booth_model->remain_seat_count_by_box_id(0);
		$remain_seats_count[1] = $this->booth_model->remain_seat_count_by_box_id(1);
		$remain_seats_count[2] = $this->booth_model->remain_seat_count_by_box_id(2);
		$remain_seats_count[3] = $this->booth_model->remain_seat_count_by_box_id(3);

		return $remain_seats_count;
	}

	public function getPriceArrayByMode($box, $mode)
	{
		$price = array();
		$price[0] = $this->amountFormat($box[0][$mode]);
		$price[1] = $this->amountFormat($box[1][$mode]);
		$price[2] = $this->amountFormat($box[2][$mode]);
		$price[3] = $this->amountFormat($box[3][$mode]);
		return $price;
	}

	public function amountFormat(int $number, $separator = ",")
	{
		$decimal = substr($number, -3);
		$amount = substr($number, 0, -3) . $separator . $decimal;
		return $amount;
	}

	public function getGenderFromTitle($gender_title)
	{
		if ($gender_title == GENDER_MALE_TITLE) {
			$gender = GENDER_MALE;
		} else {
			$gender = GENDER_FEMALE;
		}

		return $gender;
	}

	public function getAgeFromTitle($title)
	{
		switch ($title) {
			case 'T1(20-29)':
				$age = 'T1';
				break;
			case 'T2(30-49)':
				$age = 'T2';
				break;
			case 'T3(50-64)':
				$age = 'T3';
				break;
			case 'T4(65-)':
				$age = 'T4';
				break;
			}
		return $age;
	}

	public function getAgeFromIndex($index)
	{
		switch ($index) {
			case 'T1':
				$age = 'T1(20-29)';
				break;
			case 'T2':
				$age = 'T2(30-49)';
				break;
			case 'T3':
				$age = 'T3(50-64)';
				break;
			case 'T4':
				$age = 'T4(65-)';
				break;
			}
		return $age;
	}

	public function getRemainSeatsCount()
	{
		return array(
			'perabo' => $this->booth_model->remain_seat_count_by_box_id(2),
			'perabo_pair' => $this->booth_model->remain_seat_count_by_box_id(3),
			'executive' => $this->booth_model->remain_seat_count_by_box_id(1),
			'premium' => $this->booth_model->remain_seat_count_by_box_id(0)
		);
	}

	public function addTransaction()
	{
		$booth_id = $_POST['booth_id'];
		$status = $_POST['status'];
		$gender = $_POST['gender'];
		$age = $_POST['age'];

		$age = $this->getAgeFromTitle($age);
		$manager = $this->booth_model->get_current_user();

		$arr = array();
		$arr = $this->booth_model->get_booth_by_id($booth_id);
		$booth_name = $arr[0]['booth_name']; 

		$temp = array();
		$temp = $this->booth_model->get_booth_box_name_by_booth_id($booth_id)[0];
		$mode = $this->isPriceType(mdate("%Y-%m-%d %h:%i:%s"));
		
		$booth_type = $temp['box_name'];
		$price = $temp[$mode];

		// print_r($price);
		// exit(0);

		$this->booth_model->add_transaction($booth_id, $booth_name, $booth_type, $status, $gender, $age, $manager[0]['user_name'], $price);

		$this->printReceipt($booth_id);

		echo json_encode($this->getRemainSeatsCount());
	}

	public function	updateTimeTable() 
	{
		$day_start_time = $_POST['day_start_time'];
		$day_end_time = $_POST['day_end_time'];
		$night_start_time = $_POST['night_start_time'];
		$night_end_time = $_POST['night_end_time'];
		$box1_reg = $_POST['box1_reg'];
		$box1_nig = $_POST['box1_nig'];
		$box2_reg = $_POST['box2_reg'];
		$box2_nig = $_POST['box2_nig'];
		$box3_reg = $_POST['box3_reg'];
		$box3_nig = $_POST['box3_nig'];
		$box0_reg = $_POST['box0_reg'];
		$box0_nig = $_POST['box0_nig'];

		echo json_encode($this->booth_model->update_timetable($day_start_time, $day_end_time, $night_start_time, $night_end_time, $box1_reg, $box1_nig, $box2_reg, $box2_nig, $box3_reg, $box3_nig, $box0_reg, $box0_nig));
	
	}

	public function	loadTimeTable() 
	{
		echo json_encode($this->getTimeTable());
	}

	public function getTimeTable()
	{
		return array(
			'box0' => $this->booth_model->get_box_by_id(0),
			'box1' => $this->booth_model->get_box_by_id(1),
			'box2' => $this->booth_model->get_box_by_id(2),
			'box3' => $this->booth_model->get_box_by_id(3),
			'regular_time' => $this->booth_model->get_work_time_by_id(0),
			'night_time' => $this->booth_model->get_work_time_by_id(1)
		);
	}

	public function loadManager() 
	{
		echo json_encode(array('userlist' => $this->booth_model->all_user_list()));
	}

	public function updateManager()
	{
		$id = $this->input->post('id');
		$user_name = $this->input->post('user_name');
		$is_selected = $this->input->post('is_selected');

		$this->booth_model->update_user_by_id($id, $user_name, $is_selected);
		echo json_encode(array('userlist' => $this->booth_model->all_user_list()));
	}

	public function removeManager()
	{
		$id = $this->input->post('id');
		$this->booth_model->remove_user_by_id($id);
		echo json_encode(array('userlist' => $this->booth_model->all_user_list()));
	}

	public function cancelTransaction()
	{
		$booth_id = $this->input->post('booth_id');
		$status = $this->input->post('status');

		$this->booth_model->cancal_transaction($booth_id, $status);

		echo json_encode($this->getRemainSeatsCount());
	}

	public function setSalePauseSeat()
	{
		$booth_id = $this->input->post('booth_id');
		$status = $this->input->post('status');

		$this->booth_model->set_sale_pause_seat($booth_id, $status);

		echo json_encode($this->getRemainSeatsCount());
	}

	public function setSaleCancelSeat()
	{
		$booth_id = $this->input->post('booth_id');

		$this->booth_model->set_sale_cancel_seat($booth_id);

		echo json_encode($this->getRemainSeatsCount());
	}

	public function outputCsv()
	{

		$this->load->helper('csv');

		$fields = array(
			'id'   => 'No',
			'booth_no' => '座席番号',
			'booth_type' => '座席種別',
			'gender' => '性別',
			'age' => '年齢',
			'en_time' => '入室時間',
			'ex_time' => '退室時間',
			'fee' => '料金',
			'manage' => '担当者'
		);

		$query = array();

		$date1 = mdate("%Y-%m-%d 00:00:00");
		$date2 = mdate("%Y-%m-%d %h:%i:%s");

		$result = $this->booth_model->get_transcation_list_by_dates($date1, $date2);

		if (count($result) > 0) {
			$idx = 1;
			foreach ($result as $value) {
			
				$arr_tmp = array(
					'id'   => $idx,
					'booth_no' => $value['booth_name'],
					'booth_type' => $value['booth_type'],
					'gender' => $value['gender'],
					'age' => $value['age'],
					'en_time' => $value['entrance_time'],
					'ex_time' => $value['exit_time'],
					'fee' => $value['price'] . '円',
					'manage' => $value['user_name']
				);

				array_push($query, $arr_tmp);
				$idx++;
			}
			echo arrayToCSV($query, $fields, "booth");
		} else {
			echo "選択した日付に対応するデータはありません。";
		}
	}

	public function pageReceipt($booth_id) 
	{
		$data['title'] = 'レンタルブース管理システム';
		$data['today'] = date('Y/m/d');
		$data['day_week'] = $this->getDayofWeekFromToday();
		$data['cur_time'] = date('H:i');
		
		if( $booth_id > 0 ) { 
			$temp = array();
			$temp = $this->booth_model->get_booth_box_name_by_booth_id($booth_id)[0];
			$mode = $this->isPriceType(mdate("%Y-%m-%d %h:%i:%s"));
			
			$data['box_name'] = $temp['box_name'];
			$data['col_name'] = substr($temp['booth_name'], strpos($temp['booth_name'], '-') + 1, strlen($temp['booth_name']));
			$data['row_name'] = substr($temp['booth_name'], 0, strpos($temp['booth_name'], '-'));

			$data['fee'] = '料金 ' . $this->amountFormat($temp[$mode]);
			$data['help_text1'] = 'お帰りの際は,';
			$data['help_text2'] = '受付へご返却お願いします';

			$this->load->view('receipt', $data);
		}
	}
	
	public function printReceipt($booth_id)
	{
		$path = "wkhtmltoimage"; //path to your executable
		$url = base_url('receipt-page' . '/' . $booth_id);
		$output_path = "test.jpg";
		$options = "--width 480 --height 650";
		$cmd = $path . " " . $options . " ". $url . " " . $output_path; 
		$output = shell_exec($cmd);

		// $connector = new WindowsPrintConnector("smb://DESKTOP-BD0IMCA/EPSON_TM_T90_Receipt");
		// $profile = CapabilityProfile::load("TM-T88III");
		// $printer = new Printer($connector, $profile);

		// /* Bit image */
		// try {
		//     $logo = EscposImage::load(__DIR__ . '/../../test.jpg', false);
		//     $printer -> bitImage($logo);
    	// 	$printer -> feed();
		//     $printer -> cut();
		// } catch (Exception $e) {
		// 	    /*
		// 		 * loadPdf() throws exceptions if files or not found, or you don't have the
		// 		 * imagick extension to read PDF's
		// 		 */
		// 	    echo $e -> getMessage() . "\n";
		// } finally {
		//     $printer -> close();
		// }
	
	}

	public function getDayofWeekFromToday() 
	{
		$dayOfWeek = date("D", strtotime(date('Y-m-d')));
		$result = '';
		
		switch($dayOfWeek){
			case 'Mon':
				$result = '月';
				break;
			case 'Tue':
				$result = '火';
				break;
			case 'Wed':
				$result = '水';
				break;
			case 'Thu':
				$result = '木';
				break;
			case 'Fri':
				$result = '金';
				break;
			case 'Sat':
				$result = '土';
				break;
			case 'Sun':
				$result = '日';
		}
		return $result;
	}
}
