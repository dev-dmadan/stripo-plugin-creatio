<?php Defined('BASE_PATH') or die(ACCESS_DENIED); ?>

<div class="preview-email" style="display: none; background-color: #F5F5F5;" >
        <!-- Header -->
        <div class="panel panel-default">
    <div class="panel-body">
        <button id="back-preview" class="btn btn-default button-rounded" style="border-radius: 32px;"><i class="fas fa-arrow-left"></i></button>
        <button id="test-email" class="btn btn-default button-rounded" style="margin-left: 10px; border-radius: 32px;"><i class="fas fa-paper-plane"></i> <strong>Test Email</strong></button>
    </div>
    </div>

    <div class="container-fluid">
    <div class="row">

        <!-- desktop / laptop -->
        <div class="col-lg-8 col-md-8">

        <div class="laptop">
            <div class="panel panel-default">
            <!-- header content -->
            <div class="panel-heading">
                <img  src="<?= BASE_URL. "assets/img/citilink-logo.png" ?>" style="width: 150px; height: 48px;" />
            </div>

            <!-- body content -->
            <div class="panel-body" style="height: 850px;">
                <iframe id="frameDekstop" src="" style="width:100%;border:none;height:100%"></iframe>
            </div>
            </div>
        </div>
        </div>

        <!-- mobile -->
        <div class="col-lg-4 col-md-4">

        <div class="smartphone">
            <div class="panel panel-default" style="border: 0;">

                <!-- header content -->
                <div class="panel-heading" style="padding: 0; height: 65px;">
                    <img src="<?= BASE_URL. "assets/img/mobile-view-top-bar.png" ?>"/>
                </div>

                <!-- body content -->
                <div class="panel-body" style="padding: 0; height: 460px;">
                    <iframe id="frameSmartphone" src="" style="width:100%;border:none;height:100%"></iframe>
                </div>

                <!-- footer content -->
                <div class="panel-footer" style="border-top: 0; padding: 0; height: 44px;">
                    <img src="<?= BASE_URL. "assets/img/mobile-view-bottom-bar.png" ?>"/>
                </div>
            </div>
        </div>

        <?php include_once('testmail.php') ?>

    </div>
    <!-- end row -->
    </div>
    <!-- end container -->
</div>


