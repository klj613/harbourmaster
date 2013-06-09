<?php include_once APPLICATION_PATH . '/resources/view-elements/meta-head.php'; ?>
<body>
        <?php include_once APPLICATION_PATH . '/resources/view-elements/header.php'; ?>

        <div class="container">

            <div class="row">
                <div class="span12">
                    <input type="text" value="" placeholder="boat tags..." class="span12">
                </div>
            </div>

            <div class="row">
                <div class="span6">
                    <a href="#" class="btn btn-medium btn-block btn-inverse get-boat">
                        Get My Boat
                    </a>
                </div>
                <div class="span6">
                    <a href="#" class="btn btn-medium btn-block btn-info random-boat">
                        Random Boat
                    </a>
                </div>
            </div>
        </div>
        <!-- /container -->

        <?php include_once APPLICATION_PATH . '/resources/view-elements/footer.php'; ?>
    </body>
</html>