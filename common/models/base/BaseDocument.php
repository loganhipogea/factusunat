<?PHP
namespace common\models\base;

class BaseDocument extends \common\models\base\modelBase
{
    const ST_CREATED='10';
    const ST_CANCELED='99';
    const ST_PASSED='20';
    
    /*
     * CONSTANTES DE TIPO DE DOCUMENTO
     */
    const TYPE_DOC_INVOICE='01';//factura
    const TYPE_DOC_VOUCHER='03'; //boleta
    
}
