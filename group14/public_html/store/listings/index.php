
<!DOCTYPE html>
<html lang="en">
<head>
<?php include '../../inc/meta.php'; ?>
    <link rel="shortcut icon" href="../../img/MRR.ico" />
	<title>Car Listings - Missouri Rail</title>
	<script>
		
		function showHint() {
    		//var mode = 1;
    		var locData = document.getElementById("loc").value;
    		var typeData = document.getElementById("type").value;
    		var priceData = document.getElementById("price").value;
    		
    		
        	var xmlhttp = new XMLHttpRequest();
        	xmlhttp.onreadystatechange = function() {
        		if (this.readyState == 4 && this.status == 200) {
            		document.getElementById("txtHint").innerHTML = this.responseText;
        		}
        	};
    		//alert();
    		xmlhttp.open("GET", "listings.php?price=" + priceData + "&loc=" + locData + "&type=" + typeData, true);
        	//xmlhttp.open("GET", "listings.php?p=1", true);
        	xmlhttp.send();
    		
		}
		
		
	</script>
</head>
<body>
<?php include '../../inc/header.php'; ?>
    <main>
        <h1>Here you can search the Car Listings</h1>
        <noscript>You must enable JavaScript in your browser!!</noscript>
		<form action="" method="post">
			<input type="hidden" name="action" value="select">
			<input type='text' id='loc' placeholder='Location' onkeyup='showHint()'>
			<input type='text' id='type' placeholder='Type' onkeyup='showHint()'>
			Pick Your Price<input type='range' id='price' min='0' max='1000' onchange='showHint()'>
		</form>
		
		<p><span id="txtHint"></span></p>
        
    </main>
<?php include '../../inc/footer.php'; ?>
</body>
</html>

