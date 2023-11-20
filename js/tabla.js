$(document).ready(function(){
    $("#example").DataTable({
        "pageLength":10,
        lengthMenu:[
            [10,25,50,75],
            [10,25,50,75]
        ],
        "language": {
             "url":"https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"   
        },    
        
    });
    });