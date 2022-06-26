<?php 
namespace common\interfaces;
interface ApiSunatInterface  {
    public function apiRuc($ruc);
    public function apiDni($dni);
    public function apiTipoCambio($fecha);
}
?>