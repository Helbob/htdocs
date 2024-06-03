<?php

  require_once __DIR__.'/../_.php';

  session_destroy();
  header('Location: /');
  exit();
?>