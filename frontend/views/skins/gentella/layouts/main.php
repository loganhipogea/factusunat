<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use common\helpers\h;

$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php
    $this->registerCssFile('@web/css/gentelella_ajustes.css', 
           ['depends' => [yiister\gentelella\assets\Asset::className()]]);
    ?>
    <?php
    $this->registerCssFile('@web/css/Adminlte_personalizado.css', 
           ['depends' => [yiister\gentelella\assets\Asset::className()]]
            );
    ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">

        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="/" class="site_title"><?=Html::img('@web/img/logo_neozolver.svg', ['alt' => 'Logo','width'=>40,'height'=>40]); ?>  <span><?=h::app()->name?></span></a>
                </div>
                <div class="clearfix"></div>

                
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        
           <?php $items=common\helpers\MenuHelper::getAssignedMenu(
                   yii::$app->user->id
                   ,null/*root*/, 
                    function ($menu) {
    // $data = eval($menu['data']);
     return [
         'label' => $menu['name'],
        'url' => (empty($menu['route']))?'#':[$menu['route']],
         'icon'=>$menu['icon'],
        // 'options' => $data,
         'items' => $menu['items']
         ];
     
            },
                   true/*refresh*/);?>  
       <?php  /*var_dump($items);die();*/?>
       
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            [
                               "items" =>$items, 
                                /*"items" => [
                                    ["label" => "Home", "url" => "/", "icon" => "home"],
                                    ["label" => "About", "url" => ["site/about"], "icon" => "files-o"],
                                    ["label" => "Error page", "url" => ["site/error-page"], "icon" => "close"],
                                    
                                    
                                    [
                                        "label" => "Widgets",
                                        "icon" => "th",
                                        "url" => "#",
                                        "items" => [
                                            ["label" => "Menu", "url" => ["site/menu"]],
                                            ["label" => "Panel", "url" => ["site/panel"]],
                                        ],
                                    ],
                                    [
                                        "label" => "Badges",
                                        "url" => "#",
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Default",
                                                "url" => "#",
                                                "badge" => "123",
                                            ],
                                            [
                                                "label" => "Success",
                                                "url" => "#",
                                                "badge" => "new",
                                                "badgeOptions" => ["class" => "label-success"],
                                            ],
                                            [
                                                "label" => "Danger",
                                                "url" => "#",
                                                "badge" => "!",
                                                "badgeOptions" => ["class" => "label-danger"],
                                            ],
                                        ],
                                    ],
                                    [
                                        "label" => "Multilevel",
                                        "url" => "#",
                                        "icon" => "table",
                                        "items" => [
                                            [
                                                "label" => "Second level 1",
                                                "url" => "#",
                                            ],
                                            [
                                                "label" => "Second level 2",
                                                "url" => "#",
                                                "items" => [
                                                    [
                                                        "label" => "Third level 1",
                                                        "url" => "#",
                                                    ],
                                                    [
                                                        "label" => "Third level 2",
                                                        "url" => "#",
                                                    ],
                                                ],
                                            ],
                                        ],
                                    ],
                                ],*/
                            ]
                        )
                        ?>
                    </div>
                <?php
use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'buscarvalor',
    'header' => 'Buscar Valor',
    'toggleButton' => false,
    //'mode'=>ModalAjax::MODE_MULTI,
    'size'=>\yii\bootstrap\Modal::SIZE_LARGE,    
    'selector'=>'.botonAbre',
   // 'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
     'options' => ['tabindex' => false],
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);

?>
    <?php \shifrin\noty\NotyWidget::widget([
    'options' => [ // you can add js options here, see noty plugin page for available options
        'dismissQueue' => true,
        'layout' => 'center',
        'theme' => 'metroui',
        'animation' => [
            'open' => 'animated flipInX',
            'close' => 'animated flipOutX',
        ],
        'timeout' =>1000, //false para que no se borre
        'progressBar'=>true,
    ],
    'enableSessionFlash' => true,
    'enableIcon' => true,
    'registerAnimateCss' => true,
    'registerButtonsCss' => true,
    'registerFontAwesomeCss' => true,
]); ?>
                        
                    
                </div>
                <!-- /sidebar menu -->

                <!-- /menu footer buttons -->
                <div class="sidebar-footer hidden-small">
                    <a data-toggle="tooltip" data-placement="top" title="Settings">
                        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Lock">
                        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                    </a>
                    <a data-toggle="tooltip" data-placement="top" title="Logout">
                        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                    </a>
                </div>
                <!-- /menu footer buttons -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">

            <div class="nav_menu">
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user" style="font-size:1.5em;padding-right: 4px;color: #ffc24d;"></i><?=h::userName() ?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li><a href="javascript:;">  Profile</a>
                                </li>
                                <li>
                                    <a href="javascript:;">
                                        <span class="badge bg-red pull-right">50%</span>
                                        <span>Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:;">Help</a>
                                </li>
                                <li>
                                   <?= Html::a(
                                    yii::t('base.verbs','Logout').'<i class="fa fa-sign-out pull-right"></i>',
                                    ['/site/logout'],
                                    ['data-method' => 'post',]
                                           )
                                 ?>
                                    
                                </li>
                            </ul>
                        </li>

                        
                         <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-money" style="font-size:1.5em;padding-right: 4px;color: #ffc24d;"></i>
                                <?php echo \common\helpers\h::tipoCambio('USD')['compra'] ?>/<?php echo \common\helpers\h::tipoCambio('USD')['venta'] ?>
                            </a>
                            
                        </li>
                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-industry" style="font-size:1.5em;padding-right: 4px;color: #ffc24d;"></i>
                                <?php 
                                if(\yii::$app->session->has(\common\models\masters\VwSociedades::keysesion()))
                                echo \common\models\masters\VwSociedades::despro();                               
                                ?>
                               
                            </a>
                            
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>
            <section class="content-header">
                    <?php if (isset($this->blocks['content-header'])) { ?>
                        <h1><?= $this->blocks['content-header'] ?></h1>
                             <?php } else { ?>
                            <h1>
                                <?php
               /* if ($this->title !== null) {
                    echo \yii\helpers\Html::encode($this->title);
                } else {
                    echo \yii\helpers\Inflector::camel2words(
                        \yii\helpers\Inflector::id2camel($this->context->module->id)
                    );
                    echo ($this->context->module->id !== \Yii::$app->id) ? '<small>Module</small>' : '';
                }*/                 ?>
                            </h1>
                                <?php } ?>

        <?=
        Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
    </section>
            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Software desarrollado por 
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<!-- /footer content -->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
