<?php

class indigo {
    protected $baseUrl  = 'https://api.customer.jp';
    protected $APIList = [
        'SSHKeyList' => '/webarenaIndigo/v1/vm/sshkey',
        'InstanceTypeList' => '/webarenaIndigo/v1/vm/instancetypes',
        'GetInstanceSpecification' => '/webarenaIndigo/v1/vm/getinstancespec?instanceTypeId=1',
        'GetOSlist' => '/webarenaIndigo/v1/vm/oslist?instanceTypeId=1',
    ];


    public function AccessTokenGeneration() {
        $params=[
            'grantType' => 'client_credentials',
            'clientId' => '',
            'clientSecret' => '',
            'code' => ''
        ];
        $defaults = array(
            CURLOPT_URL => $this->baseUrl.'/oauth/v1/accesstokens',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true
        );
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        $response = curl_exec($ch);
//$err=curl_errno($ch);
//var_dump($err);
//var_dump($response);
        $kekka = json_decode($response , true );

        curl_close($ch);
        return $kekka["accessToken"];
    }
    protected function GetRequest($APIName, $accessToken) {
        $defaults = array(
            CURLOPT_URL => $this->baseUrl.$this->APIList[$APIName],
            CURLOPT_HTTPGET => true,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer '.$accessToken],
            CURLOPT_RETURNTRANSFER => true
        );
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);

        $response = curl_exec($ch);

        $kekka = json_decode($response , true );

        curl_close($ch);
        return $kekka;
    }
    function SSHKeyList($accessToken) {
        $kekka = $this->GetRequest("SSHKeyList", $accessToken);
        return $kekka;
    }
    function InstanceTypeList($accessToken) {
        $kekka = $this->GetRequest("InstanceTypeList", $accessToken);
        return $kekka;
    }
    function GetInstanceSpecification($accessToken) {
        $kekka = $this->GetRequest("GetInstanceSpecification", $accessToken);
        return $kekka;
    }
    public function GetOSlist($accessToken) {
        $kekka = $this->GetRequest("GetOSlist", $accessToken);
        return $kekka;
    }
}

$test = new indigo();

$accessToken = $test->AccessTokenGeneration();
$kekka = $test->GetOSlist($accessToken);
var_dump($kekka);

?>
