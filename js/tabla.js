$(document).ready(function(){
    $("#example").DataTable({
        "pageLength":5,
        lengthMenu:[
            [5,10,25,50],
            [5,10,25,50]
        ],
        "language": {
             "url":"https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"   
        }    
    });
    });

$(document).ready(function(){   
    var table = $('#example2').DataTable( {
        oderCellsTop: true,
        fixedHeader: true,
        "columnDefs": [ {
            "targets": 0,
            "searchable": false
            
          } ]
      } );
    });