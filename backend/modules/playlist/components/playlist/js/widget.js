
function switchTabs(){
  let status = Status.getInstance();
  let $tab = $('.'+status.BLOCK);
  $tab.removeClass(status.BLOCK).addClass(status.HIDE);
  $tab.siblings().removeClass(status.HIDE).addClass(status.BLOCK);
}

function switchActionButton(element){
  if ($(element).hasClass('action-std-add')){
    $(element).removeClass('action-std-add');
    $(element).addClass('action-std-left');
  } else
    if ($(element).hasClass('action-std-left')) {
      $(element).addClass('action-std-add');
      $(element).removeClass('action-std-left');
  }

}

let callback = function(data){
  let flags = Flags.getInstance();
  let modalID ="";
  data = JSON.parse(data);
  if (data.hasOwnProperty('response')){

    switch (data['flag']) {
      case flags.SAVE_SUCCESS:
        if ($('.playlists-list table tbody').length > 0)
          $('.playlists-list table tbody').append(data['response']);
        else
          $('.playlists-list table').append(data['response']);

        $('#nombrePlayList').val("");
        $('.cancel-new-playlist').click();
        break;
      case flags.SAVE_ERROR:
        showAlert(data['response']);
        break;
      case flags.ALREADY_EXIST:
        showAlert(data['response']);
        break;
      case flags.DELETE_SUCCESS:
        modalID = '#'+Browser.getInstance().getContext().modal;
        $('#'+data['response']).remove();
        if ($('.playlists-content table[data-playlist='+data['response']+']').length >0){
          $('.playlists-content table[data-playlist='+data['response']+']').remove();
          $('.playlists-content').html('<div class="text-center"><h1>Listas de Reproducción</h1></div>');
        }
        $(modalID).empty();
        break;
      case flags.DELETE_ERROR:
        modalID = '#'+Browser.getInstance().getContext().modal;
        $(modalID).html(data['response']);
        break;
      case flags.UNLINK_SUCCESS:
        let id = data['response'];
        modalID = '#'+Browser.getInstance().getContext().modal;
        $('#'+id).parent().remove();
        $(modalID).empty();
        break;
      case flags.UPDATE_SUCCESS:
        modalID = '#'+Browser.getInstance().getContext().modal;
        let stored = data['response'];
        $('#'+stored['id']+' td.playlist-item a').text(stored['name']);
        $(modalID).empty();
        break;
      case flags.UPDATE_ERROR:
        modalID = '#'+Browser.getInstance().getContext().modal;
        $(modalID).html(data['response']);
        break;
      default:
          alert('asdasd');
    }

  } else {
    alert('asdasd');
  }
}

let widget = function(){
  let container = '.playlist-container';

  offsetHeight = $('.ra-title').outerHeight();
  maximizeHeight('.playlist-container .ra-tab', '.playlists', offsetHeight);

  $(container).off().on('click', '.new-playlist-btn', function(){
    switchTabs();
    switchActionButton(this);
  });

  $(container).on('click', '.cancel-new-playlist', function(){
    switchTabs();
    switchActionButton('.new-playlist-btn');
  });

  let browser = Browser.getInstance();
  browser.setExplorationTarget('.playlists-content');

}


$(function(){
  let register = Register.getInstance();
  let formProcessor = FormProcessor.getInstance();

  formProcessor.resetCallback();
  formProcessor.setCallback(callback);

  register.reset();
  register.register('playlist', widget);

})
