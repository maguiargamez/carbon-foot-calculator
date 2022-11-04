function resultsco2(){
    var electricInput = document.getElementById("questionTwoElectricity").value;
    var gasInput = document.getElementById("questionTwoGas").value;
    
    tco2Electricidad = ((electricInput*0.0168)/93000).toFixed(3);

    if(gasInput!=0){
        tco2Gas = ((25000*0.0231)/gasInput).toFixed(3);
    }else{
        tco2Gas=0;
    }
    

    alert(gasInput);
    alert(tco2Gas);
}