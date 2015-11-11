<?php
//error_reporting(E_ERROR | E_PARSE);
date_default_timezone_set('UTC');

require_once "vendor/autoload.php";
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

use WindowsAzure\Queue\Models\CreateQueueOptions;
use WindowsAzure\Queue\Models\PeekMessagesOptions;
use WindowsAzure\Queue\Models\ListQueuesOptions;

$connectionString = getenv("CUSTOMCONNSTR_blob");
$queueRestProxy = ServicesBuilder::getInstance()->createQueueService($connectionString);

$createQueueOptions = new CreateQueueOptions();
$createQueueOptions->addMetaData("key1", "value1");
$createQueueOptions->addMetaData("key2", "value2");

try {
  	// Create queue.
  	//$options = new ListQueuesOptions();
	//$options->setPrefix('myqueue');
	//$queues = $queueRestProxy->listQueues($options);
	//if($queues===null)
	{
		$queueRestProxy->createQueue("myqueue", $createQueueOptions);
		echo "myqueue created<br />";
	}
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}

try {
  // Create message.
  $queueRestProxy->createMessage("myqueue", "Hello World!");
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}
// peek message without removing
// OPTIONAL: Set peek message options.
$message_options = new PeekMessagesOptions();
$message_options->setNumberOfMessages(1); // Default value is 1.

try {
  $peekMessagesResult = $queueRestProxy->peekMessages("myqueue", $message_options);
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}

$messages = $peekMessagesResult->getQueueMessages();

// View messages.
$messageCount = count($messages);
if($messageCount <= 0){
  echo "There are no messages.<br />";
}
else{
  foreach($messages as $message)  {
    echo "Peeked message:<br />";
    echo "Message Id: ".$message->getMessageId()."<br />";
    echo "Date: ".date_format($message->getInsertionDate(), 'Y-m-d')."<br />";
    echo "Message text: ".$message->getMessageText()."<br /><br />";
  }
}
// Your code removes a message from a queue in two steps. First, you call QueueRestProxy->listMessages, which makes the message invisible to any other code reading from the queue. By default, this message will stay invisible for 30 seconds (if the message is not deleted in this time period, it will become visible on the queue again). To finish removing the message from the queue, you must call QueueRestProxy->deleteMessage.
// Get message.
$listMessagesResult = $queueRestProxy->listMessages("myqueue");
$messages = $listMessagesResult->getQueueMessages();
$message = $messages[0];

// Process message

// Get message Id and pop receipt.
$messageId = $message->getMessageId();
$popReceipt = $message->getPopReceipt();

try {
  // Delete message.
  $queueRestProxy->deleteMessage("myqueue", $messageId, $popReceipt);
  echo "message deleted<br />";
} catch(ServiceException $e){
  $code = $e->getCode();
  $error_message = $e->getMessage();
  echo $code.": ".$error_message."<br />";
}

?>
