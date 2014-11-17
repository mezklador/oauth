<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Title</title>
		<meta charset="UTF-8">
		<meta name=description content="">
		<meta name=viewport content="width=device-width, initial-scale=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- Bootstrap CSS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" media="screen">
	</head>
	<body>
		<div class="container">
            <h1>Types d'algorithmes disponibles pour hashage de mot de passe</h1>
            <?php $data = "hello";  ?>
            <p>Mot Hashé: <?= $data; ?></p>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <td>Algos</td>
                    <td>Length</td>
                    <td>Result</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach (hash_algos() as $v) {
                    $r = hash($v, $data, false);
                    printf("<tr><td>%-12s</td><td>%1d</td><td>%s</td></tr>", $v, strlen($r), $r);
                }
                ?>
                </tbody>
            </table>
		</div>

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</body>
</html>
