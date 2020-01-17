<?php 
Defined('BASE_PATH') or die(ACCESS_DENIED); 

var_dump(array(
    'emailId' => $emailId,
    'templateId' => $templateId,
    'templateName' => $templateName,
    'macro' => $macro,
    'action' => $action
));

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- <link rel="icon" href="../../../../favicon.ico"> -->
		<title>Advanced Email Editor</title>
		<link rel="stylesheet" href="<?= ASSETS. "bootstrap/bootstrap.min.css" ?>">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
		<link rel="stylesheet" href="<?= ASSETS. "sweet-alert2/sweetalert2.min.css" ?>">
		<link rel="stylesheet" href="<?= BASE_URL. "app/view/emaileditor/css/style.css" ?>">
		<link rel="stylesheet" href="<?= BASE_URL. "app/view/emaileditor/css/loading.css" ?>">

	</head>
	<body>

        <!-- loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>

        <div id="main-editor">

            <!-- navbar -->
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img alt="Brand" width="96.1px" height="68.2px" src="<?= ASSETS."img/citilink-logo.png"; ?>"></a>
                        <div class="pull-right">
                        </div>
                        
                    </div>
                
                    <div id="navbar" class="navbar-collapse collapse">
                        <!-- panel 1 -->
                        <ul class="nav navbar-nav">
                        </ul>
                        <form id="form-editor" class="navbar-form navbar-left" role="form">
                            <div class="form-group">
                                <input id="templateName" type="text" class="form-control" placeholder="Template Name" value="<?= $templateName ?>">
                            </div>
                            <button id="save" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Save Email"><i class="fas fa-save"></i></button>
                            <button id="saveAsTemplate" type="button" class="btn btn-default" title="Save as Template"><i class="fas fa-save"></i> Save as Template</button>
                        </form>

                        <!-- panel 2 -->
                        <ul class="nav navbar-nav navbar-right">
                            <div class="btn-group">
                                <button id="undoButton" type="button" class="btn btn-default navbar-btn" data-toggle="tooltip" data-placement="bottom" title="Undo"><i class="fas fa-undo"></i></button>
                                <button id="redoButton" type="button" class="btn btn-default navbar-btn" data-toggle="tooltip" data-placement="bottom" title="Redo"><i class="fas fa-redo"></i></button>
                            </div>
                            <button id="codeEditor" type="button" class="btn btn-default navbar-btn" data-toggle="tooltip" data-placement="bottom" title="Code Editor"><i class="fas fa-code"></i></button>
                            <button id="preview" type="button" class="btn btn-default navbar-btn" data-toggle="tooltip" data-placement="bottom" title="Preview Email"><i class="fas fa-eye"></i></button>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>
            <!-- end navbar -->

            <!-- Main Container -->
            <div class="container-fluid">

                <!-- Container Plugin -->
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <div id="stripoSettingsContainer"></div>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                        <div id="stripoPreviewContainer"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('preview.php') ?>

        <!-- assets js -->
		<script src="<?= ASSETS. "jquery/jquery-3.4.1.min.js" ?>"></script>
        <script src="<?= ASSETS. "bootstrap/popper.min.js" ?>"></script>
		<script src="<?= ASSETS. "bootstrap/bootstrap.min.js" ?>"></script>
		<script src="<?= ASSETS. "sweet-alert2/sweetalert2.min.js" ?>"></script>

        <!-- stripo - custom js -->
        <script src="https://plugins.stripo.email/static/latest/stripo.js"></script>
        <script src="<?= BASE_URL. "app/view/emaileditor/js/init.js" ?>"></script>
	</body>
</html>