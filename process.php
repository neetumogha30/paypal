<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'config.php';
require 'class/paypalExpress.php';
if(!empty($_GET['paymentID']) && !empty($_GET['payerID']) && !empty($_GET['token']) && !empty($_GET['pid']) ){
    $paypalExpress = new paypalExpress();
    $paymentID = $_GET['paymentID'];
    $payerID = $_GET['payerID'];
    $token = $_GET['token'];
    $pid = $_GET['pid'];
    
    $paypalCheck=$paypalExpress->paypalCheck($paymentID, $pid, $payerID, $token);
	print $paypalCheck;
   // if($paypalCheck){
     //   header('Location:orders.php');
        
    //}
    echo "Order successful";
}
else{
  //  header('Location:home.php');
}

