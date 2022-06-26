<?php
namespace common\components;

use common\authclient\OAuth2;
//use common\authclient\OAuthToken;

use yii\helpers\Json;
use yii;
use common\interfaces\ApiSunatInterface;
//use yii\base\InvalidConfigException;
class MyClientGeneral extends OAuth2 implements ApiSunatInterface
{
 public $token_directo='apis-token-2341.Afxurw2EtrI5Wws02SAdDZHwvikhinVe';
 public $apiBaseUrl="https://api.apis.net.pe/v1";  

public function init(){
    
    parent::init();
   
    
}


 protected function initUserAttributes()
    {
        return $this->api('userinfo', 'GET');
    } 
    
 
 
 
 /*private function mapAttributes(MediaApps $app){
     $this->expireDuration=$this->providerMedia->duration_token;
     
     
 }*/
public function apiRuc($ruc){
    /*array(3) { ["success"]=> bool(true)
        ["data"]=> array(12) { ["direccion"]=> string(38) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES" 
        ["direccion_completa"]=> string(57) "AV. SANTA ANA NRO. 562 URB. LOS SAUCES, LIMA - LIMA - ATE" 
        ["ruc"]=> string(11) "20600279832" 
        ["nombre_o_razon_social"]=> string(47) "NEOTEGNIA CONSULTORES S.A.C. - NEOTEGNIA S.A.C." 
        ["estado"]=> string(6) "ACTIVO" 
        ["condicion"]=> string(6) "HABIDO" 
        ["departamento"]=> string(4) "LIMA" 
        ["provincia"]=> string(4) "LIMA" 
        ["distrito"]=> string(3) "ATE" 
        ["ubigeo_sunat"]=> string(6) "150103" 
        ["ubigeo"]=> array(3) { [0]=> string(2) "15" [1]=> string(4) "1501" [2]=> string(6) "150103" } 
        ["es_agente_de_retencion"]=> string(2) "NO" }
        ["source"]=> string(11) "apiperu.dev" }*/
    $request=$this->httpClient->get(
             $this->apiBaseUrl.'/ruc?numero='. $ruc,
             [],
             [
                 "Content-Type" => "application/json",
                 "Authorization" => "Bearer ".$this->token_directo,
              ]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   //var_dump($response);die();
   
 if($response->isOk){
    return $response->getData();
 }else{
    return false;
 } 
}


 

public function apiDni($dni){
   
    $request=$this->httpClient->get(
             $this->apiBaseUrl.'/dni?numero='.$dni,
             [],
             [
                 "Content-Type" => "application/json",
                 "Authorization" => "Bearer ".$this->token_directo,
              ]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   //var_dump($response);die();
   
 if($response->isOk){
    return $response->getData();
 }else{
    return false;
 } 
}
public function apiTipoCambio($fecha){
    
    $request=$this->httpClient->get(
             $this->apiBaseUrl.'/tipo-cambio-sunat?fecha='.$fecha,
             [],
             [
                 "Content-Type" => "application/json",
                 "Authorization" => "Bearer ".$this->token_directo,
              ]
            );
  //$this->applyAccessTokenToRequest($request,$this->getState('token'));
   $response=$request->send();
   //var_dump($response);die();
   
 if($response->isOk){
    return $response->getData();
 }else{
    return false;
 } 
}

} 


