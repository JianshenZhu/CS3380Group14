<!DOCTYPE html>
<html lang="en">
<head>
<?php include '../../inc/meta.php'; ?>
    <link rel="shortcut icon" href="../../img/MRR.ico" />
	<title>Car Listings - Missouri Rail</title>
</head>
<body>
<?php include '../../inc/header.php'; ?>
    <main>
        <h1>Here is the Car you are searching for</h1>
        <h2>Input the number if you know the ID of the car type</h2>
        <noscript>You must enable JavaScript in your browser!!</noscript>
		<form action="cars.php" method="get">
			<input type="text" name="type" value="">
		</form>
		
		<p><span id="txtHint"></span></p>
        
    </main>
<?php include '../../inc/footer.php'; ?>
</body>
</html>

