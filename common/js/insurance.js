$(document).ready(function() {
	"use strict";
	
    var html = $("#disease_charge").html(); 
    $('body').on('click', '.add-disease', function() {
        $("#disease_charge").append(html);
    });
    $('body').on('click', '.remove-disease', function() {
       $(this).parent().parent().parent().remove();
    });
    
    $('body').on('keyup', '.searchacte', function() {
        var keyword = this.value;
        $('#listeMutuelle').remove();
      $.ajax({
            url: 'dossier/getActeByJason?search=' + keyword,
            method: 'GET',
            data: '',
            dataType: 'json',
        }).success(function (response) {
             $.each(response, function (key, value) {
                    $("#listeMutuelle").append('<option>nfs</option>');
                });
        });
        
         });
});