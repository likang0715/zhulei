$('.js-num').on('click','li',function(){
	var newPrice=$(this).html();
	var oldPrice=$('#inputmony').val();
	if(oldPrice.indexOf('.')!=-1){		
		if(newPrice=='.'){
			newPrice='';
		}
		var arr=oldPrice.split('.');	
		if(arr[1].length>=2){
			newPrice='';
		}
	}else if(oldPrice.length>=10){
		newPrice='';
		if( $(this).html()=='.' ){
			newPrice='.';
		}
	}
	$('#inputmony').val(oldPrice+newPrice);
	appendEles();	
});

$('.js-del').on('click',function(){
	$('.js-del').css('color','green');
	setTimeout(function(){
		$('.js-del').css('color','#ddd')
	},30)
	var oldPrice=$('#inputmony').val();
	var len=oldPrice.length-1 ;
	var deledPrice=oldPrice.substring(0,len);
	$('#inputmony').val(deledPrice);
	appendEles();
});

// $('.js-del').on('mouseenter',);
function appendEles(){
	var appendSpan=document.getElementById("showPrice");
	appendSpan.innerHTML="";
	var inputPrice=$('#inputmony').val();
	var len=inputPrice.length;
	for(var i=0;i<len;i++){
		var oSpan=document.createElement("span");
		oSpan.innerHTML=inputPrice[i];	
		appendSpan.appendChild(oSpan);	
	}
	var oLine=document.createElement("i");
	oLine.className ="cursor cursor-animation";
	appendSpan.appendChild(oLine);
	if(Number(inputPrice)==0){
		$('.js-ok').addClass('gray');
	}else{
		$('.js-ok').removeClass('gray');
	}
}