<?php
//error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('UTC');

require_once "WindowsAzure/WindowsAzure.php";
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=phpbrno;AccountKey=2Rtc+yDzBMaLrcONQRXvWcMPNWT9fP8QE69stQAS7lEcENRjN0rTJNa3OjnnxouyiOlqy+vDuei32KaQd7hMxA==";

$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString); 
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString); 
$queueRestProxy = ServicesBuilder::getInstance()->createQueueService($connectionString);


?>
