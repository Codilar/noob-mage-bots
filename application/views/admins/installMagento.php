<div id="page-wrapper">

    <div class="container-fluid">
        <div id="message_notice">
            <?php echo $this->session->flashdata('response_message'); ?>
        </div>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    New Magento Installation
                    <small>Install & configure full magento</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> Install Magento
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-center">Install Magento</h3>
                <form accept-charset="UTF-8" role="form" class="form-install-magento-one" action="<?php echo base_url() ?>installMagento/install_new_magento_one" method="post">
                    <div class="form-group">
                        <label>Select Magento Version</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="select_magento" id="magento_one" value="magento_one">Magento
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="select_magento" id="magento_two" value="magento_two">Magento 2
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Select Server</label>
                        <?php
                        foreach ($server_details as $server): ?>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="select_server" id="<?php echo $server->server_id?>" value="<?php echo $server->server_id?>"><?php echo $server->server_name?>
                                </label>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                </form>

            </div>
        </div>



    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->