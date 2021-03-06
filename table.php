<?php
error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('UTC');
//ini_set("display_errors", 1);

require_once "vendor/autoload.php";
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

use WindowsAzure\Table\Models\Entity;
use WindowsAzure\Table\Models\EdmType;

$connectionString = getenv("CUSTOMCONNSTR_blob");
$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString); 

// table
try {
  if($tableRestProxy->getTable("mytable")===null)
  {
    $tableRestProxy->createTable("mytable");
  }
  
} catch(ServiceException $e){
  // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179438.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}

$entity = new Entity();
$entity->setPartitionKey("tasksBrno");
$entity->setRowKey("1");
$entity->addProperty("Description", null, "Take out the trash.");
$entity->addProperty("DueDate",
                     EdmType::DATETIME,
                     new DateTime("2016-11-05T08:15:00-08:00"));
$entity->addProperty("Location", EdmType::STRING, "Home");

try{
    $tableRestProxy->insertOrMergeEntity("mytable", $entity);
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179438.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}

$filter = "PartitionKey eq 'tasksBrno'";

try {
  $result = $tableRestProxy->queryEntities("mytable", $filter);
  //$result = $tableRestProxy->queryEntities("mytable");
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}

$entities = $result->getEntities();

foreach($entities as $entity){
  echo $entity->getPartitionKey().":".$entity->getRowKey()."<br />";
  $location = $entity->getProperty("Location")->getValue();
  echo $location."<br />";
  $description = $entity->getProperty("Description")->getValue();
  echo $description."<br />";
}

?>
