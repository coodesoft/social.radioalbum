
function getServerURL(){
	return ((location.href.split('/'))[0])+'//'+((location.href.split('/'))[2]) + "/";
}

function getPlatformURL(){
	return getServerURL()+ "radioalbum/site/";
}

function getFrontendUrl(){
	return getPlatformURL() + "frontend/web/";
}

function getBackendUrl(){
	return getPlatformURL() + "backend/web/";
}

function getFrontendAssetsURL(){
	return getFrontendUrl() + "assets/";
}

function getBackendAssetsURL(){
	return getBackendUrl() + "assets/";
}

function maximizeHeightToWindow(component, marginOffset){
	if ($(component).length>0){
		if (marginOffset == undefined)
			resizeComponentHeight(component, ($(window).height()-$(component).position().top));
		else{
			resizeComponentHeight(component, ($(window).height()-$(component).position().top-marginOffset));
		}
	}
}

function maximizeHeight(component, parent, marginOffset){
	let parentHeight;
	if ((parent == null) || (parent == undefined))
		parentHeight = $(component).parent().height();
	else
		parentHeight = $(parent).height();

	resizeComponentHeight(component, parentHeight, marginOffset);
}

function maximizeWidth(component, parent, marginOffset){
	let parentWidth;
	if ((parent == null) || (parent == undefined))
		parentWidth = $(component).parent().width();
	else
		parentWidth = $(parent).width();

	resizeComponentWidth(component, parentWidth, marginOffset);
}

function resizeComponentHeight(component, size, marginOffset){
	if (marginOffset == undefined)
		$(component).css('height',size);
	else
		$(component).css('height',size-marginOffset);
}

function resizeComponentWidth(component, size, marginOffset){
	if (marginOffset == undefined)
		$(component).css('width',size);
	else
		$(component).css('width',size-marginOffset);
}

function showAlert(msg){
	let status = Status.getInstance();
	$('div[role=alert]').html(msg);
	setTimeout(function(){
		$('div[role=alert]').toggleClass(status.HIDE);
		$('div[role=alert]').toggleClass(status.BLOCK);
	}, 2000);
	$('div[role="alert"]').toggleClass(status.HIDE);
	$('div[role=alert]').toggleClass(status.BLOCK);
}

// Retorna un entero aleatorio entre min (incluido) y max (excluido)
function randomize(min,max){
	return Math.floor(Math.random() * (max - min)) + min;
}

 function isFunction(obj) {
  return typeof obj == 'function' || false;
}


function toRadians(angle){
	return angle * Math.PI / 180;
}


function getLoaderImage(){
	let imgUrl = getBackendUrl()+ "img/loader.gif";
	let img = '<img src='+imgUrl+' alt="loader" class="simple-loader">';
	return img;
}

function getAlertBox(message, type){
	let alert  = '<div class="alert alert-'+type+'" role="alert">';
			//alert += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
			alert += '' + message;
			alert += '</div>';
	return alert;
}

function getIdSelectorValue(selector){
	if (selector.indexOf('.') == 0 || selector.indexOf('#')==0)
   	return selector.substring(1);
}

function getClassSelectorValue(selector){
	return getIdSelectorValue(selector);
}



let preloadImage = function (input, target) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $(target).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}
