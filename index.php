<?php
  require_once 'lib/limonade.php';

  dispatch( '/', 'hello' );
    function hello()
    {
      return 'hello world';
    }

    run();
?>
