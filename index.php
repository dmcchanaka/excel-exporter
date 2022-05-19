<?php 
session_start();
require_once './library/config.php';
$connection = new createConnection();
$connection->connectToDatabase();

$query = "SELECT * FROM excel_sheet";
$result = mysqli_query($connection->myconn, $query) or die(mysqli_error($connection->myconn));
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Excel Import</title>
  </head>
  <body>
  	<div class="container"><br/>
	  	<div class="card">
			<div class="card-body">
				<h5 class="card-title text-center">Simple Excel Export module</h5>
                <div class="alert alert-success alert-dismissible fade show" role="alert" id="success" style="display: none;">
                    <strong>Success!</strong> Done
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error" style="display: none;">
                    <strong>Opps!</strong> Please try again
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
				<form class="row g-3" method="POST" action="uploadexcel.php" enctype="multipart/form-data">
					
					<div class="col-12" style="text-align: center;">
                        <?php if ($result->num_rows > 0) { ?>
                            <button type="button" name="export" onclick="export_excel();" class="btn btn-success">EXPORT</button>
                        <?php } ?>
					</div>
				</form>
			</div>
		</div>
	</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
	function export_excel(){

        $.ajax({
            url: 'generate_excel.php',
            data: {},
            success: function(data) {
                var arr = JSON.parse(data);
                if(arr.status == '1'){
                    $('#success').show('slow');
                    $('#error').hide('slow');
                    window.open(arr.url,'_blank' );
                } else {
                    $('#success').hide('slow');
                    $('#error').show('slow');
                }
            }
        })
	}
</script>
  </body>
</html>
<?php 
?>