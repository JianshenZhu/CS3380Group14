
<!DOCTYPE html>
<html lang="en">
<head>
<?php include '../../inc/meta.php'; ?>
	<title>Car Listings - Missouri Rail</title>
	<script>
		
		function showHint() {
    		//var mode = 1;
    		var locData = document.getElementById("loc").value;
    		var typeData = document.getElementById("type").value;
    		var priceData = document.getElementById("price").value;
    		
    		//alert(typeData);
    		
    		if (str.length == 0) { 
        		document.getElementById("txtHint").innerHTML = "";
        		return;
    		} else {
        		var xmlhttp = new XMLHttpRequest();
        		xmlhttp.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
                		document.getElementById("txtHint").innerHTML = this.responseText;
            		}
        		};
        		//alert();
        		//xmlhttp.open("GET", "listings.php?price=" + priceData + "&loc=" + locData + "&type=" + typeData, true);
        		xmlhttp.open("GET", "listings.php?p=1", true);
        		xmlhttp.send();
    		}
		}
		
		
	</script>
</head>
<body>
<?php include '../../inc/header.php'; ?>
    <main>
        <h1>We are going to run some crazy stuff here boyy</h1>
        
		<form action="" method="post">
			<input type="hidden" name="action" value="select">
			What category would you like to search by: 
			<input type='text' id='loc' placeholder='Location' onkeyup='showHint()'>
			<input type='text' id='type' placeholder='Type' onkeyup='showHint()'>
			Pick Your Price<input type='range' id='price' min='0' max='1000'>
            <!--need to make it go on the select rather than a button
            <input type="submit" name="submit" value="Submit!">
            -->
		</form>
		
		<p>Suggestions: <span id="txtHint"></span></p>
        
    </main>
<?php include '../../inc/footer.php'; ?>
</body>
</html>

