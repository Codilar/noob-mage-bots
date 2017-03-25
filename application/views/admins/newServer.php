<div id="page-wrapper">

    <div class="container-fluid">
        <div id="message_notice">
            <?php echo $this->session->flashdata('response_message'); ?>
        </div>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    New Server
                    <small>Install & configure full server</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li class="active">
                        <i class="fa fa-file"></i> New Server
                    </li>
                </ol>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-center">Install Basic LAMP Stack</h3>
                    <form accept-charset="UTF-8" role="form" class="form-signin" action="<?php echo base_url() ?>newServer/config_new_server" method="post">
                    <div class="form-group">
                        <label for="">Server Name</label>
                        <input class="form-control" placeholder="Server Name" id="server_name" type="text" name="server_name" required>
<!--                        <p class="help-block">Example block-level help text here.</p>-->
                    </div>
                    <div class="form-group">
                        <label for="">Server IP</label>
                        <input class="form-control" placeholder="Server IP" id="server_ip" type="text" name="server_ip" required>
                    </div>
                    <div class="form-group">
                        <label for="">Server URL</label>
                        <input class="form-control" placeholder="Server URL" id="server_url" type="text" name="server_url" required>
                    </div>
                    <div class="form-group">
                        <label for="">Server Username</label>
                        <input class="form-control" placeholder="Server Username" id="server_username" type="text" name="server_username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Server Password</label>
                        <input class="form-control" placeholder="Server Password" id="server_password" type="text" name="server_password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Server Port</label>
                        <input class="form-control" placeholder="Server URL" id="server_port" type="text" name="server_port" required>
                    </div>
                    <div class="form-group">
                        <label for="">Database Username</label>
                        <input class="form-control" placeholder="Database Username" id="database_username" type="text" name="database_username" required>
                    </div>
                    <div class="form-group">
                        <label for="">Database Password</label>
                        <input class="form-control" placeholder="Database Password" id="database_password" type="text" name="database_password" required>
                    </div>

                    <div class="form-group">
                        <label>Key File</label>
                        <input class="form-control" placeholder="Key File" id="key_file" type="file" name="key_file">
                    </div>

                    <div class="form-group">
                        <label>Developer Note</label>
                        <textarea class="form-control" rows="3" placeholder="Write instruction for developers" id="developer_note" name="developer_note"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Select what to install: </label><br>
                        <div class="checkbox-inline">
                            <label>
                                <input type="checkbox" id="apache_install" type="file" name="apache_install" value="apache_install">Install Apache
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label>
                                <input type="checkbox" id="php_install" type="file" name="php_install" value="php_install">Install PHP
                            </label>
                        </div>
                        <div class="checkbox-inline">
                            <label>
                                <input type="checkbox" id="mysql_install" type="file" name="mysql_install" value="mysql_install">Install MySQL
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Connections Type</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="connection_type" id="connection_type_password" value="connection_type_password" checked>Password Connection
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="connection_type" id="connection_type_key" value="connection_type_key">Key Connection
                            </label>
                        </div>
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