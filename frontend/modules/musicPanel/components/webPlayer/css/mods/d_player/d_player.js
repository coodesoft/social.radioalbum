$(function(){
  let volume = new Propeller("#volume-song", {
    inertia: 0,
    speed: 0,
    speed: 0
  });

  volume.onRotate = function (){
    if ((this.angle>90) && (this.angle<=180))
      this.angle = 90;

    if ((this.angle<270) && (this.angle>180))
      this.angle = 270;

  }




})
