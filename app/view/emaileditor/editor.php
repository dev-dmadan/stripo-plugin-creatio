<?php Defined('BASE_PATH') or die(ACCESS_DENIED); ?>

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
        <link rel="stylesheet" href="<?= ASSETS. "animate/animate.css" ?>">

	</head>
	<body>

        <!-- loading -->
        <div id="loader-wrapper">
            <div id="loader"></div>
        </div>

        <div id="main-editor">
            <input type="hidden" id="access_key" value="<?=$access_key?>">
            <input type="hidden" id="action" value="<?=$action?>">
            <input type="hidden" id="templateId" value="<?=$templateId?>">
            <input type="hidden" id="emailId" value="<?=$emailId?>">
            
            <!-- navbar -->
            <nav class="navbar navbar-default navbar-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img class="logo-citilink" alt="Brand" width="96.1px" height="30.1px" src="<?= ASSETS."img/citilink-logo.png"; ?>"></a>
                        <div class="pull-right">
                        </div>
                        
                    </div>
                
                    <div id="navbar" class="navbar-collapse collapse">
                        <!-- panel 1 -->
                        <ul class="nav navbar-nav ">
                        </ul>
                        <form id="form-editor" class="navbar-form navbar-left" role="form">
                            <div class="form-group">
                                <input id="templateName" type="text" class="form-control" placeholder="Template Name" value="<?= $templateName ?>">
                            </div>
                            <button id="save" type="button" class="btn btn-default" data-toggle="tooltip" data-placement="bottom" title="Save Email"><i class="fas fa-save"></i></button>
                        </form>

                        <!-- panel 2 -->
                        <ul class="nav navbar-nav navbar-right ">
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
                    <div class="col-md-3 col-md-3 col-sm-6 col-xs-12" style="padding-right: 0px; margin:-20px 0px 0px -10px; position: relative;">
                        <div id="stripoSettingsContainer"></div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-6 col-xs-12" style="padding-right: 0px; margin:-20px 0px 0px 10px; position: relative;">
                        <div id="stripoPreviewContainer"></div>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once('preview.php') ?>

        <script>
            const BASE_URL = "<?php echo BASE_URL ?>";
            const SITE_URL = "<?php echo SITE_URL ?>";
        </script>

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