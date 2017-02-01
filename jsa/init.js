function initImg(host,img,did,iwidth,iheight)
{       
    ClearElem(document.getElementById(did)); 
    reswnd =  document.createElement('DIV');
    reswnd.id='cachestate'; 
    //reswnd.innerHTML = "skngfsjklgnjksnvlnzklvmklzx zidnv iodnv ";
    resajaxobjwnd = new sack();  
    if ((iwidth!=0) && (iheight!=0))
        resajaxobjwnd.requestFile =host+'/img.php?imgsrc='+img+'&imgwdth='+iwidth+'&imghght='+iheight;    
    else
        resajaxobjwnd.requestFile =host+'/img.php?imgsrc='+img;    
    //resajaxobjwnd.onCompletion = function(){ ShowReportResult(resajaxobjwnd,reswnd,document.getElementById(did));};  
    resajaxobjwnd.onCompletion = function(){
                                            //alert(document.getElementById(did).style.top);                                             
                                            document.getElementById(did).innerHTML = resajaxobjwnd.response;
                                            document.getElementById(did).style.top = document.body.scrollTop;
                                            };  
    resajaxobjwnd.runAJAX();     
    //SetDivSize('smallplace',iwidth,iheight,10);
}
//фунция выводит результат работы кеширования
function ShowReportResult(ao,resplace,parentdiv)
{                
        //ClearElem(parentdiv);
        alert(parentdiv.style.left);
        resplace.innerHTML = ao.response;   
         try
         {
            document.getElementById('cachestate').removeChild(document.getElementById(parentdiv)); 
         }        
         catch (err){ }
         alert(parentdiv.style.top);
        parentdiv.appendChild(resplace);  
                
        //document.appendChild(resplace);          
}
function ClearElem(elem)
{
        elem.innerHTML=''; 
}

function HideDiv(divId)
{
        document.getElementById(divId).style.visibility='hidden';
}

function ShowDiv(divId)
{
        document.getElementById(divId).style.visibility='visible';
         //document.getElementById(divId).style.top = document.body.scrollTop;
         //alert(document.getElementById(divId).style.height);
        // document.getElementById(divId).style.top = ceil(screenSize().h/2)-  ceil(document.getElementById(divId).style.height/2);
        //alert('top '+divId+'='+document.getElementById(divId).style.top);
}      

function InvertDiv(divId)
{
    if (document.getElementById(divId).style.visibility=='hidden')
        document.getElementById(divId).style.visibility='visible';
    else
        document.getElementById(divId).style.visibility='hidden';
}

function screenSize() { //"Длина = " + screenSize().w  "Высота = " + screenSize().h  
    var w, h; // Объявляем переменные, w - длина, h - высота
    w = (window.innerWidth ? window.innerWidth : (document.documentElement.clientWidth ? document.documentElement.clientWidth : document.body.offsetWidth));
    h = (window.innerHeight ? window.innerHeight : (document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.offsetHeight));
    return {w:w, h:h};
}

function SetDivSize(divid,xf,yf,k)     
{
    var xc,yc, rel;
    
    if (xf > yf)
    {
        rel = xf / yf;                
       alert('by x');
        document.getElementById(divid).style.width = screenSize().w-rel*k*2;
        document.getElementById(divid).style.width = xf+rel*k*2;
         document.getElementById(divid).style.height=rel*yf;
         rel = rel*k;
        document.getElementById(divid).style.left = rel;
        document.getElementById(divid).style.top =  ceil(screenSize().h/2)  -  ceil(document.getElementById(divid).style.height/2);
        
    }
   
    else if (xf < yf) 
    {
        alert('by y')
        rel = yf/xf;
        document.getElementById(divid).style.height = screenSize().h-rel*k*2;
         document.getElementById(divid).style.width=xf/yf*xf;
         rel = rel*k;
        document.getElementById(divid).style.top = rel;
        document.getElementById(divid).style.left = ceil(screenSize().w/2)  -  ceil(document.getElementById(divid).style.width/2);
    }
    else
        rel = 1;
      
    //document.getElementById(divid).style.width = screenSize().w-rel*2;
    

    
}