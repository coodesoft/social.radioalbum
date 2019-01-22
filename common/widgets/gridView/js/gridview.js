let popUpAdditionalActions = function(){
  let status = Status.getInstance();
  $('#gridView').off().on('click', function(e){
    let element;
    if ( $(e.target).is("#popButton") )
      element = $(e.target).is("#popButton");

    if ( $(e.target).closest('#popButton').length )
      element = $(e.target).closest('#popButton');

    if (element != undefined){
      if (element.siblings('.popActions-list').hasClass(status.HIDE)){
        $('.popActions-list').removeClass(status.BLOCK);
        $('.popActions-list').addClass(status.HIDE);

        element.siblings('.popActions-list').addClass(status.BLOCK);
        element.siblings('.popActions-list').removeClass(status.HIDE);
      } else{
        element.siblings('.popActions-list').removeClass(status.BLOCK);
        element.siblings('.popActions-list').addClass(status.HIDE);
      }
    } else {
      $('.popActions-list').removeClass(status.BLOCK);
      $('.popActions-list').addClass(status.HIDE);
    }
  });
}


let widget = function(){
  popUpAdditionalActions();

  $('.grid-item img').each(function(){
      let parent = $(this).parent();
      if (this.complete || /*for IE 10-*/ $(this).height() > 0) {
        parent.removeClass('grid-initial');
        parent.addClass('grid-complete');
      } else {
        $(this).on('load', function(){
          parent.removeClass('grid-initial');
          parent.addClass('grid-complete');
        });
      }
  });

}

let registerGrid = Register.getInstance();
registerGrid.addRegister('gridview', widget, '#gridView');
