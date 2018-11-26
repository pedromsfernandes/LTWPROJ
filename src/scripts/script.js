let inputs = document.querySelectorAll("#sorting input")
    
if(inputs){

    inputs[0].addEventListener("click",function(){
        console.log("top")
    });
    
    inputs[1].addEventListener("click",function(){
        console.log("new")
    });
}