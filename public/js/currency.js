var currencyInput = document.querySelectorAll( 'input[type="currency"]' );

for ( var i = 0; i < currencyInput.length; i++ ) {  
  var currency = 'IDR'
  onBlur({
    target: currencyInput[i]
  });
  
  currencyInput[i].onfocus    = onFocus;
  currencyInput[i].onblur     = onBlur;
  currencyInput[i].onkeypress = onKeyPress;
  
  function localStringToNumber(s) {
    return Number(String(s).replace( /[^0-9.-]+/g, ""))
  }
  
  function onKeyPress ( e ) {
    var charCode = e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
      return false;
    }
  }

  function onFocus( e ) {
    var value = localStringToNumber(e.target.value);
    e.target.value = value == 0 ? '' : value;
  }
  
  function onBlur( e ) {    
    var options = {
      maximumFractionDigits: 2,
      currency: currency,
      style: "currency",
      currencyDisplay: "symbol"
    };
    
    e.target.value = localStringToNumber(e.target.value).toLocaleString(undefined, options);
  }
}

function submitForm() {
  alert ("Hiya");
}