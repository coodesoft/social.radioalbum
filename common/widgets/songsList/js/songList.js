
let songListWidget = function(){
/*
  if ( !$.fn.dataTable.isDataTable( '#songListTable' ) ) {
    $('#songListTable').DataTable( {
          "order": [[ 1, "desc" ]],
          "columnDefs": [
              { "orderable": false, "targets": 0 }
          ],
          "paging": false,
          language: {
            search: "Buscar: ",
          }
      } );
  }
  */

}


let reg = Register.getInstance();
reg.addRegister('songList', songListWidget, '#songsList');
