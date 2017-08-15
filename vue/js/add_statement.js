
window.addEventListener("load",facture,false);

function facture (){

	var article_id=1;
	var number_articles=1;
	var TVA=parseFloat(document.getElementById("TVA_value").textContent);// recuperer le taux de  TVA  depuis le document apres que celui la soit chargé 
	var tbody = document.querySelector("#table tbody");

	//---------------------

	document.getElementById("discount").addEventListener("change",updateTotal);

	//-----------------

	//the first article
	var article1=tbody.firstElementChild;
	var number1=document.getElementById("number1");// the number input (first article)
	var price1=document.getElementById("price1");// the price input (first article)

	article1.lastElementChild.appendChild(buttonRemove());
	number1.addEventListener("change",calculateAmountPrice,false);
	price1.addEventListener("change",calculateAmountPrice,false);

	document.getElementById("add_article").addEventListener("click",function(){

			
			
			var new_article=null;
			var article_text_input=null; //the first field "article" designation 
			var number_articles_input = null;
			var price_input = null;
			var remove_article_button= null;

			//------- add the article 
			article_id++;
			number_articles++;

			new_article=document.createElement("tr");
			new_article.innerHTML='<td class="lineNumber"><span id='+"N"+number_articles+'>'+getLineNumber(number_articles)+'</span></td>\n';
			new_article.innerHTML+='<td><input type="text" class="articles" required="required" name='+"article"+article_id+' id='+"article"+article_id+'  /></td>\n';
			new_article.innerHTML+='<td><input type="text" name='+"unit"+article_id+' class ="unit" value="u"/></td>';
			new_article.innerHTML+='<td><input type="number" required="required" name='+"number"+article_id+' id='+"number"+article_id+' class="number" min="0" step="any"/></td>\n';
			new_article.innerHTML+='<td><input type="text" required="required" name='+"price"+article_id+' class="price"  id='+"price"+article_id+' /></td>\n';
			new_article.innerHTML+='<td class="amount" id='+"amount"+article_id+'></td>\n<td></td>';
			tbody.appendChild(new_article);
			
			// ------- select the article added (input number and input price )
			article_text_input=document.getElementById("article"+article_id);
			number_articles_input=document.getElementById("number"+article_id);
			price_input=document.getElementById("price"+article_id);


			// -------- add event listener to the twice (input number and input price ) to calculate the total price 
			 
			number_articles_input.addEventListener("change",calculateAmountPrice);
			price_input.addEventListener("change",calculateAmountPrice);

			//--------- add the button "remove" to can delete the article added 
			
			new_article.lastElementChild.appendChild(buttonRemove());

			//------- add the one empty "tr" to can insert another article in this td 
			tbody.appendChild(document.createElement("tr"));
	});
		
	
	function removeArticle(){
		var tbody=document.querySelector("#table tbody");
		var article_to_remove=this.parentElement.parentElement;
		tbody.removeChild(article_to_remove);
		number_articles--;
		updateLineNumbers();
		updateTotal();
	}

	function buttonRemove(){
		remove_article_button=document.createElement("button");
		remove_article_button.textContent="supprimer";
		remove_article_button.addEventListener("click",removeArticle,false);
		return remove_article_button;
	}

	function calculateAmountPrice(){
		var total=0;
		//var parent=this.parentElement.parentElement.querySelectorAll("td"); // on recup le td qui contient notre element
		var id=null;
		if(this.className=="price"){
			id=this.id.substr(5);
		}
		else if(this.className=="number"){
			id=this.id.substr(6);
		}

		var number=document.getElementById("number"+id); //le champ input de de la premiere cellule
		var price=document.getElementById("price"+id);
		if(!isNaN(parseFloat(number.value)) && !isNaN(parseFloat(price.value)) ){
			total=parseFloat(number.value)*parseFloat(price.value);
			document.getElementById("amount"+id).textContent=total.toFixed(2);
			updateTotal();
			
		}
		
	}

	/**
	*this method adds 0 to the number given in parameter if 0<n<9 (always n>0)
	*/
	function getLineNumber(n){
		if(n>0 && n<10){
			return "0"+n;
		}
		else{
			return ""+n;
		}
	}

	/**
	*updates 
	*/
	function updateLineNumbers(){
		var articles=tbody.getElementsByClassName("lineNumber");
		var i=0;
		for(i;i<articles.length;i++){
			articles[i].textContent=""+getLineNumber(i+1);
		}
	}

	/**
	*
	*/
	function updateTotal(){
		var somme=0;
		var TTC=0;
		var amounts=document.getElementsByClassName("amount");
		var discount=parseFloat(document.getElementById("discount").value);
		var total=document.getElementById("total_value");

		var i=0;
		for(i;i<amounts.length;i++){
			var amount=parseFloat(amounts[i].textContent);
			if(!Number.isNaN(amount)){
				somme+=amount;
			}
		}
		TTC=(somme+((somme*TVA)/100)).toFixed(2);
		document.getElementById("PHT_value").textContent=somme.toFixed(2); //PHT prix hors taxes
		document.getElementById("TTC_value").textContent=TTC;
		if(! Number.isNaN(discount)){
			total.textContent=(TTC-discount).toFixed(2);
		}
		else{
			total.textContent=TTC;
		}

	}

}
	

