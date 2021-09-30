var inpCelular = document.getElementById("inpCelular");
var a = 0;

inpCelular.addEventListener("keyup",function(){
    
    var tel = inpCelular.value;   

    if(tel.length > 0 && tel.length < 3 ){
        a = 0;
    }

    if(tel.length > 3 && tel.length < 7 ){
        a = 1;
    }

    if(tel.length==3 && a == 0){
        tel = tel+"-";
        inpCelular.value = tel;
        a = 1;
    }

    if(tel.length==7 && a == 1){
        tel = tel+"-";
        inpCelular.value = tel;
        a = 2;
    }   

});