<?php
/*
 * Esta clase para ahorrar tiempo
 * Evitando escribir los combos
 */
namespace common\helpers;
use yii;
use yii\helpers\ArrayHelper;

class ComboHelper  {
    
    /*
     * Funciones que devuelven arrays para rellenar los combos
     * ma comunes de datos maestros 
     */
    
    
    
    public static function getCboMaterials(){
        return ArrayHelper::map(
                \common\models\masters\Maestrocompo::find()->all(),
                'codart','descripcion');
    }
    
    public static function getCboClipros(){
        return ArrayHelper::map(
                \common\models\masters\Clipro::find()->all(),
                'codpro','despro');
    }
    
    public static function getCboCentros($codpro=null){
        $query= \common\models\masters\Centros::find();        
        if(!is_null($codpro)){
            return ArrayHelper::map(
                $query->
                 andWhere(['codpro'=>$codpro])->
                all(),
                'codcen','nomcen');
        }else{
            return ArrayHelper::map(
                $query->all(),
                'codcen','nomcen'); 
        }
         
    }
    
    public static function getCboTables(){
        return ArrayHelper::map(
                        \common\models\masters\ModelCombo::find()->all(),
                'parametro','parametro');
    }
    
     public static function getCboValores($tableName){
        return ArrayHelper::map(
     \common\models\masters\Combovalores::find()->where(['[[nombretabla]]'=>$tableName])->all(),
                'codigo','valor');
    }
    
     public static function getCboFavorites($iduser=null){
         $iduser=is_null($iduser)?static::userId():$iduser;        
        return ArrayHelper::map(
                        \common\models\Userfavoritos::find()->where(['[[user_id]]'=>$iduser])->all(),
                'url','alias');
    }
    
     public static function getCboDocuments($iduser=null){
         //$iduser=is_null($iduser)?static::userId():$iduser;        
        return ArrayHelper::map(
                        \common\models\masters\Documentos::find()->all(),
                'codocu','desdocu');
    }
    
    
      public static function getCboDepartamentos(){
         //$iduser=is_null($iduser)?static::userId():$iduser;        
        return ArrayHelper::map(
                        \common\models\masters\Ubigeos::find()->
                all(),
            'coddepa','departamento');
      }
        
       public static function getCboProvincias($depa){
         //$iduser=is_null($iduser)?static::userId():$iduser;        
        return ArrayHelper::map(
                        \common\models\masters\Ubigeos::find()
                ->where(['coddepa'=>$depa])->all(),
                'codprov','provincia');
    }
    
     public static function getCboDistritos($prov){
         //$iduser=is_null($iduser)?static::userId():$iduser;        
        return ArrayHelper::map(
                        \common\models\masters\Ubigeos::find()
                ->where(['codprov'=>$prov])->all(),
                'coddist','distrito');
    }
    
    /*ESTA FUNCION ES DE PRPISTO GENERAL 
     * RECIBE EL NOBRE DE UNA CLASE 
     * CON EL CAMO CLAVE Y CAMPO REFERENCIA
     * Y UN VALOR DE FILTRO  Y CON ESTO DEVUEL UN ARRAY D
     * DE VALORES 
     */
    public static function getCboGeneral($valorfiltro,$clase,$campofiltro,$campokey,$camporef){
         //$iduser=is_null($iduser)?static::userId():$iduser;   
        if(empty($campofiltro))
            return ArrayHelper::map(
                        $clase::find()->all(),
                $campokey,$camporef);
        return ArrayHelper::map(
                        $clase::find()->where([$campofiltro=>$valorfiltro])->all(),
                $campokey,$camporef);
    }
    
    
    
    
   /*
    * Obtiene todos los nombres de los modelos de la aplicacion
    */
    public static function getCboModels(){
             
       /* return array_combine(
                        \common\helpers\FileHelper::getModels(),
                \common\helpers\FileHelper::getModels());*/
        $paths= \common\helpers\FileHelper::getModels();
             return self::map_models($paths);
    }
    
    
     /*
    * Obtiene todos los nombres de los modelos de un modulo
    */
    public static function getCboModelsByModule($moduleName){
             $paths=\common\helpers\FileHelper::getModelsByModule($moduleName);
             return self::map_models($paths);
        /*return array_combine(
                        \common\helpers\FileHelper::getModelsByModule($moduleName),
                \common\helpers\FileHelper::getModelsByModule($moduleName));*/
    }
    
    /*Funcion que arregla las rutas con los nombres de las tablas
     * 
     */
    
    private static function map_models($paths){
       /*$paths=(!is_null($moduleName))?\common\helpers\FileHelper::getModelsByModule($moduleName):
         \common\helpers\FileHelper::getModels();
        */
        $models=[];
        foreach($paths as $clave=>$valor){
            $models[$valor]=\common\helpers\FileHelper::getShortName($valor);
        }
       return $models;
      
    }
    
     /*
    * Obtiene todos los nombres de los modelos de la aplicacion
    */
    public static function getCboRoles(){
           $roles= array_keys(yii::$app->authManager->getRoles());
        return array_combine($roles,$roles);
    }
   
    /*
     * Obtiene los valores masters de la tabla combovalores
     * @key: clave para filtrar los datos 
     * @codcentro: Opcional para filtrar un parametro que depende del centro 
     */
    public static function getTablesValues($key,$codcentro=null){
        if(is_null($codcentro))
        return ArrayHelper::map(
       \common\models\masters\Combovalores::find()->where(['[[nombretabla]]'=> strtolower($key)])->all(),
               'codigo','valor');
       return ArrayHelper::map(
       \common\models\masters\Combovalores::find()->where(
               [
                   '[[nombretabla]]'=> strtolower(trim($key)),
                   '[[codcen]]'=>trim($codcentro)
                   ])->all(),
               'codigo','valor');  
        
   }
   
   
   
    /*
    * Obtiene todos los nombres de los modelos de la aplicacion
    */
    public static function getCboUms(){
         return ArrayHelper::map(
                        \common\models\masters\Ums::find()->all(),
                'codum','desum');
    }
   
   public static function getCboSex(){
         return [
                'M'=>yii::t('base.names','MASCULINO'),
                'F'=>yii::t('base.names','FEMENINO'),
             'G'=>yii::t('base.names','GENERAL'),
                        ];
    }
    
     public static function getCboBancos(){
         return ArrayHelper::map(
                        \common\models\masters\Bancos::find()->all(),
                'id','nombre');
    }
    
    public static function getCboMonedas(){
        
         return ArrayHelper::map(
                        \common\models\masters\Monedas::find()->all(),
                'codmon','codmon');
    }
    
     public static function getCboAlmacenes($centro=null){
         
         if(is_null($centro))
         return ArrayHelper::map(
                        \common\models\masters\Almacenes::find()->
                // andWhere(['codcen'=>$centro])->
                all(),
                'codal','nomal');
        return ArrayHelper::map(
                        \common\models\masters\Almacenes::find()->
                 andWhere(['codcen'=>$centro])->
                all(),
                'codal','nomal');
    }
    
    
    
    /*
     * EXCEPT  true si deseas que  omita la sociedad actual selccionada y almacenada en sesion 
     */
    public static function getCboSociedades($except=false){
        return \common\models\masters\VwSociedades::societyList($except);
    }
    public static function getCboSociedadesWithCodpro($except=false){
        return \common\models\masters\VwSociedades::companiesList($except);
    }
    
