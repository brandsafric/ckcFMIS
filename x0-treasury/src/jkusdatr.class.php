<?php

/*
 *
 */
include "src/csyber.class.php";

class JKUSDATREASURY extends CSYBER
{
 public function __construct()
 {
	
 }
 
 protected function __ckc_login()
 {
	$url = CKCLOGIN;
	$postvars = sprintf("username=%s&password=%s&login=login", CKCUSER, CKCPASS);
	$logged_in = $this->__curl1($url, $postvars);
	$logged_in = str_replace("refresh", "", $logged_in);
   // echo $logged_in;
	return;
 }
 
 protected function __ckc_statement_download($data)
 {
	$url = CKCSTATEMENT;
	$cookiefile = dirname(__FILE__).'/cookie.txt';
	$posted = $this->__curl1($url, $data);
	return $posted;
 }
 
  protected function __ckc_receipt_upload($data)
 {
	$url = CKCRECEIPT;
	//$cookiefile = sprintf("%s/jtmp/%s", dirname(__FILE__), CKCCOOKIE);
	$cookiefile = dirname(__FILE__).'/cookie.txt';
	$posted = $this->__curl($url, $data, $cookiefile);
	echo $posted;
	if(stripos($posted, CKCRECEIPTSUCCESS) === false)return false;
	return true;
 }

 protected function __curl1($url, $postvars=false)
 {
    $session = curl_init($url);
    curl_setopt ($session, CURLOPT_POST, true);
    curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
   
    curl_setopt($session, CURLOPT_COOKIEJAR, CKCCOOKIE);
	curl_setopt($session, CURLOPT_COOKIEFILE, CKCCOOKIE);

    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_FOLLOWLOCATION, false);

    // EXECUTE
    $json = curl_exec($session);
    curl_close($session);
	return $json;

 } 
 private function __curl($url, $postvars=false, $cookiefile)
 {
	$session = curl_init($url);
	curl_setopt ($session, CURLOPT_COOKIESESSION, true);
	curl_setopt ($session, CURLOPT_POST, ($postvars === false)?false:true);
	curl_setopt ($session, CURLOPT_POSTFIELDS, $postvars);
	curl_setopt($session, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
	$cookiefile = dirname(__FILE__).'/cookie.txt';
   // $tmpfname = dirname(__FILE__).'/cookie.txt';
    curl_setopt($session, CURLOPT_COOKIEJAR, $cookiefile);
	curl_setopt($session, CURLOPT_COOKIEFILE, $cookiefile);

    curl_setopt($session, CURLOPT_HEADER, true);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_FOLLOWLOCATION, false);
	//CURLOPT_MAXREDIRS

    // EXECUTE
    $json = curl_exec($session);
    curl_close($session);
	/*
	$url = "http://ckcfinancialsystem.org/receipt.php";
	$session = curl_init($url);
	curl_setopt($session, CURLOPT_COOKIEJAR, $cookiefile);
    curl_setopt($session, CURLOPT_COOKIEFILE, $cookiefile);

    curl_setopt($session, CURLOPT_HEADER, false);
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($session, CURLOPT_FOLLOWLOCATION, false);
	 $json = curl_exec($session);
        echo $json;
	/**/
	return $json;
 }
}
