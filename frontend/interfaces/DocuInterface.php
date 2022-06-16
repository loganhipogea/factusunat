<?php
namespace frontend\interfaces;
interface DocuInterface {
  public function name();   
  public function fullName($asc=TRUE,$ucase=true);
  public function lastName();
  public function age();
  public function docsIdentity();  
  public function address();
  public function fenac();
  public function IsBirthDay();
}