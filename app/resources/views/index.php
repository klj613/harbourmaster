<?php include_once APPLICATION_PATH . '/resources/view-elements/meta-head.php'; ?>
<body>
        <?php include_once APPLICATION_PATH . '/resources/view-elements/header.php'; ?>

        <div class="container">

            <p>
                Enter some keywords below to search for.
            </p>
            <div class="row-fluid">
                <input type="text" value="" placeholder="boat tags..." class="tagsinput" id="tagsinput">
            </div>
            <div class="row">
                <div class="span12">
                    <a href="#" class="btn btn-medium btn-block btn-inverse get-boat">
                        Get My Boat
                    </a>
                </div>
            </div>
        </div>
        <!-- /container -->

        <div class="container">
            <div class="boat-out">
                <div class="control-group success">
                    <textarea class="span12"></textarea>
                    <i class="input-icon fui-check-inverted"></i>
                </div>
            </div>
            <div class="boat-out-error">
                <div class="control-group error">
                    <textarea class="span12"></textarea>
                </div>
            </div>
        </div>

        <?php include_once APPLICATION_PATH . '/resources/view-elements/footer.php'; ?>
    </body>
</html>