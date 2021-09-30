var inpCelular = document.getElementById("inpCelular");
var flag = 0;

inpCelular.addEventListener("keyup",function(){
    
    var tel = inpCelular.value;   

    if(tel.length > 0 && tel.length < 3 ){
        flag = 0;
    }

    if(tel.length > 3 && tel.length < 7 ){
        flag = 1;
    }

    if(tel.length==3 && flag == 0){
        tel = tel+"-";
        inpCelular.value = tel;
        flag = 1;
    }

    if(tel.length==7 && flag == 1){
        tel = tel+"-";
        inpCelular.value = tel;
        flag = 2;
    }   

});