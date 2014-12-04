<?php
    require_once('../../../mysqli_connect_inspires.php');
?>
<html>
    <head>
        <title>Upload a product</title>
        <script type="text/javascript">
		function showHide(box,id1){
			var elm1 = document.getElementById(id1);
			elm1.style.display = box.checked? "":"none";
		}
		</script>
    </head>
    <body>
        <div>
            <h1>Enter a Product</h1>
 
            <p>
                <a href="./">View products</a>
            </p>
 
            <form method="post" action="process.php" enctype="multipart/form-data">
                <div>
                <table>
                <tr><td>Add images? </td><td><input type="checkbox" name="img_added" value="1" onClick="showHide(this,'img1');showHide(this,'img2');showHide(this,'img3');showHide(this,'img4');showHide(this,'img5');showHide(this,'img6');" /></td></tr>
                <tr id="img1" style="display:none"><td>Choose main image: </td><td><input type="file" name="image" /></td></tr>
                <tr id="img2" style="display:none"><td>Optional image 1: </td><td><input type="file" name="slide0" /></td></tr>
                <tr id="img3" style="display:none"><td>Optional image 2: </td><td><input type="file" name="slide1" /></td></tr>
                <tr id="img4" style="display:none"><td>Optional image 3: </td><td><input type="file" name="slide2" /></td></tr>
                <tr id="img5" style="display:none"><td>Optional image 4: </td><td><input type="file" name="slide3" /></td></tr>
                <tr id="img6" style="display:none"><td>Optional image 5: </td><td><input type="file" name="slide4" /></td></tr>
                <tr><td>Enter Product name: </td><td><input name="name" type="text" size="35" maxlength="50" /></td></tr>
                <tr><td>Enter Price: </td><td>&pound;<input name="price" type="text" size="35" maxlength="50" /></td></tr>
                <tr><td>Enter Description: </td><td><textarea name="desc" cols="35" rows="5"></textarea></td></tr>
                <tr><td>Enter Category(s): </td><td>
<select multiple="multiple" name="category[]" id="catOpts">
<?php 
$query = "SHOW COLUMNS FROM products LIKE 'category'";
$result=mysqli_query($dbc,$query);
if(mysqli_num_rows($result)>0){
	$row=mysqli_fetch_row($result);
	$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
}

foreach ($options as $opt){
	echo '<option>' . $opt . '</option>';
}
?>
</select>



</td></tr>

<tr><td>Enter Colour(s): </td><td>
<select multiple="multiple" name="colours[]" id="colOpts">
<?php 
$query = "SHOW COLUMNS FROM products LIKE 'colour_options'";
$result=mysqli_query($dbc,$query);
if(mysqli_num_rows($result)>0){
$row=mysqli_fetch_row($result);
$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
}

foreach ($options as $opt){
	echo '<option>' . $opt . '</option>';
}
?>
</select>

	  
</td></tr>


<tr><td>Enter Sizes(s): </td><td>
<select multiple="multiple" name="sizes[]" id="sizeOpts">
<?php 
$query = "SHOW COLUMNS FROM products LIKE 'size_options'";
$result=mysqli_query($dbc,$query);
if(mysqli_num_rows($result)>0){
$row=mysqli_fetch_row($result);
$options=explode("','",preg_replace("/(enum|set)\('(.+?)'\)/","\\2",$row[1]));
}

foreach ($options as $opt){
	echo '<option>' . $opt . '</option>';
}

echo '</select>';
?>
	  
</td></tr>
<tr><td>On Sale? </td><td><input name="on_sale" type="checkbox" value=1 onClick="showHide(this,'rf');" /></td></tr>
<tr id="rf" style="display:none"><td>Original Price:<br />(Reduced from)</td><td>&pound;<input name="reduced_from" type="textbox" /></td></tr>

                <tr><td>Number in stock: </td><td><input name="in_stock" type="text" size="35" maxlength="50" id="origStock" /></td></tr>
                <tr><td></td><td><a href="javascript:changeText(); prepareStockArray();">Prepare/Change Stock Options</a></td></tr>
                <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                <tr><td colspan="2" id="numStock">&nbsp;</td></tr>
                


<script type="text/javascript">

function selectedItems(ob) {
	selected = new Array(); 
	for (var i = 0; i < ob.options.length; i++) {
		if (ob.options[i].selected){
			selected.push(ob.options[i].value);
		}
	}
	return selected;
}

function prepareStockArray() {
	var stock = new Array();
	for(var i = 0; i <document.getElementsByName('in_stck').length; i++) {
		stock.push(document.getElementsByName('in_stck').item(i).value);
	}
	document.getElementById("btn").disabled = false;
	document.getElementById('stockA').value = stock.toString();
	//return(stock.toString());
}

function disableBtn() {
	document.getElementById("btn").disabled = true;
}

function changeText(){
	var col;
	var siz;
	var output = "<table>";
	if((selectedItems(document.getElementById('colOpts')).length > 0) && (selectedItems(document.getElementById('sizeOpts')).length > 0)) {
		for(col in selectedItems(document.getElementById('colOpts'))) {
			for(siz in selectedItems(document.getElementById('sizeOpts'))) {
				output += "<tr><td>" + selectedItems(document.getElementById('colOpts'))[col] + ", " + selectedItems(document.getElementById('sizeOpts'))[siz] + "</td><td><input name=\"in_stck\" type=\"text\" size=\"35\" maxlength=\"50\" value=\"" + document.getElementById('origStock').value + "\" onBlur=\"javascript:disableBtn();\" /></td></tr>";
			}
		}
	} else if(selectedItems(document.getElementById('colOpts')).length > 0) {
		for(col in selectedItems(document.getElementById('colOpts'))) 
		{
			output += "<tr><td>" + selectedItems(document.getElementById('colOpts'))[col] + "</td><td><input name=\"in_stck\" type=\"text\" size=\"35\" maxlength=\"50\" value=\"" + document.getElementById('origStock').value + "\" onBlur=\"javascript:disableBtn();\" /></td></tr>";
		}
	} else if(selectedItems(document.getElementById('sizeOpts')).length > 0) {
		for(col in selectedItems(document.getElementById('sizeOpts'))) 
		{
			output += "<tr><td>" + selectedItems(document.getElementById('sizeOpts'))[col] + "</td><td><input name=\"in_stck\" type=\"text\" size=\"35\" maxlength=\"50\" value=\"" + document.getElementById('origStock').value + "\" onBlur=\"javascript:disableBtn();\" /></td></tr>";
		}
	}
	output += '<tr><td>&nbsp;</td><td>&nbsp;</td></tr>';
	output += '<tr><td>Stock Array</td><td><a href="javascript:prepareStockArray();">Assign Stock Array</a></td></tr>';
	output += '<tr><td>Stock Array</td><td><input id="stockA" name="stockA" type="text" size="35" readonly /></td></tr></table>';
	
	document.getElementById('numStock').innerHTML = output;
	document.getElementById("btn").disabled = false;
}




</script>


                
                </table>
                <input type="reset" value="Clear Form" id="clear" onClick="javascript:document.getElementById('numStock').innerHTML = ''" />
                    <input type="submit" value="Upload Product(s)" id="btn" disabled="disabled" />
                </div>
            </form>
        </div>
    </body>
</html>