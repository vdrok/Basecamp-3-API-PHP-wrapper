<?php
  require_once ('./config.php');
  require_once("./common.php");
  header('Content-Type: application/json');


  $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $path_only = substr($path, 10);

if($path_only == '/authorization/token') {
	$code =  $_REQUEST['code'];
  	$data = array('type' =>'web_server' , 'client_id' => $client_id, 'redirect_uri' => $redirect_uri, 'client_secret' => $client_secret, 'code' => $code );
  	$result = CallAPI('POST', $launchpad, $data);
  	echo $result;
  	exit();
  }

  $request_headers=getallheaders();
  $authorized = $request_headers["Authorization"];
  $result = array();
  if(stripos($authorized, "Bearer ") !== 0){
  	$result = ["status"=> "fail", "error_code"=>400, "error_message"=>"Missed Token"];
  	echo json_encode($result);
  	exit;
  	
  }
  $token = substr ( $authorized , 7 );

  try {
  		$client = createClient($accountId, $appName, $token);

  		$data = ""; $params = array();
    	if ($_SERVER['REQUEST_METHOD'] === 'POST') {  //// Create new ToDoLists or Message
  		
  		switch ($path_only) {
  			////// ===== Todo List =========== //////
  			case '/todolist':
  				$projectId = $_REQUEST['projectid'];
				$todosetId = $_REQUEST['todosetid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$todosetId || !$params['name'])
					missingParam();
				$data = $client->todolists()->create($projectId, $todosetId, $params);
  				break;
  			////// ==== Todo ===============/////
  			case '/todo':
  				$projectId = $_REQUEST['projectid'];
				$todolistId = $_REQUEST['todolistid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$todolistId || !$params['content'])
					missingParam();
				$data = $client->todos()->create($projectId, $todolistId, $params);
  				break;
  			case '/completion':
  				$projectId = $_REQUEST['projectid'];
				$todoId = $_REQUEST['todoid'];
				if(!$projectId || !$todoId)
					missingParam();
				$data = $client->todos()->complete($projectId, $todoId);
  				break;

  			////// ==== Messages =============////
  			case '/message':
  				$projectId = $_REQUEST['projectid'];
				$messageboardId = $_REQUEST['messageboarid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				$params['status'] = 'active';
				if(!$projectId || !$messageboardId || !$params['subject'])
					missingParam();
				$data = $client->messages()->create($projectId, $messageboardId, $params);
  				break;
  			default:
  				missingPath();
  				break;
  		}
    
	} else if($_SERVER['REQUEST_METHOD'] === 'GET') {  /// get all and each Todolist and message 

		switch ($path_only) {
			/////====== Projects =======///////
			case '/projects':
				if(@$_REQUEST['projectid']) {
					$projectId = $_REQUEST['projectid'];
					$data = $client->projects()->show($projectId);					
				} else {
					$data = $client->projects()->active();
					header('X-Total-Count:'.$client->total_count);
				}
				break;
			////====== Todo List =======/////////
			case '/todoset':
				$projectId = $_REQUEST['projectid'];
				$todosetId = $_REQUEST['todosetid'];
				if(!$projectId || !$todosetId)
					missingParam();
				$data = $client->todos()->showTodoset($projectId, $todosetId);
				break;
			case '/todolists':
				$projectId = $_REQUEST['projectid'];
				$todosetId = $_REQUEST['todosetid'];
				if(@$_REQUEST['status'])
					$params['status'] = $_REQUEST['status'];
				if(@$_REQUEST['page'])
					$params['page'] = $_REQUEST['page'];
				if(!$projectId || !$todosetId)
					missingParam();
				$data = $client->todolists()->allByTodoset($projectId, $todosetId, $params);
				header('X-Total-Count:'.$client->total_count);
				break;
			case '/todolist':
				$projectId = $_REQUEST['projectid'];
				$todolistId = $_REQUEST['todolistid'];
				if(!$projectId || !$todolistId)
					missingParam();
				$data = $client->todolists()->show($projectId, $todolistId);	
				break;
			////////// ===== To-dos =============///////
			case '/todos':
				$projectId = $_REQUEST['projectid'];
				$todolistId = $_REQUEST['todolistid'];
				if(@$_REQUEST['status'])
					$params['status'] = $_REQUEST['status'];
				if(@$_REQUEST['completed'])
					$params['completed'] = $_REQUEST['completed'];
				if(@$_REQUEST['page'])
					$params['page'] = $_REQUEST['page'];
				if(!$projectId || !$todolistId)
					missingParam();
				$data = $client->todos()->allByTodolist($projectId, $todolistId, $params);
				header('X-Total-Count:'.$client->total_count);
				break;
			case '/todo':
				$projectId = $_REQUEST['projectid'];
				$todoId = $_REQUEST['todoid'];
				if(!$projectId || !$todoId)
					missingParam();
				$data = $client->todos()->show($projectId, $todoId);
				break;
			///////// ========= Message ========= //////
			 case '/messages':
			 	$projectId = $_REQUEST['projectid'];
				$messageboardId = $_REQUEST['messageboardid'];
				if(@$_REQUEST['page'])
					$params['page'] = $_REQUEST['page'];
				if(!$projectId || !$messageboardId)
					missingParam();
				$data = $client->messages()->allByMessages($projectId, $messageboardId, $params);
				header('X-Total-Count:'.$client->total_count);
			 	break;
			 case '/message':
			 	$projectId = $_REQUEST['projectid'];
				$messageId = $_REQUEST['messageid'];
				if(!$projectId || !$messageId)
					missingParam();
				$data = $client->messages()->show($projectId, $messageId);
			 		break;	
			default:
				missingPath();
				break;
		}

	} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') { /////Update

  		switch ($path_only) {
  			///////// ============== Todo Lists ==============///////
  			case '/todolist':
  				$projectId = $_REQUEST['projectid'];
				$todolistId = $_REQUEST['todolistid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$todolistId || !$params['name'])
					missingParam();
				$data = $client->todolists()->update($projectId, $todolistId, $params);
  				break;
  			////// ==== Todo ===============/////
  			case '/todo':
  				$projectId = $_REQUEST['projectid'];
				$todoId = $_REQUEST['todoid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$todoId || !$params['content'])
					missingParam();
				$data = $client->todos()->update($projectId, $todoId, $params);
  				break;
  			case '/position':
  				$projectId = $_REQUEST['projectid'];
				$todoId = $_REQUEST['todoid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$todoId || !$params['position'])
					missingParam();
				$data = $client->todos()->position($projectId, $todoId, $params);
  				break;
  			/////// ============= Messages ============= /////////
  			case '/message':
  				$projectId = $_REQUEST['projectid'];
				$messageId = $_REQUEST['messageid'];
				$content = trim(file_get_contents("php://input"));
				$params = json_decode($content, true);
				if(!$projectId || !$messageId || !$params['subject'])
					missingParam();
				$data = $client->messages()->update($projectId, $messageId, $params);
  				break;
  			default:
  				missingPath();
  				break;
  			}
  			  	
	} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { /////Delete
		switch ($path_only) {
  			///////// ============== Todo ==============///////
			case '/uncompletion':
  				$projectId = $_REQUEST['projectid'];
				$todoId = $_REQUEST['todoid'];
				if(!$projectId || !$todoId)
					missingParam();
				$data = $client->todos()->uncomplete($projectId, $todoId);
  				break;
  			default:
  				missingPath();
  				break;
		}

	}
	successResponse($data);
  } catch( Exception $e) {
  	$result = ["status" => "fail", "error_code" => 403, "error_message" => $e->getMessage()];
  	echo json_encode($result);
  	exit;
  }

?>