
let playback = function(api){
  let root = api.dom();
  if (api.status().paused){
    $(root.controls.play.id).addClass('active');
    api.play();
  } else{
    $(root.controls.play.id).removeClass('active');
    api.pause();
  }
}

let wp = WebPlayer.getInstance();
wp.registerCallback('k', 'vertical', playback, null);
