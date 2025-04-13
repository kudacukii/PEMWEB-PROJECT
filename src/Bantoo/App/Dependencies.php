<?php

function dependencies() {
  return  [
    __DIR__ . '/Utils/Http.php',
    __DIR__ . '/Router/Router.php',
    __DIR__ . '/Database/Mysql.php',
    __DIR__ . '/Controller/Info.php',
    __DIR__ . '/Controller/User.php',
    __DIR__ . '/Controller/Campaign.php',
  ];
};
