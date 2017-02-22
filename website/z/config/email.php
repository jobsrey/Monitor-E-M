<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['protocol'] = 'mail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'iso-8859-1';
$config['wordwrap'] = TRUE;

//$this->email->initialize($config); 

//$this->load->library('email');
$config['protocol'] = 'mail';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_port'] = 465;
$config['smtp_user'] = 'admin@wartakotalive.com';
$config['smtp_pass'] = 'warkot';
$config['priority'] = 1;
$config['mailtype'] = 'text';
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
//$this->email->initialize($config);
//	$this->email->from('admin@wartakotalive.com', 'Deka dari gmail');
//	$this->email->to('wartakotalive@yahoo.com');
	//$this->email->cc('deka@somemail.com');
		//$this->email->bcc('them@their-example.com');
	
	//	$this->email->subject('email Test subject');
	//	$this->email->message('Testing the email class CodeIgniter');
	
	//	$this->email->send();
	//	echo $this->email->print_debugger();



/* End of file email.php */
/* Location: ./system/application/config/email.php */
?>