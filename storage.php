<?php
//error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('UTC');

require_once "WindowsAzure/WindowsAzure.php";
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
use WindowsAzure\Blob\Models\ListContainersOptions;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=phpbrno;AccountKey=2Rtc+yDzBMaLrcONQRXvWcMPNWT9fP8QE69stQAS7lEcENRjN0rTJNa3OjnnxouyiOlqy+vDuei32KaQd7hMxA==";
$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString); 

// OPTIONAL: Set public access policy and metadata.
// Create container options object.
$createContainerOptions = new CreateContainerOptions(); 

// Set public access policy. Possible values are 
// PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
// CONTAINER_AND_BLOBS: full public read access for container and blob data.
// BLOBS_ONLY: public read access for blobs. Container data not available.
// If this value is not specified, container data is private to the account owner.
$createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

// Set container metadata
$createContainerOptions->addMetaData("key1", "value1");
$createContainerOptions->addMetaData("key2", "value2");

try {
  // Create container.
  $options = new ListContainersOptions();
  $options->setPrefix('mycontainer');
  $containers = $blobRestProxy->listContainers($options);
  if($containers===null)
  {
    $blobRestProxy->createContainer("mycontainer", $createContainerOptions);
  }
  
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}

$content = fopen("david_bures.jpg", "r");
$blob_name = "david_bures.jpg";

try {
    //Upload blob
    $blobRestProxy->createBlockBlob("mycontainer", $blob_name, $content);
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
echo('blob uploaded<br />');

try {
    // List blobs.
    $blob_list = $blobRestProxy->listBlobs("mycontainer");
    $blobs = $blob_list->getBlobs();

    foreach($blobs as $blob)
    {
        echo $blob->getName().": ".$blob->getUrl()."<br />";
        echo "<img src='".$blob->getUrl()."'/><br />";
        
    }
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here:
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}


?>
