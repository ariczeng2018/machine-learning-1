<?php

 /**
  * logic_loader.php: directs form POST data to respective python scripts.
  *
  *   Note: either the 'print', or 'echo' statments are used to return values back
  *         to ajax scripts.  For example, to send data to an ajax script we may
  *         have the following lines in this php script:
  *
  *           print json_encode(array('key' => 'msg')); 
  *
  *         The data can be accessed from the ajax script as follows:
  *
  *           console.log( data.key ); 
  *
  *   Note: to debug, or view the entire POST data array, enter the following in
  *         this php script:
  *
  *           print json_encode(array('post_array' => print_r($_POST,true)));
  *
  *         Again, the data can be accessed from the ajax script as follows:
  *
  *           console.log( data.post_array );
  *
  *   Note: performing multiple 'print json_encode( ... )' statements yields an
  *         illegal json syntax.  Specifically, it concatenates two, or more
  *         json objects. The receiving javascript file will fail overall for
  *         the ajax request, on the account of a 'Parse' error.  The receiving
  *         javascript is only allowed to receive one json representation, which
  *         may have nested json objects (not concatenated).  Therefore, only one
  *         such 'print' statement is allowed.
  *
  *   @json_encode( value ), returns the JSON representation / object of 'value'. 
  */

 /**
  * instantiate 'form_data' class
  */

 $obj = new form_data($_POST);
 $json = array();

 logic_loader($obj, $json);
 print json_encode($json);

 /**
  * form_data: 'form_data' object with properties being POST data
  *
  * @post: the post array
  */

 class form_data {
   public function __construct($post) {
     foreach($post as $key => $value) {
       $this->$key = $value;
     }
   }
 }

 /**
  * logic_loader(): receive the 'form_data' object and determines the allocation 
  *                 of its properties as parameters to respective python scripts.
  *
  * @form: contains form data defined by 'form_data' class
  * @json: 'reference' to the 'json' variable
  */

 function logic_loader($form, &$json) {
   $session_type = ($form->datalist_support) ? $form->svm_session : $form->session_type;

   if ($session_type == 'training') {
     $result = shell_command('python ../python/svm_training.py', json_encode($form));
     $arr_result = array('result' => $result);
     $json = array_merge($json, array('msg_welcome' => 'Welcome to training'), $arr_result);
   }
   elseif ($session_type == 'analysis') {
     $result = shell_command('python ../python/svm_analysis.py', json_encode($form));
     $arr_result = array('result' => $result);
     $json = array_merge($json, array('msg_welcome' => 'Welcome to analysis'), $arr_result);
   }
   else {
     print 'Error: ' . basename(__FILE__) . ', logic_loader()';
   }
 }

 /**
  * python_code(): executes python scripts using the passed in command with
  *                an optional object parameter.
  */

 function shell_command($cmd, $params = '') {
   $command = escapeshellcmd($cmd);
   $parameters = escapeshellarg($params);

   $output = exec("$command $parameters");
   return $output;
 }

?>