    public static function awesomeList(){
        return [
'fa-500px'=>"<span class='fa fa-500px'>",
'fa-address-book'=>"<span class='fa fa-address-book'>",
'fa-address-book-o'=>"<span class='fa fa-address-book-o'>",
'fa-address-card'=>"<span class='fa fa-address-card'>",
'fa-address-card-o'=>"<span class='fa fa-address-card-o'>",
'fa-adjust'=>"<span class='fa fa-adjust'>",
'fa-adn'=>"<span class='fa fa-adn'>",
'fa-align-center'=>"<span class='fa fa-align-center'>",
'fa-align-justify'=>"<span class='fa fa-align-justify'>",
'fa-align-left'=>"<span class='fa fa-align-left'>",
'fa-align-right'=>"<span class='fa fa-align-right'>",
'fa-amazon'=>"<span class='fa fa-amazon'>",
'fa-ambulance'=>"<span class='fa fa-ambulance'>",
'fa-american-sign-language-interpreting'=>"<span class='fa fa-american-sign-language-interpreting'>",
'fa-anchor'=>"<span class='fa fa-anchor'>",
'fa-android'=>"<span class='fa fa-android'>",
'fa-angellist'=>"<span class='fa fa-angellist'>",
'fa-angle-double-down'=>"<span class='fa fa-angle-double-down'>",
'fa-angle-double-left'=>"<span class='fa fa-angle-double-left'>",
'fa-angle-double-right'=>"<span class='fa fa-angle-double-right'>",
'fa-angle-double-up'=>"<span class='fa fa-angle-double-up'>",
'fa-angle-down'=>"<span class='fa fa-angle-down'>",
'fa-angle-left'=>"<span class='fa fa-angle-left'>",
'fa-angle-right'=>"<span class='fa fa-angle-right'>",
'fa-angle-up'=>"<span class='fa fa-angle-up'>",
'fa-apple'=>"<span class='fa fa-apple'>",
'fa-archive'=>"<span class='fa fa-archive'>",
'fa-area-chart'=>"<span class='fa fa-area-chart'>",
'fa-arrow-circle-down'=>"<span class='fa fa-arrow-circle-down'>",
'fa-arrow-circle-left'=>"<span class='fa fa-arrow-circle-left'>",
'fa-arrow-circle-o-down'=>"<span class='fa fa-arrow-circle-o-down'>",
'fa-arrow-circle-o-left'=>"<span class='fa fa-arrow-circle-o-left'>",
'fa-arrow-circle-o-right'=>"<span class='fa fa-arrow-circle-o-right'>",
'fa-arrow-circle-o-up'=>"<span class='fa fa-arrow-circle-o-up'>",
'fa-arrow-circle-right'=>"<span class='fa fa-arrow-circle-right'>",
'fa-arrow-circle-up'=>"<span class='fa fa-arrow-circle-up'>",
'fa-arrow-down'=>"<span class='fa fa-arrow-down'>",
'fa-arrow-left'=>"<span class='fa fa-arrow-left'>",
'fa-arrow-right'=>"<span class='fa fa-arrow-right'>",
'fa-arrow-up'=>"<span class='fa fa-arrow-up'>",
'fa-arrows'=>"<span class='fa fa-arrows'>",
'fa-arrows-alt'=>"<span class='fa fa-arrows-alt'>",
'fa-arrows-h'=>"<span class='fa fa-arrows-h'>",
'fa-arrows-v'=>"<span class='fa fa-arrows-v'>",
'fa-asl-interpreting'=>"<span class='fa fa-asl-interpreting'>",
'fa-assistive-listening-systems'=>"<span class='fa fa-assistive-listening-systems'>",
'fa-asterisk'=>"<span class='fa fa-asterisk'>",
'fa-at'=>"<span class='fa fa-at'>",
'fa-audio-description'=>"<span class='fa fa-audio-description'>",
'fa-automobile'=>"<span class='fa fa-automobile'>",
'fa-backward'=>"<span class='fa fa-backward'>",
'fa-balance-scale'=>"<span class='fa fa-balance-scale'>",
'fa-ban'=>"<span class='fa fa-ban'>",
'fa-bandcamp'=>"<span class='fa fa-bandcamp'>",
'fa-bank'=>"<span class='fa fa-bank'>",
'fa-bar-chart'=>"<span class='fa fa-bar-chart'>",
'fa-bar-chart-o'=>"<span class='fa fa-bar-chart-o'>",
'fa-barcode'=>"<span class='fa fa-barcode'>",
'fa-bars'=>"<span class='fa fa-bars'>",
'fa-bath'=>"<span class='fa fa-bath'>",
'fa-bathtub'=>"<span class='fa fa-bathtub'>",
'fa-battery'=>"<span class='fa fa-battery'>",
'fa-battery-0'=>"<span class='fa fa-battery-0'>",
'fa-battery-1'=>"<span class='fa fa-battery-1'>",
'fa-battery-2'=>"<span class='fa fa-battery-2'>",
'fa-battery-3'=>"<span class='fa fa-battery-3'>",
'fa-battery-4'=>"<span class='fa fa-battery-4'>",
'fa-battery-empty'=>"<span class='fa fa-battery-empty'>",
'fa-battery-full'=>"<span class='fa fa-battery-full'>",
'fa-battery-half'=>"<span class='fa fa-battery-half'>",
'fa-battery-quarter'=>"<span class='fa fa-battery-quarter'>",
'fa-battery-three-quarters'=>"<span class='fa fa-battery-three-quarters'>",
'fa-bed'=>"<span class='fa fa-bed'>",
'fa-beer'=>"<span class='fa fa-beer'>",
'fa-behance'=>"<span class='fa fa-behance'>",
'fa-behance-square'=>"<span class='fa fa-behance-square'>",
'fa-bell'=>"<span class='fa fa-bell'>",
'fa-bell-o'=>"<span class='fa fa-bell-o'>",
'fa-bell-slash'=>"<span class='fa fa-bell-slash'>",
'fa-bell-slash-o'=>"<span class='fa fa-bell-slash-o'>",
'fa-bicycle'=>"<span class='fa fa-bicycle'>",
'fa-binoculars'=>"<span class='fa fa-binoculars'>",
'fa-birthday-cake'=>"<span class='fa fa-birthday-cake'>",
'fa-bitbucket'=>"<span class='fa fa-bitbucket'>",
'fa-bitbucket-square'=>"<span class='fa fa-bitbucket-square'>",
'fa-bitcoin'=>"<span class='fa fa-bitcoin'>",
'fa-black-tie'=>"<span class='fa fa-black-tie'>",
'fa-blind'=>"<span class='fa fa-blind'>",
'fa-bluetooth'=>"<span class='fa fa-bluetooth'>",
'fa-bluetooth-b'=>"<span class='fa fa-bluetooth-b'>",
'fa-bold'=>"<span class='fa fa-bold'>",
'fa-bolt'=>"<span class='fa fa-bolt'>",
'fa-bomb'=>"<span class='fa fa-bomb'>",
'fa-book'=>"<span class='fa fa-book'>",
'fa-bookmark'=>"<span class='fa fa-bookmark'>",
'fa-bookmark-o'=>"<span class='fa fa-bookmark-o'>",
'fa-braille'=>"<span class='fa fa-braille'>",
'fa-briefcase'=>"<span class='fa fa-briefcase'>",
'fa-btc'=>"<span class='fa fa-btc'>",
'fa-bug'=>"<span class='fa fa-bug'>",
'fa-building'=>"<span class='fa fa-building'>",
'fa-building-o'=>"<span class='fa fa-building-o'>",
'fa-bullhorn'=>"<span class='fa fa-bullhorn'>",
'fa-bullseye'=>"<span class='fa fa-bullseye'>",
'fa-bus'=>"<span class='fa fa-bus'>",
'fa-buysellads'=>"<span class='fa fa-buysellads'>",
'fa-cab'=>"<span class='fa fa-cab'>",
'fa-calculator'=>"<span class='fa fa-calculator'>",
'fa-calendar'=>"<span class='fa fa-calendar'>",
'fa-calendar-check-o'=>"<span class='fa fa-calendar-check-o'>",
'fa-calendar-minus-o'=>"<span class='fa fa-calendar-minus-o'>",
'fa-calendar-o'=>"<span class='fa fa-calendar-o'>",
'fa-calendar-plus-o'=>"<span class='fa fa-calendar-plus-o'>",
'fa-calendar-times-o'=>"<span class='fa fa-calendar-times-o'>",
'fa-camera'=>"<span class='fa fa-camera'>",
'fa-camera-retro'=>"<span class='fa fa-camera-retro'>",
'fa-car'=>"<span class='fa fa-car'>",
'fa-caret-down'=>"<span class='fa fa-caret-down'>",
'fa-caret-left'=>"<span class='fa fa-caret-left'>",
'fa-caret-right'=>"<span class='fa fa-caret-right'>",
'fa-caret-square-o-down'=>"<span class='fa fa-caret-square-o-down'>",
'fa-caret-square-o-left'=>"<span class='fa fa-caret-square-o-left'>",
'fa-caret-square-o-right'=>"<span class='fa fa-caret-square-o-right'>",
'fa-caret-square-o-up'=>"<span class='fa fa-caret-square-o-up'>",
'fa-caret-up'=>"<span class='fa fa-caret-up'>",
'fa-cart-arrow-down'=>"<span class='fa fa-cart-arrow-down'>",
'fa-cart-plus'=>"<span class='fa fa-cart-plus'>",
'fa-cc'=>"<span class='fa fa-cc'>",
'fa-cc-amex'=>"<span class='fa fa-cc-amex'>",
'fa-cc-diners-club'=>"<span class='fa fa-cc-diners-club'>",
'fa-cc-discover'=>"<span class='fa fa-cc-discover'>",
'fa-cc-jcb'=>"<span class='fa fa-cc-jcb'>",
'fa-cc-mastercard'=>"<span class='fa fa-cc-mastercard'>",
'fa-cc-paypal'=>"<span class='fa fa-cc-paypal'>",
'fa-cc-stripe'=>"<span class='fa fa-cc-stripe'>",
'fa-cc-visa'=>"<span class='fa fa-cc-visa'>",
'fa-certificate'=>"<span class='fa fa-certificate'>",
'fa-chain'=>"<span class='fa fa-chain'>",
'fa-chain-broken'=>"<span class='fa fa-chain-broken'>",
'fa-check'=>"<span class='fa fa-check'>",
'fa-check-circle'=>"<span class='fa fa-check-circle'>",
'fa-check-circle-o'=>"<span class='fa fa-check-circle-o'>",
'fa-check-square'=>"<span class='fa fa-check-square'>",
'fa-check-square-o'=>"<span class='fa fa-check-square-o'>",
'fa-chevron-circle-down'=>"<span class='fa fa-chevron-circle-down'>",
'fa-chevron-circle-left'=>"<span class='fa fa-chevron-circle-left'>",
'fa-chevron-circle-right'=>"<span class='fa fa-chevron-circle-right'>",
'fa-chevron-circle-up'=>"<span class='fa fa-chevron-circle-up'>",
'fa-chevron-down'=>"<span class='fa fa-chevron-down'>",
'fa-chevron-left'=>"<span class='fa fa-chevron-left'>",
'fa-chevron-right'=>"<span class='fa fa-chevron-right'>",
'fa-chevron-up'=>"<span class='fa fa-chevron-up'>",
'fa-child'=>"<span class='fa fa-child'>",
'fa-chrome'=>"<span class='fa fa-chrome'>",
'fa-circle'=>"<span class='fa fa-circle'>",
'fa-circle-o'=>"<span class='fa fa-circle-o'>",
'fa-circle-o-notch'=>"<span class='fa fa-circle-o-notch'>",
'fa-circle-thin'=>"<span class='fa fa-circle-thin'>",
'fa-clipboard'=>"<span class='fa fa-clipboard'>",
'fa-clock-o'=>"<span class='fa fa-clock-o'>",
'fa-clone'=>"<span class='fa fa-clone'>",
'fa-close'=>"<span class='fa fa-close'>",
'fa-cloud'=>"<span class='fa fa-cloud'>",
'fa-cloud-download'=>"<span class='fa fa-cloud-download'>",
'fa-cloud-upload'=>"<span class='fa fa-cloud-upload'>",
'fa-cny'=>"<span class='fa fa-cny'>",
'fa-code'=>"<span class='fa fa-code'>",
'fa-code-fork'=>"<span class='fa fa-code-fork'>",
'fa-codepen'=>"<span class='fa fa-codepen'>",
'fa-codiepie'=>"<span class='fa fa-codiepie'>",
'fa-coffee'=>"<span class='fa fa-coffee'>",
'fa-cog'=>"<span class='fa fa-cog'>",
'fa-cogs'=>"<span class='fa fa-cogs'>",
'fa-columns'=>"<span class='fa fa-columns'>",
'fa-comment'=>"<span class='fa fa-comment'>",
'fa-comment-o'=>"<span class='fa fa-comment-o'>",
'fa-commenting'=>"<span class='fa fa-commenting'>",
'fa-commenting-o'=>"<span class='fa fa-commenting-o'>",
'fa-comments'=>"<span class='fa fa-comments'>",
'fa-comments-o'=>"<span class='fa fa-comments-o'>",
'fa-compass'=>"<span class='fa fa-compass'>",
'fa-compress'=>"<span class='fa fa-compress'>",
'fa-connectdevelop'=>"<span class='fa fa-connectdevelop'>",
'fa-contao'=>"<span class='fa fa-contao'>",
'fa-copy'=>"<span class='fa fa-copy'>",
'fa-copyright'=>"<span class='fa fa-copyright'>",
'fa-creative-commons'=>"<span class='fa fa-creative-commons'>",
'fa-credit-card'=>"<span class='fa fa-credit-card'>",
'fa-credit-card-alt'=>"<span class='fa fa-credit-card-alt'>",
'fa-crop'=>"<span class='fa fa-crop'>",
'fa-crosshairs'=>"<span class='fa fa-crosshairs'>",
'fa-css3'=>"<span class='fa fa-css3'>",
'fa-cube'=>"<span class='fa fa-cube'>",
'fa-cubes'=>"<span class='fa fa-cubes'>",
'fa-cut'=>"<span class='fa fa-cut'>",
'fa-cutlery'=>"<span class='fa fa-cutlery'>",
'fa-dashboard'=>"<span class='fa fa-dashboard'>",
'fa-dashcube'=>"<span class='fa fa-dashcube'>",
'fa-database'=>"<span class='fa fa-database'>",
'fa-deaf'=>"<span class='fa fa-deaf'>",
'fa-deafness'=>"<span class='fa fa-deafness'>",
'fa-dedent'=>"<span class='fa fa-dedent'>",
'fa-delicious'=>"<span class='fa fa-delicious'>",
'fa-desktop'=>"<span class='fa fa-desktop'>",
'fa-deviantart'=>"<span class='fa fa-deviantart'>",
'fa-diamond'=>"<span class='fa fa-diamond'>",
'fa-digg'=>"<span class='fa fa-digg'>",
'fa-dollar'=>"<span class='fa fa-dollar'>",
'fa-dot-circle-o'=>"<span class='fa fa-dot-circle-o'>",
'fa-download'=>"<span class='fa fa-download'>",
'fa-dribbble'=>"<span class='fa fa-dribbble'>",
'fa-drivers-license'=>"<span class='fa fa-drivers-license'>",
'fa-drivers-license-o'=>"<span class='fa fa-drivers-license-o'>",
'fa-dropbox'=>"<span class='fa fa-dropbox'>",
'fa-drupal'=>"<span class='fa fa-drupal'>",
'fa-edge'=>"<span class='fa fa-edge'>",
'fa-edit'=>"<span class='fa fa-edit'>",
'fa-eercast'=>"<span class='fa fa-eercast'>",
'fa-eject'=>"<span class='fa fa-eject'>",
'fa-ellipsis-h'=>"<span class='fa fa-ellipsis-h'>",
'fa-ellipsis-v'=>"<span class='fa fa-ellipsis-v'>",
'fa-empire'=>"<span class='fa fa-empire'>",
'fa-envelope'=>"<span class='fa fa-envelope'>",
'fa-envelope-o'=>"<span class='fa fa-envelope-o'>",
'fa-envelope-open'=>"<span class='fa fa-envelope-open'>",
'fa-envelope-open-o'=>"<span class='fa fa-envelope-open-o'>",
'fa-envelope-square'=>"<span class='fa fa-envelope-square'>",
'fa-envira'=>"<span class='fa fa-envira'>",
'fa-eraser'=>"<span class='fa fa-eraser'>",
'fa-etsy'=>"<span class='fa fa-etsy'>",
'fa-eur'=>"<span class='fa fa-eur'>",
'fa-euro'=>"<span class='fa fa-euro'>",
'fa-exchange'=>"<span class='fa fa-exchange'>",
'fa-exclamation'=>"<span class='fa fa-exclamation'>",
'fa-exclamation-circle'=>"<span class='fa fa-exclamation-circle'>",
'fa-exclamation-triangle'=>"<span class='fa fa-exclamation-triangle'>",
'fa-expand'=>"<span class='fa fa-expand'>",
'fa-expeditedssl'=>"<span class='fa fa-expeditedssl'>",
'fa-external-link'=>"<span class='fa fa-external-link'>",
'fa-external-link-square'=>"<span class='fa fa-external-link-square'>",
'fa-eye'=>"<span class='fa fa-eye'>",
'fa-eye-slash'=>"<span class='fa fa-eye-slash'>",
'fa-eyedropper'=>"<span class='fa fa-eyedropper'>",
'fa-fa'=>"<span class='fa fa-fa'>",
'fa-facebook'=>"<span class='fa fa-facebook'>",
'fa-facebook-f'=>"<span class='fa fa-facebook-f'>",
'fa-facebook-official'=>"<span class='fa fa-facebook-official'>",
'fa-facebook-square'=>"<span class='fa fa-facebook-square'>",
'fa-fast-backward'=>"<span class='fa fa-fast-backward'>",
'fa-fast-forward'=>"<span class='fa fa-fast-forward'>",
'fa-fax'=>"<span class='fa fa-fax'>",
'fa-feed'=>"<span class='fa fa-feed'>",
'fa-female'=>"<span class='fa fa-female'>",
'fa-fighter-jet'=>"<span class='fa fa-fighter-jet'>",
'fa-file'=>"<span class='fa fa-file'>",
'fa-file-archive-o'=>"<span class='fa fa-file-archive-o'>",
'fa-file-audio-o'=>"<span class='fa fa-file-audio-o'>",
'fa-file-code-o'=>"<span class='fa fa-file-code-o'>",
'fa-file-excel-o'=>"<span class='fa fa-file-excel-o'>",
'fa-file-image-o'=>"<span class='fa fa-file-image-o'>",
'fa-file-movie-o'=>"<span class='fa fa-file-movie-o'>",
'fa-file-o'=>"<span class='fa fa-file-o'>",
'fa-file-pdf-o'=>"<span class='fa fa-file-pdf-o'>",
'fa-file-photo-o'=>"<span class='fa fa-file-photo-o'>",
'fa-file-picture-o'=>"<span class='fa fa-file-picture-o'>",
'fa-file-powerpoint-o'=>"<span class='fa fa-file-powerpoint-o'>",
'fa-file-sound-o'=>"<span class='fa fa-file-sound-o'>",
'fa-file-text'=>"<span class='fa fa-file-text'>",
'fa-file-text-o'=>"<span class='fa fa-file-text-o'>",
'fa-file-video-o'=>"<span class='fa fa-file-video-o'>",
'fa-file-word-o'=>"<span class='fa fa-file-word-o'>",
'fa-file-zip-o'=>"<span class='fa fa-file-zip-o'>",
'fa-files-o'=>"<span class='fa fa-files-o'>",
'fa-film'=>"<span class='fa fa-film'>",
'fa-filter'=>"<span class='fa fa-filter'>",
'fa-fire'=>"<span class='fa fa-fire'>",
'fa-fire-extinguisher'=>"<span class='fa fa-fire-extinguisher'>",
'fa-firefox'=>"<span class='fa fa-firefox'>",
'fa-first-order'=>"<span class='fa fa-first-order'>",
'fa-flag'=>"<span class='fa fa-flag'>",
'fa-flag-checkered'=>"<span class='fa fa-flag-checkered'>",
'fa-flag-o'=>"<span class='fa fa-flag-o'>",
'fa-flash'=>"<span class='fa fa-flash'>",
'fa-flask'=>"<span class='fa fa-flask'>",
'fa-flickr'=>"<span class='fa fa-flickr'>",
'fa-floppy-o'=>"<span class='fa fa-floppy-o'>",
'fa-folder'=>"<span class='fa fa-folder'>",
'fa-folder-o'=>"<span class='fa fa-folder-o'>",
'fa-folder-open'=>"<span class='fa fa-folder-open'>",
'fa-folder-open-o'=>"<span class='fa fa-folder-open-o'>",
'fa-font'=>"<span class='fa fa-font'>",
'fa-font-awesome'=>"<span class='fa fa-font-awesome'>",
'fa-fonticons'=>"<span class='fa fa-fonticons'>",
'fa-fort-awesome'=>"<span class='fa fa-fort-awesome'>",
'fa-forumbee'=>"<span class='fa fa-forumbee'>",
'fa-forward'=>"<span class='fa fa-forward'>",
'fa-foursquare'=>"<span class='fa fa-foursquare'>",
'fa-free-code-camp'=>"<span class='fa fa-free-code-camp'>",
'fa-frown-o'=>"<span class='fa fa-frown-o'>",
'fa-futbol-o'=>"<span class='fa fa-futbol-o'>",
'fa-gamepad'=>"<span class='fa fa-gamepad'>",
'fa-gavel'=>"<span class='fa fa-gavel'>",
'fa-gbp'=>"<span class='fa fa-gbp'>",
'fa-ge'=>"<span class='fa fa-ge'>",
'fa-gear'=>"<span class='fa fa-gear'>",
'fa-gears'=>"<span class='fa fa-gears'>",
'fa-genderless'=>"<span class='fa fa-genderless'>",
'fa-get-pocket'=>"<span class='fa fa-get-pocket'>",
'fa-gg'=>"<span class='fa fa-gg'>",
'fa-gg-circle'=>"<span class='fa fa-gg-circle'>",
'fa-gift'=>"<span class='fa fa-gift'>",
'fa-git'=>"<span class='fa fa-git'>",
'fa-git-square'=>"<span class='fa fa-git-square'>",
'fa-github'=>"<span class='fa fa-github'>",
'fa-github-alt'=>"<span class='fa fa-github-alt'>",
'fa-github-square'=>"<span class='fa fa-github-square'>",
'fa-gitlab'=>"<span class='fa fa-gitlab'>",
'fa-gittip'=>"<span class='fa fa-gittip'>",
'fa-glass'=>"<span class='fa fa-glass'>",
'fa-glide'=>"<span class='fa fa-glide'>",
'fa-glide-g'=>"<span class='fa fa-glide-g'>",
'fa-globe'=>"<span class='fa fa-globe'>",
'fa-google'=>"<span class='fa fa-google'>",
'fa-google-plus'=>"<span class='fa fa-google-plus'>",
'fa-google-plus-circle'=>"<span class='fa fa-google-plus-circle'>",
'fa-google-plus-official'=>"<span class='fa fa-google-plus-official'>",
'fa-google-plus-square'=>"<span class='fa fa-google-plus-square'>",
'fa-google-wallet'=>"<span class='fa fa-google-wallet'>",
'fa-graduation-cap'=>"<span class='fa fa-graduation-cap'>",
'fa-gratipay'=>"<span class='fa fa-gratipay'>",
'fa-grav'=>"<span class='fa fa-grav'>",
'fa-group'=>"<span class='fa fa-group'>",
'fa-h-square'=>"<span class='fa fa-h-square'>",
'fa-hacker-news'=>"<span class='fa fa-hacker-news'>",
'fa-hand-grab-o'=>"<span class='fa fa-hand-grab-o'>",
'fa-hand-lizard-o'=>"<span class='fa fa-hand-lizard-o'>",
'fa-hand-o-down'=>"<span class='fa fa-hand-o-down'>",
'fa-hand-o-left'=>"<span class='fa fa-hand-o-left'>",
'fa-hand-o-right'=>"<span class='fa fa-hand-o-right'>",
'fa-hand-o-up'=>"<span class='fa fa-hand-o-up'>",
'fa-hand-paper-o'=>"<span class='fa fa-hand-paper-o'>",
'fa-hand-peace-o'=>"<span class='fa fa-hand-peace-o'>",
'fa-hand-pointer-o'=>"<span class='fa fa-hand-pointer-o'>",
'fa-hand-rock-o'=>"<span class='fa fa-hand-rock-o'>",
'fa-hand-scissors-o'=>"<span class='fa fa-hand-scissors-o'>",
'fa-hand-spock-o'=>"<span class='fa fa-hand-spock-o'>",
'fa-hand-stop-o'=>"<span class='fa fa-hand-stop-o'>",
'fa-handshake-o'=>"<span class='fa fa-handshake-o'>",
'fa-hard-of-hearing'=>"<span class='fa fa-hard-of-hearing'>",
'fa-hashtag'=>"<span class='fa fa-hashtag'>",
'fa-hdd-o'=>"<span class='fa fa-hdd-o'>",
'fa-header'=>"<span class='fa fa-header'>",
'fa-headphones'=>"<span class='fa fa-headphones'>",
'fa-heart'=>"<span class='fa fa-heart'>",
'fa-heart-o'=>"<span class='fa fa-heart-o'>",
'fa-heartbeat'=>"<span class='fa fa-heartbeat'>",
'fa-history'=>"<span class='fa fa-history'>",
'fa-home'=>"<span class='fa fa-home'>",
'fa-hospital-o'=>"<span class='fa fa-hospital-o'>",
'fa-hotel'=>"<span class='fa fa-hotel'>",
'fa-hourglass'=>"<span class='fa fa-hourglass'>",
'fa-hourglass-1'=>"<span class='fa fa-hourglass-1'>",
'fa-hourglass-2'=>"<span class='fa fa-hourglass-2'>",
'fa-hourglass-3'=>"<span class='fa fa-hourglass-3'>",
'fa-hourglass-end'=>"<span class='fa fa-hourglass-end'>",
'fa-hourglass-half'=>"<span class='fa fa-hourglass-half'>",
'fa-hourglass-o'=>"<span class='fa fa-hourglass-o'>",
'fa-hourglass-start'=>"<span class='fa fa-hourglass-start'>",
'fa-houzz'=>"<span class='fa fa-houzz'>",
'fa-html5'=>"<span class='fa fa-html5'>",
'fa-i-cursor'=>"<span class='fa fa-i-cursor'>",
'fa-id-badge'=>"<span class='fa fa-id-badge'>",
'fa-id-card'=>"<span class='fa fa-id-card'>",
'fa-id-card-o'=>"<span class='fa fa-id-card-o'>",
'fa-ils'=>"<span class='fa fa-ils'>",
'fa-image'=>"<span class='fa fa-image'>",
'fa-imdb'=>"<span class='fa fa-imdb'>",
'fa-inbox'=>"<span class='fa fa-inbox'>",
'fa-indent'=>"<span class='fa fa-indent'>",
'fa-industry'=>"<span class='fa fa-industry'>",
'fa-info'=>"<span class='fa fa-info'>",
'fa-info-circle'=>"<span class='fa fa-info-circle'>",
'fa-inr'=>"<span class='fa fa-inr'>",
'fa-instagram'=>"<span class='fa fa-instagram'>",
'fa-institution'=>"<span class='fa fa-institution'>",
'fa-internet-explorer'=>"<span class='fa fa-internet-explorer'>",
'fa-intersex'=>"<span class='fa fa-intersex'>",
'fa-ioxhost'=>"<span class='fa fa-ioxhost'>",
'fa-italic'=>"<span class='fa fa-italic'>",
'fa-joomla'=>"<span class='fa fa-joomla'>",
'fa-jpy'=>"<span class='fa fa-jpy'>",
'fa-jsfiddle'=>"<span class='fa fa-jsfiddle'>",
'fa-key'=>"<span class='fa fa-key'>",
'fa-keyboard-o'=>"<span class='fa fa-keyboard-o'>",
'fa-krw'=>"<span class='fa fa-krw'>",
'fa-language'=>"<span class='fa fa-language'>",
'fa-laptop'=>"<span class='fa fa-laptop'>",
'fa-lastfm'=>"<span class='fa fa-lastfm'>",
'fa-lastfm-square'=>"<span class='fa fa-lastfm-square'>",
'fa-leaf'=>"<span class='fa fa-leaf'>",
'fa-leanpub'=>"<span class='fa fa-leanpub'>",
'fa-legal'=>"<span class='fa fa-legal'>",
'fa-lemon-o'=>"<span class='fa fa-lemon-o'>",
'fa-level-down'=>"<span class='fa fa-level-down'>",
'fa-level-up'=>"<span class='fa fa-level-up'>",
'fa-life-bouy'=>"<span class='fa fa-life-bouy'>",
'fa-life-buoy'=>"<span class='fa fa-life-buoy'>",
'fa-life-ring'=>"<span class='fa fa-life-ring'>",
'fa-life-saver'=>"<span class='fa fa-life-saver'>",
'fa-lightbulb-o'=>"<span class='fa fa-lightbulb-o'>",
'fa-line-chart'=>"<span class='fa fa-line-chart'>",
'fa-link'=>"<span class='fa fa-link'>",
'fa-linkedin'=>"<span class='fa fa-linkedin'>",
'fa-linkedin-square'=>"<span class='fa fa-linkedin-square'>",
'fa-linode'=>"<span class='fa fa-linode'>",
'fa-linux'=>"<span class='fa fa-linux'>",
'fa-list'=>"<span class='fa fa-list'>",
'fa-list-alt'=>"<span class='fa fa-list-alt'>",
'fa-list-ol'=>"<span class='fa fa-list-ol'>",
'fa-list-ul'=>"<span class='fa fa-list-ul'>",
'fa-location-arrow'=>"<span class='fa fa-location-arrow'>",
'fa-lock'=>"<span class='fa fa-lock'>",
'fa-long-arrow-down'=>"<span class='fa fa-long-arrow-down'>",
'fa-long-arrow-left'=>"<span class='fa fa-long-arrow-left'>",
'fa-long-arrow-right'=>"<span class='fa fa-long-arrow-right'>",
'fa-long-arrow-up'=>"<span class='fa fa-long-arrow-up'>",
'fa-low-vision'=>"<span class='fa fa-low-vision'>",
'fa-magic'=>"<span class='fa fa-magic'>",
'fa-magnet'=>"<span class='fa fa-magnet'>",
'fa-mail-forward'=>"<span class='fa fa-mail-forward'>",
'fa-mail-reply'=>"<span class='fa fa-mail-reply'>",
'fa-mail-reply-all'=>"<span class='fa fa-mail-reply-all'>",
'fa-male'=>"<span class='fa fa-male'>",
'fa-map'=>"<span class='fa fa-map'>",
'fa-map-marker'=>"<span class='fa fa-map-marker'>",
'fa-map-o'=>"<span class='fa fa-map-o'>",
'fa-map-pin'=>"<span class='fa fa-map-pin'>",
'fa-map-signs'=>"<span class='fa fa-map-signs'>",
'fa-mars'=>"<span class='fa fa-mars'>",
'fa-mars-double'=>"<span class='fa fa-mars-double'>",
'fa-mars-stroke'=>"<span class='fa fa-mars-stroke'>",
'fa-mars-stroke-h'=>"<span class='fa fa-mars-stroke-h'>",
'fa-mars-stroke-v'=>"<span class='fa fa-mars-stroke-v'>",
'fa-maxcdn'=>"<span class='fa fa-maxcdn'>",
'fa-meanpath'=>"<span class='fa fa-meanpath'>",
'fa-medium'=>"<span class='fa fa-medium'>",
'fa-medkit'=>"<span class='fa fa-medkit'>",
'fa-meetup'=>"<span class='fa fa-meetup'>",
'fa-meh-o'=>"<span class='fa fa-meh-o'>",
'fa-mercury'=>"<span class='fa fa-mercury'>",
'fa-microchip'=>"<span class='fa fa-microchip'>",
'fa-microphone'=>"<span class='fa fa-microphone'>",
'fa-microphone-slash'=>"<span class='fa fa-microphone-slash'>",
'fa-minus'=>"<span class='fa fa-minus'>",
'fa-minus-circle'=>"<span class='fa fa-minus-circle'>",
'fa-minus-square'=>"<span class='fa fa-minus-square'>",
'fa-minus-square-o'=>"<span class='fa fa-minus-square-o'>",
'fa-mixcloud'=>"<span class='fa fa-mixcloud'>",
'fa-mobile'=>"<span class='fa fa-mobile'>",
'fa-mobile-phone'=>"<span class='fa fa-mobile-phone'>",
'fa-modx'=>"<span class='fa fa-modx'>",
'fa-money'=>"<span class='fa fa-money'>",
'fa-moon-o'=>"<span class='fa fa-moon-o'>",
'fa-mortar-board'=>"<span class='fa fa-mortar-board'>",
'fa-motorcycle'=>"<span class='fa fa-motorcycle'>",
'fa-mouse-pointer'=>"<span class='fa fa-mouse-pointer'>",
'fa-music'=>"<span class='fa fa-music'>",
'fa-navicon'=>"<span class='fa fa-navicon'>",
'fa-neuter'=>"<span class='fa fa-neuter'>",
'fa-newspaper-o'=>"<span class='fa fa-newspaper-o'>",
'fa-object-group'=>"<span class='fa fa-object-group'>",
'fa-object-ungroup'=>"<span class='fa fa-object-ungroup'>",
'fa-odnoklassniki'=>"<span class='fa fa-odnoklassniki'>",
'fa-odnoklassniki-square'=>"<span class='fa fa-odnoklassniki-square'>",
'fa-opencart'=>"<span class='fa fa-opencart'>",
'fa-openid'=>"<span class='fa fa-openid'>",
'fa-opera'=>"<span class='fa fa-opera'>",
'fa-optin-monster'=>"<span class='fa fa-optin-monster'>",
'fa-outdent'=>"<span class='fa fa-outdent'>",
'fa-pagelines'=>"<span class='fa fa-pagelines'>",
'fa-paint-brush'=>"<span class='fa fa-paint-brush'>",
'fa-paper-plane'=>"<span class='fa fa-paper-plane'>",
'fa-paper-plane-o'=>"<span class='fa fa-paper-plane-o'>",
'fa-paperclip'=>"<span class='fa fa-paperclip'>",
'fa-paragraph'=>"<span class='fa fa-paragraph'>",
'fa-paste'=>"<span class='fa fa-paste'>",
'fa-pause'=>"<span class='fa fa-pause'>",
'fa-pause-circle'=>"<span class='fa fa-pause-circle'>",
'fa-pause-circle-o'=>"<span class='fa fa-pause-circle-o'>",
'fa-paw'=>"<span class='fa fa-paw'>",
'fa-paypal'=>"<span class='fa fa-paypal'>",
'fa-pencil'=>"<span class='fa fa-pencil'>",
'fa-pencil-square'=>"<span class='fa fa-pencil-square'>",
'fa-pencil-square-o'=>"<span class='fa fa-pencil-square-o'>",
'fa-percent'=>"<span class='fa fa-percent'>",
'fa-phone'=>"<span class='fa fa-phone'>",
'fa-phone-square'=>"<span class='fa fa-phone-square'>",
'fa-photo'=>"<span class='fa fa-photo'>",
'fa-picture-o'=>"<span class='fa fa-picture-o'>",
'fa-pie-chart'=>"<span class='fa fa-pie-chart'>",
'fa-pied-piper'=>"<span class='fa fa-pied-piper'>",
'fa-pied-piper-alt'=>"<span class='fa fa-pied-piper-alt'>",
'fa-pied-piper-pp'=>"<span class='fa fa-pied-piper-pp'>",
'fa-pinterest'=>"<span class='fa fa-pinterest'>",
'fa-pinterest-p'=>"<span class='fa fa-pinterest-p'>",
'fa-pinterest-square'=>"<span class='fa fa-pinterest-square'>",
'fa-plane'=>"<span class='fa fa-plane'>",
'fa-play'=>"<span class='fa fa-play'>",
'fa-play-circle'=>"<span class='fa fa-play-circle'>",
'fa-play-circle-o'=>"<span class='fa fa-play-circle-o'>",
'fa-plug'=>"<span class='fa fa-plug'>",
'fa-plus'=>"<span class='fa fa-plus'>",
'fa-plus-circle'=>"<span class='fa fa-plus-circle'>",
'fa-plus-square'=>"<span class='fa fa-plus-square'>",
'fa-plus-square-o'=>"<span class='fa fa-plus-square-o'>",
'fa-podcast'=>"<span class='fa fa-podcast'>",
'fa-power-off'=>"<span class='fa fa-power-off'>",
'fa-print'=>"<span class='fa fa-print'>",
'fa-product-hunt'=>"<span class='fa fa-product-hunt'>",
'fa-puzzle-piece'=>"<span class='fa fa-puzzle-piece'>",
'fa-qq'=>"<span class='fa fa-qq'>",
'fa-qrcode'=>"<span class='fa fa-qrcode'>",
'fa-question'=>"<span class='fa fa-question'>",
'fa-question-circle'=>"<span class='fa fa-question-circle'>",
'fa-question-circle-o'=>"<span class='fa fa-question-circle-o'>",
'fa-quora'=>"<span class='fa fa-quora'>",
'fa-quote-left'=>"<span class='fa fa-quote-left'>",
'fa-quote-right'=>"<span class='fa fa-quote-right'>",
'fa-ra'=>"<span class='fa fa-ra'>",
'fa-random'=>"<span class='fa fa-random'>",
'fa-ravelry'=>"<span class='fa fa-ravelry'>",
'fa-rebel'=>"<span class='fa fa-rebel'>",
'fa-recycle'=>"<span class='fa fa-recycle'>",
'fa-reddit'=>"<span class='fa fa-reddit'>",
'fa-reddit-alien'=>"<span class='fa fa-reddit-alien'>",
'fa-reddit-square'=>"<span class='fa fa-reddit-square'>",
'fa-refresh'=>"<span class='fa fa-refresh'>",
'fa-registered'=>"<span class='fa fa-registered'>",
'fa-remove'=>"<span class='fa fa-remove'>",
'fa-renren'=>"<span class='fa fa-renren'>",
'fa-reorder'=>"<span class='fa fa-reorder'>",
'fa-repeat'=>"<span class='fa fa-repeat'>",
'fa-reply'=>"<span class='fa fa-reply'>",
'fa-reply-all'=>"<span class='fa fa-reply-all'>",
'fa-resistance'=>"<span class='fa fa-resistance'>",
'fa-retweet'=>"<span class='fa fa-retweet'>",
'fa-rmb'=>"<span class='fa fa-rmb'>",
'fa-road'=>"<span class='fa fa-road'>",
'fa-rocket'=>"<span class='fa fa-rocket'>",
'fa-rotate-left'=>"<span class='fa fa-rotate-left'>",
'fa-rotate-right'=>"<span class='fa fa-rotate-right'>",
'fa-rouble'=>"<span class='fa fa-rouble'>",
'fa-rss'=>"<span class='fa fa-rss'>",
'fa-rss-square'=>"<span class='fa fa-rss-square'>",
'fa-rub'=>"<span class='fa fa-rub'>",
'fa-ruble'=>"<span class='fa fa-ruble'>",
'fa-rupee'=>"<span class='fa fa-rupee'>",
'fa-s15'=>"<span class='fa fa-s15'>",
'fa-safari'=>"<span class='fa fa-safari'>",
'fa-save'=>"<span class='fa fa-save'>",
'fa-scissors'=>"<span class='fa fa-scissors'>",
'fa-scribd'=>"<span class='fa fa-scribd'>",
'fa-search'=>"<span class='fa fa-search'>",
'fa-search-minus'=>"<span class='fa fa-search-minus'>",
'fa-search-plus'=>"<span class='fa fa-search-plus'>",
'fa-sellsy'=>"<span class='fa fa-sellsy'>",
'fa-send'=>"<span class='fa fa-send'>",
'fa-send-o'=>"<span class='fa fa-send-o'>",
'fa-server'=>"<span class='fa fa-server'>",
'fa-share'=>"<span class='fa fa-share'>",
'fa-share-alt'=>"<span class='fa fa-share-alt'>",
'fa-share-alt-square'=>"<span class='fa fa-share-alt-square'>",
'fa-share-square'=>"<span class='fa fa-share-square'>",
'fa-share-square-o'=>"<span class='fa fa-share-square-o'>",
'fa-shekel'=>"<span class='fa fa-shekel'>",
'fa-sheqel'=>"<span class='fa fa-sheqel'>",
'fa-shield'=>"<span class='fa fa-shield'>",
'fa-ship'=>"<span class='fa fa-ship'>",
'fa-shirtsinbulk'=>"<span class='fa fa-shirtsinbulk'>",
'fa-shopping-bag'=>"<span class='fa fa-shopping-bag'>",
'fa-shopping-basket'=>"<span class='fa fa-shopping-basket'>",
'fa-shopping-cart'=>"<span class='fa fa-shopping-cart'>",
'fa-shower'=>"<span class='fa fa-shower'>",
'fa-sign-in'=>"<span class='fa fa-sign-in'>",
'fa-sign-language'=>"<span class='fa fa-sign-language'>",
'fa-sign-out'=>"<span class='fa fa-sign-out'>",
'fa-signal'=>"<span class='fa fa-signal'>",
'fa-signing'=>"<span class='fa fa-signing'>",
'fa-simplybuilt'=>"<span class='fa fa-simplybuilt'>",
'fa-sitemap'=>"<span class='fa fa-sitemap'>",
'fa-skyatlas'=>"<span class='fa fa-skyatlas'>",
'fa-skype'=>"<span class='fa fa-skype'>",
'fa-slack'=>"<span class='fa fa-slack'>",
'fa-sliders'=>"<span class='fa fa-sliders'>",
'fa-slideshare'=>"<span class='fa fa-slideshare'>",
'fa-smile-o'=>"<span class='fa fa-smile-o'>",
'fa-snapchat'=>"<span class='fa fa-snapchat'>",
'fa-snapchat-ghost'=>"<span class='fa fa-snapchat-ghost'>",
'fa-snapchat-square'=>"<span class='fa fa-snapchat-square'>",
'fa-snowflake-o'=>"<span class='fa fa-snowflake-o'>",
'fa-soccer-ball-o'=>"<span class='fa fa-soccer-ball-o'>",
'fa-sort'=>"<span class='fa fa-sort'>",
'fa-sort-alpha-asc'=>"<span class='fa fa-sort-alpha-asc'>",
'fa-sort-alpha-desc'=>"<span class='fa fa-sort-alpha-desc'>",
'fa-sort-amount-asc'=>"<span class='fa fa-sort-amount-asc'>",
'fa-sort-amount-desc'=>"<span class='fa fa-sort-amount-desc'>",
'fa-sort-asc'=>"<span class='fa fa-sort-asc'>",
'fa-sort-desc'=>"<span class='fa fa-sort-desc'>",
'fa-sort-down'=>"<span class='fa fa-sort-down'>",
'fa-sort-numeric-asc'=>"<span class='fa fa-sort-numeric-asc'>",
'fa-sort-numeric-desc'=>"<span class='fa fa-sort-numeric-desc'>",
'fa-sort-up'=>"<span class='fa fa-sort-up'>",
'fa-soundcloud'=>"<span class='fa fa-soundcloud'>",
'fa-space-shuttle'=>"<span class='fa fa-space-shuttle'>",
'fa-spinner'=>"<span class='fa fa-spinner'>",
'fa-spoon'=>"<span class='fa fa-spoon'>",
'fa-spotify'=>"<span class='fa fa-spotify'>",
'fa-square'=>"<span class='fa fa-square'>",
'fa-square-o'=>"<span class='fa fa-square-o'>",
'fa-stack-exchange'=>"<span class='fa fa-stack-exchange'>",
'fa-stack-overflow'=>"<span class='fa fa-stack-overflow'>",
'fa-star'=>"<span class='fa fa-star'>",
'fa-star-half'=>"<span class='fa fa-star-half'>",
'fa-star-half-empty'=>"<span class='fa fa-star-half-empty'>",
'fa-star-half-full'=>"<span class='fa fa-star-half-full'>",
'fa-star-half-o'=>"<span class='fa fa-star-half-o'>",
'fa-star-o'=>"<span class='fa fa-star-o'>",
'fa-steam'=>"<span class='fa fa-steam'>",
'fa-steam-square'=>"<span class='fa fa-steam-square'>",
'fa-step-backward'=>"<span class='fa fa-step-backward'>",
'fa-step-forward'=>"<span class='fa fa-step-forward'>",
'fa-stethoscope'=>"<span class='fa fa-stethoscope'>",
'fa-sticky-note'=>"<span class='fa fa-sticky-note'>",
'fa-sticky-note-o'=>"<span class='fa fa-sticky-note-o'>",
'fa-stop'=>"<span class='fa fa-stop'>",
'fa-stop-circle'=>"<span class='fa fa-stop-circle'>",
'fa-stop-circle-o'=>"<span class='fa fa-stop-circle-o'>",
'fa-street-view'=>"<span class='fa fa-street-view'>",
'fa-strikethrough'=>"<span class='fa fa-strikethrough'>",
'fa-stumbleupon'=>"<span class='fa fa-stumbleupon'>",
'fa-stumbleupon-circle'=>"<span class='fa fa-stumbleupon-circle'>",
'fa-subscript'=>"<span class='fa fa-subscript'>",
'fa-subway'=>"<span class='fa fa-subway'>",
'fa-suitcase'=>"<span class='fa fa-suitcase'>",
'fa-sun-o'=>"<span class='fa fa-sun-o'>",
'fa-superpowers'=>"<span class='fa fa-superpowers'>",
'fa-superscript'=>"<span class='fa fa-superscript'>",
'fa-support'=>"<span class='fa fa-support'>",
'fa-table'=>"<span class='fa fa-table'>",
'fa-tablet'=>"<span class='fa fa-tablet'>",
'fa-tachometer'=>"<span class='fa fa-tachometer'>",
'fa-tag'=>"<span class='fa fa-tag'>",
'fa-tags'=>"<span class='fa fa-tags'>",
'fa-tasks'=>"<span class='fa fa-tasks'>",
'fa-taxi'=>"<span class='fa fa-taxi'>",
'fa-telegram'=>"<span class='fa fa-telegram'>",
'fa-television'=>"<span class='fa fa-television'>",
'fa-tencent-weibo'=>"<span class='fa fa-tencent-weibo'>",
'fa-terminal'=>"<span class='fa fa-terminal'>",
'fa-text-height'=>"<span class='fa fa-text-height'>",
'fa-text-width'=>"<span class='fa fa-text-width'>",
'fa-th'=>"<span class='fa fa-th'>",
'fa-th-large'=>"<span class='fa fa-th-large'>",
'fa-th-list'=>"<span class='fa fa-th-list'>",
'fa-themeisle'=>"<span class='fa fa-themeisle'>",
'fa-thermometer'=>"<span class='fa fa-thermometer'>",
'fa-thermometer-0'=>"<span class='fa fa-thermometer-0'>",
'fa-thermometer-1'=>"<span class='fa fa-thermometer-1'>",
'fa-thermometer-2'=>"<span class='fa fa-thermometer-2'>",
'fa-thermometer-3'=>"<span class='fa fa-thermometer-3'>",
'fa-thermometer-4'=>"<span class='fa fa-thermometer-4'>",
'fa-thermometer-empty'=>"<span class='fa fa-thermometer-empty'>",
'fa-thermometer-full'=>"<span class='fa fa-thermometer-full'>",
'fa-thermometer-half'=>"<span class='fa fa-thermometer-half'>",
'fa-thermometer-quarter'=>"<span class='fa fa-thermometer-quarter'>",
'fa-thermometer-three-quarters'=>"<span class='fa fa-thermometer-three-quarters'>",
'fa-thumb-tack'=>"<span class='fa fa-thumb-tack'>",
'fa-thumbs-down'=>"<span class='fa fa-thumbs-down'>",
'fa-thumbs-o-down'=>"<span class='fa fa-thumbs-o-down'>",
'fa-thumbs-o-up'=>"<span class='fa fa-thumbs-o-up'>",
'fa-thumbs-up'=>"<span class='fa fa-thumbs-up'>",
'fa-ticket'=>"<span class='fa fa-ticket'>",
'fa-times'=>"<span class='fa fa-times'>",
'fa-times-circle'=>"<span class='fa fa-times-circle'>",
'fa-times-circle-o'=>"<span class='fa fa-times-circle-o'>",
'fa-times-rectangle'=>"<span class='fa fa-times-rectangle'>",
'fa-times-rectangle-o'=>"<span class='fa fa-times-rectangle-o'>",
'fa-tint'=>"<span class='fa fa-tint'>",
'fa-toggle-down'=>"<span class='fa fa-toggle-down'>",
'fa-toggle-left'=>"<span class='fa fa-toggle-left'>",
'fa-toggle-off'=>"<span class='fa fa-toggle-off'>",
'fa-toggle-on'=>"<span class='fa fa-toggle-on'>",
'fa-toggle-right'=>"<span class='fa fa-toggle-right'>",
'fa-toggle-up'=>"<span class='fa fa-toggle-up'>",
'fa-trademark'=>"<span class='fa fa-trademark'>",
'fa-train'=>"<span class='fa fa-train'>",
'fa-transgender'=>"<span class='fa fa-transgender'>",
'fa-transgender-alt'=>"<span class='fa fa-transgender-alt'>",
'fa-trash'=>"<span class='fa fa-trash'>",
'fa-trash-o'=>"<span class='fa fa-trash-o'>",
'fa-tree'=>"<span class='fa fa-tree'>",
'fa-trello'=>"<span class='fa fa-trello'>",
'fa-tripadvisor'=>"<span class='fa fa-tripadvisor'>",
'fa-trophy'=>"<span class='fa fa-trophy'>",
'fa-truck'=>"<span class='fa fa-truck'>",
'fa-try'=>"<span class='fa fa-try'>",
'fa-tty'=>"<span class='fa fa-tty'>",
'fa-tumblr'=>"<span class='fa fa-tumblr'>",
'fa-tumblr-square'=>"<span class='fa fa-tumblr-square'>",
'fa-turkish-lira'=>"<span class='fa fa-turkish-lira'>",
'fa-tv'=>"<span class='fa fa-tv'>",
'fa-twitch'=>"<span class='fa fa-twitch'>",
'fa-twitter'=>"<span class='fa fa-twitter'>",
'fa-twitter-square'=>"<span class='fa fa-twitter-square'>",
'fa-umbrella'=>"<span class='fa fa-umbrella'>",
'fa-underline'=>"<span class='fa fa-underline'>",
'fa-undo'=>"<span class='fa fa-undo'>",
'fa-universal-access'=>"<span class='fa fa-universal-access'>",
'fa-university'=>"<span class='fa fa-university'>",
'fa-unlink'=>"<span class='fa fa-unlink'>",
'fa-unlock'=>"<span class='fa fa-unlock'>",
'fa-unlock-alt'=>"<span class='fa fa-unlock-alt'>",
'fa-unsorted'=>"<span class='fa fa-unsorted'>",
'fa-upload'=>"<span class='fa fa-upload'>",
'fa-usb'=>"<span class='fa fa-usb'>",
'fa-usd'=>"<span class='fa fa-usd'>",
'fa-user'=>"<span class='fa fa-user'>",
'fa-user-circle'=>"<span class='fa fa-user-circle'>",
'fa-user-circle-o'=>"<span class='fa fa-user-circle-o'>",
'fa-user-md'=>"<span class='fa fa-user-md'>",
'fa-user-o'=>"<span class='fa fa-user-o'>",
'fa-user-plus'=>"<span class='fa fa-user-plus'>",
'fa-user-secret'=>"<span class='fa fa-user-secret'>",
'fa-user-times'=>"<span class='fa fa-user-times'>",
'fa-users'=>"<span class='fa fa-users'>",
'fa-vcard'=>"<span class='fa fa-vcard'>",
'fa-vcard-o'=>"<span class='fa fa-vcard-o'>",
'fa-venus'=>"<span class='fa fa-venus'>",
'fa-venus-double'=>"<span class='fa fa-venus-double'>",
'fa-venus-mars'=>"<span class='fa fa-venus-mars'>",
'fa-viacoin'=>"<span class='fa fa-viacoin'>",
'fa-viadeo'=>"<span class='fa fa-viadeo'>",
'fa-viadeo-square'=>"<span class='fa fa-viadeo-square'>",
'fa-video-camera'=>"<span class='fa fa-video-camera'>",
'fa-vimeo'=>"<span class='fa fa-vimeo'>",
'fa-vimeo-square'=>"<span class='fa fa-vimeo-square'>",
'fa-vine'=>"<span class='fa fa-vine'>",
'fa-vk'=>"<span class='fa fa-vk'>",
'fa-volume-control-phone'=>"<span class='fa fa-volume-control-phone'>",
'fa-volume-down'=>"<span class='fa fa-volume-down'>",
'fa-volume-off'=>"<span class='fa fa-volume-off'>",
'fa-volume-up'=>"<span class='fa fa-volume-up'>",
'fa-warning'=>"<span class='fa fa-warning'>",
'fa-wechat'=>"<span class='fa fa-wechat'>",
'fa-weibo'=>"<span class='fa fa-weibo'>",
'fa-weixin'=>"<span class='fa fa-weixin'>",
'fa-whatsapp'=>"<span class='fa fa-whatsapp'>",
'fa-wheelchair'=>"<span class='fa fa-wheelchair'>",
'fa-wheelchair-alt'=>"<span class='fa fa-wheelchair-alt'>",
'fa-wifi'=>"<span class='fa fa-wifi'>",
'fa-wikipedia-w'=>"<span class='fa fa-wikipedia-w'>",
'fa-window-close'=>"<span class='fa fa-window-close'>",
'fa-window-close-o'=>"<span class='fa fa-window-close-o'>",
'fa-window-maximize'=>"<span class='fa fa-window-maximize'>",
'fa-window-minimize'=>"<span class='fa fa-window-minimize'>",
'fa-window-restore'=>"<span class='fa fa-window-restore'>",
'fa-windows'=>"<span class='fa fa-windows'>",
'fa-won'=>"<span class='fa fa-won'>",
'fa-wordpress'=>"<span class='fa fa-wordpress'>",
'fa-wpbeginner'=>"<span class='fa fa-wpbeginner'>",
'fa-wpexplorer'=>"<span class='fa fa-wpexplorer'>",
'fa-wpforms'=>"<span class='fa fa-wpforms'>",
'fa-wrench'=>"<span class='fa fa-wrench'>",
'fa-xing'=>"<span class='fa fa-xing'>",
'fa-xing-square'=>"<span class='fa fa-xing-square'>",
'fa-y-combinator'=>"<span class='fa fa-y-combinator'>",
'fa-y-combinator-square'=>"<span class='fa fa-y-combinator-square'>",
'fa-yahoo'=>"<span class='fa fa-yahoo'>",
'fa-yc'=>"<span class='fa fa-yc'>",
'fa-yc-square'=>"<span class='fa fa-yc-square'>",
'fa-yelp'=>"<span class='fa fa-yelp'>",
'fa-yen'=>"<span class='fa fa-yen'>",
'fa-yoast'=>"<span class='fa fa-yoast'>",
'fa-youtube'=>"<span class='fa fa-youtube'>",
'fa-youtube-play'=>"<span class='fa fa-youtube-play'>",
'fa-youtube-square'=>"<span class='fa fa-youtube-square'>",

        ];
    }
  public static function getCboSustancias(){
         
        
        return ArrayHelper::map(
                        \common\models\Sustancia::find()->
                  all(),
                'id','descripcion');
    }  
    
 public static function getCboServicios(){        
        
        return ArrayHelper::map(
                        \common\models\masters\ServiciosTarifados::find()->
                  all(),
                'id','descripcion');
    }
    
  public static function getCboCargos(){        
        
        return ArrayHelper::map(
                        \common\models\masters\Cargos::find()->
                  all(),
                'codcargo','descricargo');
    }  
    
}