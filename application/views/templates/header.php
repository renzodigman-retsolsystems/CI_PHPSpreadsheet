<html>
    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/img/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/materialize.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url(); ?>assets/css/mystyle.css">
        <title><?= $title; ?></title>
    </head>
    <body>
        <script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/js/materialize.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/js/reroute.js"></script>
        <script>
            $(document).ready(function() {
                changePage('<?= $pageChange; ?>');

                function redirect(location) {
                    window.location.href = location;
                }
            });
            var baseurl = "<?= base_url(); ?>";
        </script>

        <?php if ($is_main_pages != 0): ?>
        <nav class="indigo darken-5" role="navigation">
            <div class="nav-wrapper container">
                <!-- <a href="#" data-activates="nav-mobile" class="button-collapse show-on-large"><i class="material-icons">menu</i></a> -->
                <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
                <a id="logo-container" href="#" class="brand-logo changePage" name="dashboard/accounts">
                    <?= $title; ?>
                </a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="#" class="changePage" name="myaccount"><?= $full_name; ?></a></li>
                    <li><a href="#" class="changePage" name="settings">Settings</a></li>
                    <li><a href="signout">Sign out</a></li>
                </ul>

                <ul id="nav-mobile" class="side-nav" style="transform: translateX(-100%);">
                    <li><a href="#" class="changePage" name="myaccount" style="margin-top:30px;"><?= $full_name; ?></a></li>
                    <li><a href="#" class="changePage" name="settings">Settings</a></li>
                    <li><a href="signout">Sign out</a></li>
                </ul>
            </div>
        </nav>

        <?php endif; ?>
