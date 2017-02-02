var cookieName = "cart"; 
// возвращает cookie с именем name, если есть, если нет, то undefined
function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

// устанавливает cookie с именем name и значением value
// options - объект с свойствами cookie (expires, path, domain, secure)
function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

// удаляет cookie с именем name
function deleteCookie(name) {
  setCookie(name, "", {
    expires: -1
  })
}

function removeFromCart(goodsId){
      var cart = getCookie(cookieName);
    if (cart == null){
        return;
    }
    else{
        cart = JSON.parse(cart.substr(5));
    }
    for(var i=0; i<cart.length; i++){
        if (cart[i].id == goodsId){
        console.log("ind", i);
           cart.splice(i, 1); 
           saveCartToCookie(cart);
           console.log(JSON.stringify(cart));
           location.reload();
        }
    }
    
}

function saveCartToCookie(cart){
console.log(cart);
    setCookie(cookieName, "cart_"+JSON.stringify(cart), {"expired":3600});
}
function addGoodToCart(goodId, price){
    console.log("addGoodToCart");
    var priceVal = $('#'+price).val();
        if ((priceVal==null)||(priceVal=='')){
            priceVal = $('#'+price).html();
        }
    console.log("priceVal", priceVal);
    
    var cart = readCart();
    
    var found = false;
     
    for (var i=0; i<cart.length; i++){
        var item = cart[i];
        if (item.id == goodId){
            item.count++;
            found = true;
            break;
        }
    }

    if (found == false){
        cart.push({"id": goodId, "price": priceVal, "count": 1});
    }
    
    saveCartToCookie(cart);
    showCartValueNum(cart.length);
    console.log("add cookie");
    console.log(getCookie(cookieName));
    afterAddToCartDialog("http://127.0.0.1/cms/");
    //console.log(document.cookie); 
}

function readCart(){
    var cart = getCookie(cookieName);
    if (cart == null){
        cart = [];
    }
    else{
        cart = JSON.parse(cart.substr(5));
    }
    return cart;
}

function addItemToCart(goodId, cnt){
        var cart = readCart();
        for (var i=0; i<cart.length; i++){
            var item = cart[i];
            if (item.id == goodId){
                if ((item.count + cnt) < 0){
                    return true;
                }
                item.count += cnt;
                saveCartToCookie(cart);
                return true;
            }
        }
        return false;
    
}

function cartPlusGoods(goodId){
    addItemToCart(goodId, 1);
    location.reload();
}

function cartMinusGoods(goodId){
    addItemToCart(goodId, -1);
    location.reload();
}