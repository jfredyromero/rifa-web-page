let arr = [];
let arr2 = [];

localStorage.clear();

document.getElementById("btn").addEventListener("click", function () {
    
    inp = document.getElementById("inp");
    arr.push(inp.value);
    
    localStorage.setItem("arr",JSON.stringify(arr));

    inp.value="";

    console.clear();
    console.table(localStorage);

})

function createH1Element(text) 
{   
    
    var h = document.createElement("H1");
    var t = document.createTextNode(text); 
    h.appendChild(t); 
    document.getElementById("valores").appendChild(h);
} 

document.getElementById("btn2").addEventListener("click", function(){

    arr2 = JSON.parse(localStorage.getItem("arr"));    
    document.getElementById("valores").innerHTML="";
    console.log(arr2);

    arr2.forEach(n => {
        createH1Element(n);
    });

})