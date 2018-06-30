<?php
	 require_once("../config.php");
	$todos = $client->Todos()->show($_GET['pid'], $_GET['tid']);

	$n = count($todos)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>jQuery Pagination plugin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="../js/jquery.twbsPagination.js" type="text/javascript"></script>
</head>
<body>
	<div class="container">
	    <div class="btn-group btn-group-lg">
	      <button type="button" class="btn btn-primary">Messages</button>
	      <button type="button" class="btn btn-primary">Todos</button>
	      <button type="button" class="btn btn-primary">Docs and Files</button>
	    </div>

	    <div class="container-fluid">
	    	<?php
	    		$html = "";
	    		for($i=0; $i<$n; $i++){
	    			$html .= ' <div class="row">';
	    			$html .= '<div class="col-sm-3 col-md-6 col-lg-4 col-xl-2">';
	    			$html .= '<a href="javascript:goProject('.$projects[$i]->id.')">'.$projects[$i]->name.'</a></div>';
	    			$html .= '<div class="col-sm-9 col-md-6 col-lg-8 col-xl-10">';
	          		$html .= '<a href="javascript:goTodo('.$projects[$i]->id.','.$projects[$i]->dock[2]->id.')">Todos</a></div>';
	      			$html .= '</div>';
	    		}
	    		echo $html;
	    	?>
	    </div>
	   <nav aria-label="Page navigation">
	        <ul class="pagination" id="pagination"></ul>
	    </nav>
	</div>
<script type="text/javascript">
    $(function () {
        window.pagObj = $('#pagination').twbsPagination({
            totalPages: 35,
            visiblePages: 10,
            onPageClick: function (event, page) {
                
                    console.log(page);
                
            }
        }).on('page', function (event, page) {
            console.info(page + ' (from event listening)');
        });
    });
    function goProject(id){

    }
    function goTodo(pid, tid) {
    	window.location="./View/todos.php?pid="+pid+"&tid"+tid;
    }
</script>
</body>
</html>
