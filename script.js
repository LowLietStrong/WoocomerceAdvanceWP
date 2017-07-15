


function add_market_meta(){
    var meta_block = document.getElementById('WoocomerceAdvanceWPShowMetaBox'), fragment, input, div;
    
    fragment = document.createElement("div");
    fragment.id = "MarkeID"+i;
    sub[i] = [];



    fragment.appendChild(document.createTextNode(" MarketIcon Url: "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "shop_image" + i;
    input.id   = "shop_image" + i;
    input.size = "90";
    fragment.appendChild(input);  


    fragment.appendChild(document.createTextNode(" OR "));


    input = document.createElement("input");
    input.type = "button";
    input.value = "Upload";
    input.setAttribute("class", "button");
    input.setAttribute("onclick", "image_upload("+ i+")");
    fragment.appendChild(input); 


    fragment.appendChild(document.createElement("br"));


    fragment.appendChild(document.createTextNode(" Market Url: "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "MarketName_N" + i;
    input.size = "90";
    fragment.appendChild(input);    


    fragment.appendChild(document.createTextNode(" ProdName "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "ProdName_N" + i;
    fragment.appendChild(input);
    fragment.appendChild(document.createElement("br"));
    fragment.appendChild(document.createElement("br"));


    fragment.appendChild(document.createTextNode(" ProdPrice "));
    input = document.createElement("input");
    input.type = "number";
    input.name = "ProdPrice_N" + i;
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" ProdWeight "));
    input = document.createElement("input");
    input.type = "number";
    input.name = "ProdWeight_N" + i;
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" ProdInfo "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "ProdInfo_N" + i;
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" InStock "));
    input = document.createElement("input");
    input.type = "checkbox";
    input.name = "InStock_N" + i;
    fragment.appendChild(input);
    fragment.appendChild(document.createTextNode(" "));


    input = document.createElement("input");
    input.type = "button";
    input.value = "Add Subtype";
    input.setAttribute("class", "button button-small");
    input.setAttribute("onclick", "add_mainsubtupe_meta("+i+")");
    fragment.appendChild(input);
    submain[i] = 0;



    fragment.appendChild(document.createElement("br"));


    div = document.createElement("div");
    div.id = "MarkeID_SubtypeMain"+i;
    fragment.appendChild(div);


    input = document.createElement("input");
    input.type = "hidden";
    input.value = "0";
    input.id   = "count_subtypemain_N" + i;
    input.name = "count_subtypemain_N" + i;
    fragment.appendChild(input);

    fragment.appendChild(document.createElement("br"));
    
    div = document.createElement("div");
    div.id = "MarkeID_ShowAlt"+i;
    fragment.appendChild(div);


    input = document.createElement("input");
    input.type = "hidden";
    input.value = "0";
    input.id   = "count_alt_N" + i;
    input.name = "count_alt_N" + i;
    fragment.appendChild(input);


	input = document.createElement("input");
	input.type = "button";
    input.value = "Remove";
    input.setAttribute("class", "button");
	input.setAttribute("onclick", "remove_market_meta('MarkeID"+ i +"')");
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" "));


    input = document.createElement("input");
    input.type = "button";
    input.value = "Add product";
    input.setAttribute("class", "button");
    input.setAttribute("onclick", "add_product_meta("+i+")");
    product[i] = 0;
	fragment.appendChild(input);


    fragment.appendChild(document.createElement("br"));
    fragment.appendChild(document.createElement("br"));
    fragment.appendChild(document.createElement("hr"));
    fragment.appendChild(document.createElement("hr"));
    fragment.appendChild(document.createElement("br"));


    i++;
    document.getElementById('count_markets').value = i;
    meta_block.appendChild(fragment);
};


function remove_market_meta(_id){
	var elem = document.getElementById(_id);
	elem.parentNode.removeChild(elem);
}



