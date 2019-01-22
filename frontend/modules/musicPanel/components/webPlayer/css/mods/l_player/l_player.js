let playback = function(e, api){
  let status = Status.getInstance();

  if (api.status().paused){
    $(e).addClass(status.ACTIVE);
    api.play();
  } else{
    $(e).removeClass(status.ACTIVE);
    api.pause();
  }

}

$(function(){
  let wp = WebPlayer.getInstance();

  let volume = new Propeller("#volume-song", {
    inertia: 0,
    speed: 0,
    speed: 0,
  });
  let vol = 0.5;

  volume.onRotate = function (){
    if ((this.angle>90) && (this.angle<=180))
      this.angle = 90;

    if ((this.angle<270) && (this.angle>180))
      this.angle = 270;

    if ((this.angle>0) && (this.angle<=90))
      vol = (2-Math.cos(toRadians(this.angle)))/2;

    if (this.angle>270)
      vol = Math.cos(toRadians(this.angle))/2;

    wp.api.volume(vol);
  }


wp.registerPlayCallback(playback);

})
