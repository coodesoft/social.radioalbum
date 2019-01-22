
let profileActionWidget = function(){
  let requester = Requester.getInstance();

  $('#profileArea').on('click', '.main-action a[data-action="social.follow"]', function(e){
    e.preventDefault();
    e.stopPropagation();

    let success = function(data){
      let texts = Texts.getInstance();
      let status = Status.getInstance();

      data = JSON.parse(data);
      if (data['response'] != null){

        if (data['response']['status'] == status.ACCEPTED){
            $('a[data-action="social.follow"] span').text(texts.getT('stopFollow'));
        }

        if (data['response']['status'] == status.PENDING){
            $('a[data-action="social.follow"] span').text(texts.getT('pendingResquest'));
        }

        if (data['response']['status'] == null){
          $('a[data-action="social.follow"] span').text(texts.getT('follow'));
        }
        $('a[data-action="social.follow"]').attr('href', data['response']['url']);
      }
    }

    let error = function(data){
      ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
    }

    requester.request(this.href, success, error);
   });
}

let profileWidget = function(){
  let status = Status.getInstance();

  $('#profileArea').off().on('click', '#profileProduction .tab-item', function(){
    console.log(status.ACTIVE);
      let source = $(this).attr('data-source');
    $(this).siblings().removeClass(status.ACTIVE);
    $(this).addClass(status.ACTIVE);
    $('#'+source).siblings().removeClass(status.BLOCK).addClass(status.HIDE);
    $('#'+source).removeClass(status.HIDE).addClass(status.BLOCK);
  });

  $('#profileArea').on('click', '.profile-selector', function(){
    let target = $(this).data('target');
    $('.profile-selector').removeClass('active');
    $(this).addClass('active');

    $('#profileArea .target-selector').removeClass('ra-hidden ra-hidden');
    $('#profileArea .target-selector').addClass('ra-hidden');
    $(target).addClass('ra-block');
    $(target).removeClass('ra-hidden');
  });

  profileActionWidget();
}

let reg = Register.getInstance();
reg.addRegister('profile', profileWidget, '#profileArea');