function add_product_meta(_i){
    var meta_block = document.getElementById('MarkeID_ShowAlt'+_i), fragment, input, div;

    fragment = document.createElement("div");

    fragment.id = "MarkeID" +_i +"_Alt" +product[_i];

    sub[_i][product[_i]] = 0;


    fragment.appendChild(document.createTextNode(" ProdPrice "));
    input = document.createElement("input");
    input.type = "number";
    input.name = "ProdPrice_N" +_i +"_Alt" +product[_i];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" ProdWeight "));
    input = document.createElement("input");
    input.type = "number";
    input.name = "ProdWeight_N" +_i +"_Alt" +product[_i];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" ProdInfo "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "ProdInfo_N" +_i +"_Alt" +product[_i];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" InStock "));
    input = document.createElement("input");
    input.type = "checkbox";
    input.name = "InStock_N" +_i +"_Alt" +product[_i];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" "));


    input = document.createElement("input");
    input.type = "button";
    input.value = "Add Subtype";
    input.setAttribute("class", "button button-small");
    input.setAttribute("onclick", "add_subtupe_meta('"+_i+"','"+product[_i]+"')");
    fragment.appendChild(input);

    fragment.appendChild(document.createTextNode(" "));

    input = document.createElement("input");
    input.type = "button";
    input.value = "Remove";
    input.setAttribute("class", "button button-small");
    input.setAttribute("onclick", "remove_market_meta('MarkeID"+ _i +"_Alt"+product[_i]+"')");
    fragment.appendChild(input);




    input = document.createElement("input");
    input.type = "hidden";
    input.value = "0";
    input.id   = "count_subtype_N" + _i +"_Alt"+product[_i];
    input.name = "count_subtype_N" + _i +"_Alt"+product[_i];
    fragment.appendChild(input);




    fragment.appendChild(document.createElement("br"));

    product[_i]++;
    document.getElementById('count_alt_N'+_i).value = product[_i];
    meta_block.appendChild(fragment);
    meta_block.appendChild(document.createElement("br"));
};



function add_subtupe_meta(__i,__a){
    var meta_block = document.getElementById('MarkeID'+__i+'_Alt'+__a), fragment, input, div;
    fragment = document.createElement("div");

    
    fragment.id = "MarkeID" +__i +"_Alt" +__a +"_Sub" +sub[__i][__a];


    fragment.appendChild(document.createTextNode("\xa0 Subtype "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "SubtypeName_N" +__i +"_Alt" +__a +"_Sub" +sub[__i][__a];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" InStock "));
    input = document.createElement("input");
    input.type = "checkbox";
    input.name = "InStock_N" +__i +"_Alt" +__a +"_Sub" +sub[__i][__a];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" "));

    
    input = document.createElement("input");
    input.type = "button";
    input.value = "Remove";
    input.setAttribute("class", "button button-small");
    input.setAttribute("onclick", "remove_market_meta('MarkeID"+ __i +"_Alt" +__a +"_Sub" +sub[__i][__a]+"')");
    fragment.appendChild(input);


    sub[__i][__a]++;
    document.getElementById('count_subtype_N'+__i+'_Alt'+__a).value = sub[__i][__a];

    meta_block.appendChild(fragment);
};

function add_mainsubtupe_meta(f){
    var meta_block = document.getElementById('MarkeID_SubtypeMain'+f), fragment, input, div;
    fragment = document.createElement("div");

    
    fragment.id = "MarkeID" +f +"_SubMain" +submain[f];


    fragment.appendChild(document.createTextNode("\xa0 Subtype "));
    input = document.createElement("input");
    input.type = "text";
    input.name = "SubtypeName_N" +f +"_SubMain" +submain[f];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" InStock "));
    input = document.createElement("input");
    input.type = "checkbox";
    input.name = "InStock_N" +f +"_SubMain" +submain[f];
    fragment.appendChild(input);


    fragment.appendChild(document.createTextNode(" "));

    
    input = document.createElement("input");
    input.type = "button";
    input.value = "Remove";
    input.setAttribute("class", "button button-small");
    input.setAttribute("onclick", "remove_market_meta('MarkeID"+ f +"_SubMain" +submain[f]+"')");
    fragment.appendChild(input);


    submain[f]++;
    document.getElementById('count_subtypemain_N'+f).value = submain[f];

    meta_block.appendChild(fragment);
};