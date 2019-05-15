<!doctype html>
<html lang="<?PHP \DynamicalWeb\HTML::print(APP_LANGUAGE_ISO_639); ?>">
    <head>
        <?PHP \DynamicalWeb\HTML::importSection('header'); ?>
        <title><?PHP \DynamicalWeb\HTML::print(TEXT_PAGE_TITLE); ?></title>
    </head>

    <body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <?PHP \DynamicalWeb\HTML::importSection('sideview'); ?>
            <?PHP \DynamicalWeb\HTML::importSection('navigation'); ?>

            <div class="right_col" role="main">

            </div>

            <?PHP \DynamicalWeb\HTML::importSection('footer'); ?>
            <!-- /footer content -->
        </div>
    </div>

    <?PHP \DynamicalWeb\HTML::importSection('js_scripts'); ?>

    </body>
</html>
