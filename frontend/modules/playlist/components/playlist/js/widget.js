
function switchTabs(parent){
  let status = Status.getInstance();
  let $tab = $(parent+ ' .'+status.BLOCK);
  $tab.removeClass(status.BLOCK).addClass(status.HIDE);
  $tab.siblings().removeClass(status.HIDE).addClass(status.BLOCK);
}

function switchActionButton(element){
    let parent = $(element).parent();
    let toAdd;
    if ($(element).hasClass('new-playlist'))
      toAdd = '<i class="fas fa-chevron-circle-left fa-2x new-playlist-btn back-to-list"></i>';
    else
      toAdd = '<i class="fas fa-plus-circle fa-2x new-playlist-btn new-playlist"></i>';

    parent.html(toAdd);
}

let callback = function(data){
  let flags = Flags.getInstance();
  let modalID ="";
  data = JSON.parse(data);
  if (data.hasOwnProperty('response')){

    switch (data['flag']) {
      case flags.SAVE_SUCCESS:
        let origin = data['response']['origin'] == 'extended' ? '.playlist-container' : '.playlist-minimal-container';
        console.log(origin);
        if ($(origin+' .playlists-list table tbody').length > 0)
          $(origin+' .playlists-list table tbody').append(data['response']['data']);
        else
          $(origin+' .playlists-list table').append(data['response']['data']);

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
        modalID = Browser.getInstance().getContext().modal;
        $('#playlist_'+data['response']).remove();
        $('.playlists-content').html('<div id="noSongs" class="text-center"><h1>Tus canciones</h1></div>');
        $(modalID).empty();
        break;
      case flags.DELETE_ERROR:
        modalID = Browser.getInstance().getContext().modal;
        $(modalID).html(data['response']);
        break;
      case flags.UNLINK_SUCCESS:
        let response = data['response'];
        modalID = Browser.getInstance().getContext().modal;

        $('#song_'+response['song']).parent().remove();
        let plBody = $("table[data-playlist='" + response['playlist'] + "'] tbody");

        if (plBody.children().length == 1)
          $('#playlistDescription .content').html('<div id="noSongs" class="text-center"><h1>Tus canciones</h1></div>');

        let cantSongs = $('#cantSongs').text();
        cantSongs = parseInt(cantSongs)>0? parseInt(cantSongs) - 1 : 0;
        $('#cantSongs').text(cantSongs);

        $(modalID).empty();
        break;
      case flags.UPDATE_SUCCESS:
        modalID = Browser.getInstance().getContext().modal;
        let stored = data['response'];
        $('#playlist_'+stored['id']+' td.playlist-item a').text(stored['name']);
        if ($('[data-pl="playlist_'+stored['id']+'"]').length > 0){
          $('[data-pl="playlist_'+stored['id']+'"] .name .italic').text(stored['name']);
          $('[data-pl="playlist_'+stored['id']+'"] .visibility .italic').text(stored['visibility']);
        }
        $(modalID).empty();
        break;
      case flags.UPDATE_ERROR:
        modalID = Browser.getInstance().getContext().modal;
        $(modalID).html(data['response']);
        break;
    }

  } else {
    let modalBox = ModalBox.getInstance();
    let texts = Texts.getInstance();
    modalBox.show(texts.getT('ops'),texts.getT('unknownError'));
  }
}

let widget = function(){
  let container = '.playlist-container';
  let mobileContainer = '.playlist-mobile';
  let minContainer = '.playlist-minimal-container';

  $(container).off().on('click', '.new-playlist-btn', function(){
    if (!$(minContainer).length>0){
      switchTabs(container);
      switchActionButton(this);
    }
  });

  $(container).on('click', '.cancel-new-playlist', function(){
    if (!$(minContainer).length>0){
      switchTabs(container);
      console.log('std');
      switchActionButton('.new-playlist-btn');
    }
  });

  $(minContainer).off().on('click', '.new-playlist-btn', function(){
    switchTabs(minContainer);
    if ($(minContainer).length == 0)
      switchActionButton(this);
  });

  $(minContainer).on('click', '.cancel-new-playlist', function(){
    switchTabs(minContainer);
    if ($(minContainer).length == 0)
      switchActionButton('.new-playlist-btn');
  });

  $(mobileContainer).on('click',  'a[data-action="explore"]', function(){
    $('.playlists').addClass('ra-hidden');
    $('.playlists-content').removeClass('ra-hidden');
    $('.returnToPlaylist').removeClass('ra-hidden');
  });

  $(mobileContainer).on('click','.returnToPlaylist', function(){
    $('.playlists').removeClass('ra-hidden');
    $('.playlists-content').addClass('ra-hidden');
    $(this).addClass('ra-hidden');
  })



  let browser = Browser.getInstance();
  browser.setExplorationTarget('.playlists-content');

  let formProcessor = FormProcessor.getInstance();
  formProcessor.setCallback(callback);

}

$(function(){
  let register = Register.getInstance();
  register.addRegister('playlist', widget, '#playlistArea');

});
