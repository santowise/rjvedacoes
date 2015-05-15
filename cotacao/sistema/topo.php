<?php
//Importa nome do funcionario logado. Pego no arquivo index.php na raiz
global $nome_funcionario_logado;
global $id_funcionario_logado;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cotação | RJ Vedações</title>
        <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="<?php echo HOST_URL ?>/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="<?php echo HOST_URL ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="<?php echo HOST_URL ?>/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="<?php echo HOST_URL ?>/css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- daterange picker -->
        <link href="<?php echo HOST_URL ?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- iCheck for checkboxes and radio inputs -->
        <link href="<?php echo HOST_URL ?>/css/iCheck/all.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap Color Picker -->
        <link href="<?php echo HOST_URL ?>/css/colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet"/>
        <!-- Bootstrap time Picker -->
        <link href="<?php echo HOST_URL ?>/css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
        <!-- jvectormap -->
        <link href="<?php echo HOST_URL ?>/css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="<?php echo HOST_URL ?>/css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="<?php echo HOST_URL ?>/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="<?php echo HOST_URL ?>/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- DATA TABLES -->
        <link href="<?php echo HOST_URL ?>/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- LightBox -->
        <link href="<?php echo HOST_URL ?>/css/ekko-lightbox/ekko-lightbox.css" rel="stylesheet" type="text/css" /> 
        <!-- DatePicker -->
        <link href="<?php echo HOST_URL ?>/css/bootstrap-datepicker/datepicker.css" rel="stylesheet" type="text/css" />
        
        <link href="<?php echo HOST_URL ?>/css/colorbox/colorbox.css" rel="stylesheet" type="text/css" />       
        <!-- Theme style -->
        <link href="<?php echo HOST_URL ?>/css/AdminLTE.css" rel="stylesheet" type="text/css" />               
    

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">    
    
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo HOST_URL ?>/" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="<?php echo HOST_URL ?>/img/logo.png">
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>                
                
				<div class="navbar-right">
                    <ul class="nav navbar-nav"> 
						
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $nome_funcionario_logado ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">                               
                                
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="<?php echo HOST_URL ?>/sair" class="btn btn-default btn-flat">Sair</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                    
                </div>
            </nav>
        </header>
        
        
        <?php
        /**
		 * Menu Lateral
		 **/		
		?>
        
        
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">                        
                        <?php /*
                        <!-- Canais -->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-sitemap"></i> <span>Canais</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                                            
                            	<!-- Canais -->
                                <li><a><i class="fa fa-sitemap"></i> Canais</a></li>
                                
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/canais/listar">
                                    <i class="fa fa-angle-right"></i> Listar</a></li>
                                                                    
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/canais/cadastrar">
                                    <i class="fa fa-angle-right"></i> Cadastrar</a></li>
                            
                            	<!-- Categorias -->
                                <li><a><i class="fa fa-sitemap"></i> Categorias</a></li>
                                
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/categorias/listar">
                                    <i class="fa fa-angle-right"></i> Listar</a></li>
                                                                    
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/categorias/cadastrar">
                                    <i class="fa fa-angle-right"></i> Cadastrar</a></li>
                                                            
                            	<!-- Subcategorias -->
                                <li><a><i class="fa fa-sitemap"></i> Subcategorias</a></li>
                                
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/subcategorias/listar">
                                    <i class="fa fa-angle-right"></i> Listar</a></li>
                                                                    
                                    <li><a class="treeview-submenu"
                                    href="<?php echo HOST_URL ?>/canais/subcategorias/cadastrar">
                                    <i class="fa fa-angle-right"></i> Cadastrar</a></li>
                                    
                            </ul>
                        </li> */ ?> 
                        
                        <!-- Clientes -->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>Clientes</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo HOST_URL ?>/clientes/listar">
                                <i class="fa fa-angle-double-right"></i> Listar</a></li>
                                <li><a href="<?php echo HOST_URL ?>/clientes/cadastrar">
                                <i class="fa fa-angle-double-right"></i> Cadastrar</a></li>
                            </ul>
                        </li>                        
                        
                        <!-- Funcionários -->
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-lock"></i> <span>Funcionários</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo HOST_URL ?>/funcionarios/listar">
                                <i class="fa fa-angle-double-right"></i> Listar</a></li>
                                
                                <li><a href="<?php echo HOST_URL ?>/funcionarios/cadastrar">
                                <i class="fa fa-angle-double-right"></i> Cadastrar</a></li>                                
                            </ul>
                        </li>
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>


            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">                
                <!-- Content Header (Page header) -->
                <section class="content-header">
                <?php
				/*
				 * Se houver alguma mensagem de status a ser mostrada ao
				 * usuário, o arquivo seguinte cuidará disso.
				 */
				require SISTEMA_PATH . "/mensagens_status.php";
                ?>