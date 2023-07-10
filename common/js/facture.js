
$(document).ready(function () {
  var element = document.getElementById('mobNo');
    var ref = document.getElementById('mobRef');
    var maskOptions = {
        mask: "{(+221)} 00 000 00 00",
        lazy: false,
    };
    var patternMask = IMask(ref, {
        mask: '{PP}000000.0000.[a]00000',
        lazy: false,
    });
    var mask = IMask(element, maskOptions);
    mask.value = "{-- --- -- --";
    var el = IMask(ref, patternMask);
    el.value = "{------ ---- ------";
});
  function caisseUpdate(eventObj) {
        var bouttonSuivant = document.getElementById('bouttonSuivant');
        var bouttonOrangeMoney = document.getElementById('bouttonOrangeMoney');
        var bouttonZuuluPay = document.getElementById('bouttonZuuluPay');

        if (eventObj.target.value == 'OrangeMoney') {
            bouttonSuivant.style['display'] = 'none';
            bouttonOrangeMoney.style['display'] = 'block';
            bouttonZuuluPay.style['display'] = 'none';
            document.getElementById('description_type').value = 'Dépôt Orange Money';  document.getElementById('deposit_type').value = 'OrangeMoney';
        }  else if (eventObj.target.value == 'zuuluPay') {
            bouttonSuivant.style['display'] = 'none';
            bouttonOrangeMoney.style['display'] = 'none';
            bouttonZuuluPay.style['display'] = 'block';
              document.getElementById('description_type2').value = 'zuuluPay';  document.getElementById('deposit_type2').value = 'zuuluPay';
        } else {
            bouttonSuivant.style['display'] = 'block';
            bouttonOrangeMoney.style['display'] = 'none';
            bouttonZuuluPay.style['display'] = 'none';
        }

    }
        
   
  
    
    function compteDebite(event) {
            var formCustmer = $('#formCustmer').val();
            var pin = $('#PIN').val();
            var type = $('#compte1').val();
       document.getElementById('montantCaisse').style['display'] = 'none';
                document.getElementById('fraisCaisse').style['display'] = 'none';
                if(formCustmer && pin) {
                      document.getElementById('montantCaisse').style['display'] = 'block';
                document.getElementById('fraisCaisse').style['display'] = 'block';
                console.log("fr" +'--'+ amount +'--'+ type +'--'+ formCustmer +'--'+ pin);
                solde("fr", formCustmer, pin);
                var reponseAll = compteDebiteFrais("fr",type,formCustmer, pin);
              
            } else {
                 $('#myModal').modal('show');
            }


            }
      