
function add_market_meta(){
    var meta_block = document.getElementById('WoocomerceAdvanceWPShowMetaBox'), fragment, input, div;
    
    fragment = document.createElement("div");
    fragment.id = "MarkeID"+i;
    fragment.appendChild(document.createTextNode("MarketName "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "MarketName_N" + i;


    fragment.appendChild(input);    
    fragment.appendChild(document.createElement("br"));
    
    fragment.appendChild(document.createTextNode("ProdName "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "ProdName_N" + i;
    fragment.appendChild(input);
    fragment.appendChild(document.createElement("br"));
    

	input = document.createElement("input");
	input.type = "button";
	input.value = "Remove";
	input.setAttribute("onclick", "remove_market_meta('MarkeID"+ i +"')");

	fragment.appendChild(input);
    fragment.appendChild(document.createElement("hr"));
    i++;
    document.getElementById('count_markets').value = i;
    meta_block.appendChild(fragment);
};


function remove_market_meta(_id){
	var elem = document.getElementById(_id);
	elem.parentNode.removeChild(elem);
}

