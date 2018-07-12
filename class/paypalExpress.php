<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class paypalExpress
{    
    public function paypalCheck($paymentID,$pid, $payerID, $paymentToken){
        $ch = curl_init();
        $clientId = PayPal_CLIENT_ID;
        $secret = PayPal_SECRET;
        curl_setopt($ch, CURLOPT_URL, PayPal_BASE_URL.'oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $clientId . ":" . $secret);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        $result = curl_exec($ch);
        $accessToken = null;
        if (empty($result)){
            return false;
        }else{
            $json = json_decode($result);
            $accessToken = $json->access_token;
            $curl = curl_init(PayPal_BASE_URL.'payments/payment/' . $paymentID);
            curl_setopt($curl, CURLOPT_POST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $accessToken,
            'Accept: application/json',
            'Content-Type: application/xml'
            ));
            $response = curl_exec($curl);
            $result = json_decode($response);
            
            
            $total = $result->transactions[0]->amount->total;
            $currency = $result->transactions[0]->amount->currency;            
            $recipient_name = $result->transactions[0]->item_list->shipping_address->recipient_name;
            curl_close($ch);
            curl_close($curl);
            
             //$product = $this->getProduct($pid);  // check for the prduct in the database
            if($state == 'approved'){
                return true;
            }else{
                return false;
            }   
        }
        
    }
    
}