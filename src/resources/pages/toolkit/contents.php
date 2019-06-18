<?PHP

    $contents = preg_replace('~\R~u', "\n", file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'toolkit.sh'));
    print($contents);