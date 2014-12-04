if (!Array.prototype.indexOf) {
  Array.prototype.indexOf = function (obj) {
    for (var i = 0; i < this.length-1; i++) {
      if (this[i] == obj) {
        return i;
      }
    }
  }
}
if (!Array.prototype.lastIndexOf) {
  Array.prototype.lastIndexOf = function (obj) {
    for (var i = this.length-1; i > this.indexOf(obj); i--) {
      if (this[i] == obj) {
        return i;
      }
    }
  }
}

function getElementsByClass(searchClass,node,tag) {
  var classElements = new Array();
  if (node == null)
    node = document;
  if (tag == null)
    tag = '*';
  var els = node.getElementsByTagName(tag);
  var elsLen = els.length;
  var pattern = new RegExp("(^|\\s)"+searchClass+"(\\s|$)");
  for (i = 0, j = 0; i < elsLen; i++) {
    if (pattern.test(els[i].className) ) {
      classElements[j] = els[i];
      j++;
    }
  }
  return classElements;
}



//change size with a colour selection
function OnChangeSizeC(dropdown, other)
{
	var myindex  = dropdown.selectedIndex;
	var SelValue = dropdown.options[myindex].value;
	var other_value = other.options[other.selectedIndex].value;

	
	var n;
	var c;
	var s;
	
			for(c=stock[0].indexOf(other_value); c<=stock[0].lastIndexOf(other_value); c++){
				if(stock[0][c] == other_value){
					for(s=stock[1].indexOf(SelValue); s<=stock[1].lastIndexOf(SelValue); s++){
						if(stock[1][s] == SelValue){
							if((c==s)){
								if(stock[2][s] == 0){
									
									document.getElementById('stok').innerHTML = "(out of stock)";
									return(stock[2][s]);
								} else {
									document.getElementById('stok').innerHTML = "&nbsp;";
								
									return(stock[2][s]);
								}
							}
						}
					}
				}
			}
		
	
	//document.getElementsByName('stok')[stock[3].indexOf(item_name) + num_products].innerHTML = "<p>" + stock[2][s] + "</p>";
    return(0);
}

//change colour with a size selection
function OnChangeColourS(dropdown, other)
{
	var myindex  = dropdown.selectedIndex;
	var SelValue = dropdown.options[myindex].value;
	var other_value = other.options[other.selectedIndex].value;
	
	var c;
	var s;
	

			for(c=stock[0].indexOf(SelValue); c<=stock[0].lastIndexOf(SelValue); c++){
				if(stock[0][c] == SelValue){
					for(s=stock[1].indexOf(other_value); s<=stock[1].lastIndexOf(other_value); s++){
						if(stock[1][s] == other_value){
							if((c==s)){
								if(stock[2][s] == 0){
									document.getElementById('stok').innerHTML = "(out of stock)";
									return(stock[2][s]);
								} else {
									document.getElementById('stok').innerHTML = "&nbsp;";
									return(stock[2][s]);
								}
							}
						}
					}
				}
			}

	//document.getElementsByName('stok')[stock[3].indexOf(item_name) + num_products].innerHTML = "<p>" + stock[2][s] + "</p>";
    return(0);
}

//Just size selection
function OnChangeSize(dropdown)
{
	var myindex  = dropdown.selectedIndex;
	var SelValue = dropdown.options[myindex].value;
	
	var s;
			for(s=stock[1].indexOf(SelValue); s<=stock[1].lastIndexOf(SelValue); s++){
				if(stock[1][s] == SelValue){
					if(stock[s] == item_name){
					if(stock[2][s] == 0){
						document.getElementById('stok').innerHTML = "(out of stock)";
						return(stock[2][s]);
					} else {
						document.getElementById('stok').innerHTML = "&nbsp;";
						return(stock[2][s]);
					}
					}
				}
			}
	//document.getElementsByName('stok')[stock[3].indexOf(item_name) + num_products].innerHTML = "<p>" + stock[2][s] + "</p>";
    return true;
}

//Just colour selection
function OnChangeColour(dropdown)
{
	var myindex  = dropdown.selectedIndex;
	var SelValue = dropdown.options[myindex].value;
	var s;
			for(s=stock[0].indexOf(SelValue); s<=stock[0].lastIndexOf(SelValue); s++){
				if(stock[0][s] == SelValue){
					if(stock[s] == item_name){
					if(stock[2][s] == 0){
						document.getElementById('stok').innerHTML = "(out of stock)";
						return(stock[2][s]);
					} else {
						document.getElementById('stok').innerHTML = "&nbsp;";
						return(stock[2][s]);
					}
				}
			}
		}
	
	//document.getElementsByName('stok')[stock[3].indexOf(item_name) + num_products].innerHTML = "<p>" + stock[2][s] + "</p>";
    return true;
}



function noError(){return true;}
//window.onerror = noError;

