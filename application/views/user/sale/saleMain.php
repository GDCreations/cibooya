<script type="text/javascript" src="<?= base_url(); ?>assets/js/custom-js/full_width.js"></script>
<style>
    .app-widget-tile{
        cursor: pointer;
    }
</style>
<!-- START PAGE HEADING -->
<div class="app-heading-container app-heading-bordered bottom">
    <ul class="breadcrumb">
        <li class="active"><a href="#">Sales</a></li>
    </ul>
</div>
<div class="app-heading app-heading-bordered app-heading-page">
    <div class="icon icon-lg">
        <span class="fa fa-shopping-cart" style="color: #e69c0f;"></span>
    </div>
    <div class="title">
        <h1>Sales</h1>
        <p>Cash / Credit / Cheque</p>
    </div>
</div>
<!-- END PAGE HEADING -->
<!-- START PAGE CONTAINER -->
<div class="container">
    <div class="block">
        <div class="row form-horizontal">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="app-widget-tile app-widget-highlight" onclick="alert('Cash Sales')">
                    <div class="form-group">
                        <div class="col-md-4">
                            <div class="icon icon-lg">
                                <img class="img-responsive center-block" width="128" height="128"
                                     src="<?= base_url() ?>assets/img/icons/cash.png"/>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                            <div class="intval label label-success label-rounded label-bordered label-ghost">Cash Sales</div>
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="app-widget-tile app-widget-highlight" onclick="alert('Credit Sales')">
                    <div class="form-group">
                        <div class="col-md-4">
                            <div class="icon icon-lg">
                                <img class="img-responsive center-block" width="128" height="128"
                                     src="<?= base_url() ?>assets/img/icons/money-wallet.png"/>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                            <div class="intval label label-info label-rounded label-bordered label-ghost">Credit Sales</div>
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="app-widget-tile app-widget-highlight" onclick="alert('Cheque Sales')">
                    <div class="form-group">
                        <div class="col-md-4">
                            <div class="icon icon-lg">
                                <img class="img-responsive center-block" width="128" height="128"
                                     src="<?= base_url() ?>assets/img/icons/bank-check.png"/>
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                            <div class="intval label label-warning label-rounded label-bordered label-ghost">Cheque Sales</div>
                            <div class="line">
                                <div class="title"><br></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER -->