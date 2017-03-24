<?php
// Collecting variables
//echo "<pre>";
//$this->session->unset_userdata('admin_data');
$adminDataCollection = $this->session->userdata('admin_data');
//print_r($adminDataCollection);
if ($adminDataCollection['permissionId']){
    $permissionList = permission_list($adminDataCollection['permissionId']);
//    print_r($permissionList);
//    die();
}
if (!$permissionList) {
    $this->session->unset_userdata('admin_data');
}
?>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo base_url() ?>">Codilar Admin</a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                <ul class="dropdown-menu message-dropdown">
                    <li class="message-preview">
                        <a href="#">
                            <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                <div class="media-body">
                                    <h5 class="media-heading"><strong>John Smith</strong>
                                    </h5>
                                    <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="message-preview">
                        <a href="#">
                            <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                <div class="media-body">
                                    <h5 class="media-heading"><strong>John Smith</strong>
                                    </h5>
                                    <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="message-preview">
                        <a href="#">
                            <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                <div class="media-body">
                                    <h5 class="media-heading"><strong>John Smith</strong>
                                    </h5>
                                    <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                    <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="message-footer">
                        <a href="#">Read All New Messages</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                <ul class="dropdown-menu alert-dropdown">
                    <li>
                        <a href="#">Alert Name <span class="label label-default">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-primary">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-success">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-info">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-warning">Alert Badge</span></a>
                    </li>
                    <li>
                        <a href="#">Alert Name <span class="label label-danger">Alert Badge</span></a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="#">View All</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $adminDataCollection['firstName']." ".$adminDataCollection['lastName'] ?> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?php echo base_url() ?>admins/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li class="<?php if($page=='admin_dashboard'){echo "active";} ?>">
                    <a href="<?php echo base_url() ?>admins/admin_dashboard"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                </li>
                <?php $featureId = is_permission_granted('new_server',$permissionList);
                if ($featureId != null): ?>
                    <li class="<?php if($page=='new_server'){echo "active";} ?>">
                        <a href="<?php echo base_url() ?>admins/new_server/<?php echo $featureId?>"><i class="fa fa-fw fa-gears"></i> New Server</a>
                    </li>
                <?php endif; ?>
                <?php $featureId = is_permission_granted('update_server',$permissionList);
                if ($featureId != null): ?>
                    <li class="<?php if($page=='update_server'){echo "active";} ?>">
                        <a href="<?php echo base_url() ?>admins/update_server/<?php echo $featureId?>"><i class="fa fa-fw fa-stethoscope"></i> Update Server</a>
                    </li>
                <?php endif; ?>
                <?php $featureId = is_permission_granted('install_magento',$permissionList);
                if ($featureId != null): ?>
                    <li class="<?php if($page=='install_magento'){echo "active";} ?>">
                        <a href="<?php echo base_url() ?>admins/install_magento/<?php echo $featureId?>"><i class="fa fa-fw fa-gears"></i> Install Magento</a>
                    </li>
                <?php endif; ?>
                <?php $featureId = is_permission_granted('website_analysis',$permissionList);
                if ($featureId != null): ?>
                    <li class="<?php if($page=='website_analysis'){echo "active";} ?>">
                        <a href="<?php echo base_url() ?>admins/website_analysis/<?php echo $featureId?>"><i class="fa fa-fw fa-bar-chart-o"></i> Website Analysis</a>
                    </li>
                <?php endif; ?>
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url() ?><!--"><i class="fa fa-fw fa-table"></i> Tables</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url() ?><!--"><i class="fa fa-fw fa-edit"></i> Forms</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url() ?><!--"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>-->
<!--                </li>-->
<!--                <li>-->
<!--                    <a href="--><?php //echo base_url() ?><!--"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>-->
<!--                </li>-->
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#serverList"><i class="fa fa-fw fa-arrows-v"></i> Servers <i class="fa fa-fw fa-caret-down"></i></a>
                    <ul id="serverList" class="collapse">
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                        <li>
                            <a href="#">Dropdown Item</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="blank-page.html"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                </li>
                <li>
                    <a href="index-rtl.html"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>