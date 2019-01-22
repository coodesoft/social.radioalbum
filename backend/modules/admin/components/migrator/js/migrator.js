let attachResponseToDOM = function(data, target, msgSuccess, msgErr){
  let text = Texts.getInstance();
  if ((data != undefined) && data.length == 0)
    $(target+' .panel-body').html(text.getT(msgSuccess));
  else if(data == undefined)
    $(target+' .panel-body').html(text.getT('noChanges'));
  else{
    $(target+' .panel-body').html(text.getT(msgErr));
    console.log(data);
  }


}

let channelCallback = function(data){
  data = JSON.parse(data);
  data = data['response'];
  attachResponseToDOM(data['add'], '#addChannels', 'addOk', 'addErr');
  attachResponseToDOM(data['delete'], '#removeChannels', 'removeOk', 'removeErr');
  attachResponseToDOM(data['update'], '#updateChannels', 'updateOk', 'updateErr');
  $('img.simple-loader').remove();
}

let albumCallback = function(data){
  data = JSON.parse(data);
  data = data['response'];
  attachResponseToDOM(data['add'], '#addAlbums', 'addOk', 'addErr');
  attachResponseToDOM(data['delete'], '#removeAlbums', 'removeOk', 'removeErr');
  attachResponseToDOM(data['update'], '#updateAlbums', 'updateOk', 'updateErr');
  $('img.simple-loader').remove();
}

let songCallback = function(data){
  data = JSON.parse(data);
  data = data['response'];
  attachResponseToDOM(data['add'], '#addSongs', 'addOk', 'addErr');
  attachResponseToDOM(data['delete'], '#removeSongs', 'removeOk', 'removeErr');
  attachResponseToDOM(data['update'], '#updateSongs', 'updateOk', 'updateErr');
  $('img.simple-loader').remove();
}

let artistCallback = function(data){
  data = JSON.parse(data);
  data = data['response'];
  attachResponseToDOM(data['add'], '#addArtists', 'addOk', 'addErr');
  attachResponseToDOM(data['delete'], '#removeArtists', 'removeOk', 'removeErr');
  attachResponseToDOM(data['update'], '#updateArtists', 'updateOk', 'updateErr');
  $('img.simple-loader').remove();
}

let migrator = function(){
  $('#analisisResult').on('click', '.selectAll label', function(e){
    let parentId = $(this).closest('.panel').attr('id');
    let elements = $('#'+parentId).find('input[type="checkbox"][class!="selectAll"]:lt(300)');
    if ($(this).children().is(":checked"))
      $(elements).prop( "checked", true );
    else
      $(elements).prop( "checked", false );
  })

  let form = FormProcessor.getInstance();

  $('#analisisResult').on('click', '[data-trigger="channel"]', function(){
    $(this).addClass(Status.getInstance().HIDE);
    form.setCallback(channelCallback);
  })

  $('#analisisResult').on('click', '[data-trigger="album"]', function(){
    let parent = $(this).parent();
    $(this).addClass(Status.getInstance().HIDE);
    $(this).parent().find('img').remove();
    $(this).parent().append(getLoaderImage());
    form.setCallback(albumCallback);
  })

  $('#analisisResult').on('click', '[data-trigger="song"]', function(){
    $(this).addClass(Status.getInstance().HIDE);
    $(this).parent().find('img').remove();
    $(this).parent().append(getLoaderImage());
    form.setCallback(songCallback);
  })
  $('#analisisResult').on('click', '[data-trigger="artist"]', function(){
    $(this).addClass(Status.getInstance().HIDE);
    $(this).parent().find('img').remove();
    $(this).parent().append(getLoaderImage());
    form.setCallback(artistCallback);
  })
}



let reg = Register.getInstance();
reg.addRegister('migrator', migrator, ['#channelsMigration', '#albumsMigration', '#artistsMigration']);
