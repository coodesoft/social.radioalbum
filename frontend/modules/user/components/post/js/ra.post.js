
var Post = (function($){

  function Post(){

    let _requester;

    let _component = {
      'container' : '#postContainer',
      'post' : '.post_cmpt',
      'comment' : '.comment_cmpt',
      'moreComments' : '.show-more-comments',
      'removeSocialBlock' : '#removeSocialBlock',
    }

    let _posts;
    let _controlPosts;
    let _hiddenComments;

    let TIME = 30000;

    let THRESHOLD = 5;

    let _likesRequestStatus;

    let _newCommentRequestStatus;


    let _setLikesRequestInProgress = function(status){
      if (status === true)
        _likesRequestStatus = true;

      if (status === false)
        _likesRequestStatus = false;
    }

    let _getLikesRequestInProgress = function(){
      return _likesRequestStatus;
    }

    let _setNewCommentRequestInProgress = function(status){
      if (status === true)
        _newCommentRequestStatus = true;

      if (status === false)
        _newCommentRequestStatus = false;
    }

    let _getNewCommentRequestInProgress = function(){
      return _newCommentRequestStatus;
    }


    let _getComponentUID = function(obj){
      if (obj != null && obj != undefined && obj.length){
          let classes = obj.attr('class');
          let arrClasses = classes.split(" ");

          arrClasses = arrClasses[0].split('_');
          return  arrClasses[2];
      }

      return -1
    }

    let _getParamsStr = function(){
      let posts = new Object;
      $(_component.post).each(function(index){

        //*** Obtengo el ID del Post
        let postId = _getComponentUID($(this));

        //*** Obtengo el ID del ultimo comnetario del Post
        let comment = $(this).find(_component.comment).last();
        let lastCommentId = _getComponentUID(comment);

        if (postId != -1)
          posts[postId] = lastCommentId;
      });

      return posts;
    }

    let _strhtmlToJObject = function(strHtml){
      let html = $.parseHTML(strHtml);
      return $($(html)[1]);
    }

    /*
     * MÉTODOS FUNDAMENTALES DE LA ESTRUCTURA INTERNA DE CONTROL DEL MÓDULO
     */

    let _buildMirror = function(){
      let domPosts = $(_component.post).get();

      _controlPosts['smallest_id'] = _getComponentUID($(domPosts[0]));

      for (var i = 0; i < domPosts.length; i++) {
        let post_uid = _getComponentUID($(domPosts[i]));

        if (post_uid <_controlPosts['smallest_id'])
          _controlPosts['smallest_id'] = post_uid;

        _createNewEntryInMirror(post_uid);
        let comments = $(domPosts[i]).find(_component.comment).get();
        if (comments.length){
          for (var t = 0; t< comments.length; t++)
            _posts[post_uid][t] = _getComponentUID($(comments[t]));
        }else
            _updateMirrorWithEmptyValue(post_uid)
      }
    }

    let _updateMirror = function(post_uid, container, insertAtBegining){
      _createNewEntryInMirror(post_uid);
      let element = (container instanceof jQuery) ? container : _strhtmlToJObject(container);

      if (insertAtBegining==null || insertAtBegining==undefined || !insertAtBegining)
        _posts[post_uid][_posts[post_uid].length] = _getComponentUID(element);
      else
        _posts[post_uid].unshift(_getComponentUID(element));
    }

    let _createNewEntryInMirror = function(post_uid){
      if (_posts[post_uid] == undefined)
        _posts[post_uid] = [];
    }

    let _updateMirrorWithEmptyValue = function(post_uid){
      _posts[post_uid][0] = 0;
    }


    /* ****************************************
     * Métodos de control interno de los likes
     */

    let _getLikeElementSelector = function(element, id){
      return '.'+element+'_cmpt_'+id+' .'+element+'-like';
    }

    let _setHasLikes = function(element, status){
      if (status){
        $(element).addClass('has_likes');
        $(element + " .like-counter").removeClass('hidden');
      } else {
        $(element).removeClass('has_likes');
        $(element + " .like-counter").addClass('hidden');
      }

    }

    let _hasLikes = function(element){
      return $(element).hasClass('has_likes');
    }

    let _setILike = function(element, status){
      if (status){
        $(element).addClass('i_like');
        $(element + " .like-counter").removeClass('hidden');
      } else {
        $(element).removeClass('i_like');
      }
    }

    let _iLike = function(element){
      return $(element).hasClass('i_like');
    }

    let _incLikeCounter = function(element){
      let counter = $(element + " .like-counter").text();
      counter = parseInt(counter) + 1;
      $(element+" .like-counter").text(counter);
    }

    let _decLikeCounter = function(element){
      let counter = $(element + " .like-counter").text();
      counter = parseInt(counter) - 1;
      $(element+" .like-counter").text(counter);
    }

    let _resetLikeCounter = function(element){
      $(element + " .like-counter").text(0);
    }

    let _setLikeCounter = function(element, value){
      $(element + " .like-counter").text(value);
    }

    let _getLikeCounter = function(element){
      return $(element + " .like-counter").text();
    }

    let _updateElementLike = function(element, storedCount){
      let counter = _getLikeCounter(element);

      if (counter != storedCount){
        if (storedCount == 0){
          _resetLikeCounter(element);
          _setHasLikes(element, false);
        } else if (counter == 0) {
          _setLikeCounter(element, storedCount);
          _setHasLikes(element, true);
        } else{
          _setLikeCounter(element, storedCount);
        }
      }
    }

    /* ********************************************************
     * Métodos de control interno para mostrar mas comentarios
     */

     let _setRemainingComments = function(postId, value){
       _hiddenComments[postId]['remaining'] = value;
     }

     let _getRemainingComments = function(postId){
       return _hiddenComments[postId]['remaining'];
     }

     let _createRemainingCommentsContainer = function(postId){
       if (_hiddenComments[postId] == undefined)
          _hiddenComments[postId] = new Object();
     }


     /**
      * METODOS QUE HACEN REQUEST VIA AJAX
      */


    let showOlderComments = function(trigger){
       let parentPost = trigger.closest(_component.post);
       let postId = _getComponentUID(parentPost);

       _createRemainingCommentsContainer(postId);

       let hiddenLi = trigger.siblings('ul').children(_component.comment+'.hidden');
       _setRemainingComments(postId, hiddenLi.length);

       if (_getRemainingComments(postId)<THRESHOLD){

         let done = function(data, textStatus, jqXHR){
           data = JSON.parse(data);
           let response = data['response'];
           // Si hay comentarios los agrego ocultos
           if (response.length){
             commentContainer = trigger.siblings('ul');
             for (var i = 0; i < response.length; i++) {
               element = _strhtmlToJObject(response[i]['body']);
               // oculto los comentarios y los agrego
               element.addClass('hidden');
               commentContainer.prepend(element);

               _updateMirror(postId, response[i]['body'], true);
             }
             let totalRemaining = response.length + _getRemainingComments(postId);

             //actualizo la cantidad de comentarios restantes
             _setRemainingComments(postId, totalRemaining);
              hiddenLi = trigger.siblings('ul').children(_component.comment+'.hidden');
           }
           if (_getRemainingComments(postId)>THRESHOLD)
              toShow = hiddenLi.slice(-THRESHOLD);
           else{
             toShow = hiddenLi;
             $(trigger).addClass('hidden');
           }
           toShow.removeClass('hidden');
           _setRemainingComments(postId, _getRemainingComments(postId) - toShow.length);

         }

         let error = function(data, textStatus, jqXHR){
           ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
         }

         let smallestComment = (_hiddenComments[postId]['remaining']>0) ? trigger.siblings('ul').find(_component.comment+'.hidden').first() : trigger.siblings('ul').find(_component.comment).first();
         let smallestCommentId = _getComponentUID(smallestComment);

         let url = getFrontendUrl() + '/user/post/prev-comments?uid_post='+postId+'&uid_comment='+smallestCommentId;
         _requester.request(url, done, error);
       } else{
         toShow = hiddenLi.slice(-THRESHOLD);
         _setRemainingComments(postId, _getRemainingComments(postId) - toShow.length);
         toShow.removeClass('hidden');
       }

     }

    let checkFoNewComments = function(){
        let params = _getParamsStr();
        let Query = new Object();
        Query['params'] =  params;


        let done = function(data, textStatus, jqXHR){
        //  data = JSON.parse(data);
          response = data['response'];
          if (response){
            for (var i = 0; i < response.length; i++) {
              let post_id = response[i]['post_id'];
              let body = response[i]['body'];
              let post_comments = _component.post+"_"+post_id+" .comment-section";

              _updateMirror(post_id, body);

              if ($(post_comments).hasClass('hidden'))
                 $(post_comments).removeClass('hidden')

              $(post_comments+" ul").append(body);
            }

          }
          setTimeout(function(){
            if ($(_component.container).length){
             _setNewCommentRequestInProgress(true)
              checkFoNewComments();
            } else {
              _setNewCommentRequestInProgress(false);
            }
          }, 30000);
        }

        let error = function(data, textStatus, jqXHR){
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
        }

        _requester.send(getFrontendUrl() + 'user/post/check-new-comments', Query, done, error);
    }

    let makeComment = function(form, urlTarget, element){
      let url = getFrontendUrl() + urlTarget;
      let formData = form.serialize();

      let done = function( data, textStatus, jqXHR ){
        data = JSON.parse(data);
        let response = data['response'];
        let body = response['body'];
        let id = response['id'];
        _updateMirror(id, body);
        if ($('.post_cmpt_'+id+'> div.comment-section').hasClass('hidden'))
          $('.post_cmpt_'+id+'> div.comment-section').removeClass('hidden');

        $('.post_cmpt_'+id+'> div.comment-section > ul').append(body);
      }

      let error = function( data, textStatus, jqXHR ){
        let modalBox = ModalBox.getInstance();
        let texts = Texts.getInstance();
        modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'));
      }

      _requester.send(url, formData, done, error, false);
    }

    let like = function(form, urlTarget, selector){
      let url = getFrontendUrl() + urlTarget;
      let formData = form.serialize();

      let element = selector;

      let done = function( data, textStatus, jqXHR ){
        data = JSON.parse(data);
        let dataFlag = data['flag'];
        let response = data['response'];

        let flags = Flags.getInstance();

        let id = response['uid_entity'];
        let selector = _getLikeElementSelector(element, id);


        /*
         * HAY QUE AGREGAR LOS CASE PARA LOS CASOS EN QUE
         * LA REQUEST RETORNE UNA DE LAS SIGUIENTES FLAGS:
         * 'SAVE_ERROR' Y 'DELETE_ERROR'
         */

        switch (dataFlag) {
          case flags.SAVE_SUCCESS:

            if (!_iLike(selector))
              _setILike(selector, true);

            if (!_hasLikes(selector))
              _setHasLikes(selector, true);

            _incLikeCounter(selector);
            break;
          case flags.DELETE_SUCCESS:
            if (_iLike(selector))
              _setILike(selector, false);

            let counter = _getLikeCounter(selector);

            if (parseInt(counter) < 2){
              _resetLikeCounter(selector);
              _setHasLikes(selector, false);
            } else
              _decLikeCounter(selector);
            break;
        }
      }

      let error = function( data, textStatus, jqXHR ){
        let modalBox = ModalBox.getInstance();
        let texts = Texts.getInstance();
        modalBox.show(texts.getT('ops'),texts.getT('errorBrowPage'));
      }

      _requester.send(url, formData, done, error, false);
    }

    let checkLikes = function(){
        let Query = new Object();
        Query['params'] =  _posts;

        let done = function(data, textStatus, jqXHR){
          data = JSON.parse(data);
          let response = data['response'];
          if (response){
            let comments = response['comments'];
            for (var i = 0; i < comments.length; i++) {
              let id = comments[i]['comment_id'];
              let storedCount = comments[i]['count'];

              let selector = _getLikeElementSelector('comment', id);
              _updateElementLike(selector, storedCount);
            }

            let posts = response['posts'];
            for (var i = 0; i < posts.length; i++) {
              let id = posts[i]['post_id'];
              let storedCount = posts[i]['count'];

              let selector = _getLikeElementSelector('post', id);
              _updateElementLike(selector, storedCount);
            }

            setTimeout(function(){
              if ($(_component.container).length){
                _setLikesRequestInProgress(true);
                checkLikes();
              } else{
                _setLikesRequestInProgress(false);
              }
            }, 30000);
          }

        }

        let error = function(data, textStatus, jqXHR){
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'),Texts.getInstance().getT('errorBrowPage'));
        }

        _requester.send(getFrontendUrl() + 'user/post/check-likes', Query, done, error);

    }

    /**
     * CALLBACKS DE BORRADO DE POSTS
     */

     let updateSocialBlock = function(data){
       data = JSON.parse(data);
       let response = data['response'];
       let flag = data['flag'];
       switch (flag) {
         case Flags.getInstance().DELETE_SUCCESS:
         let base_id = response['type'] == 'comment' ? _component.comment : _component.post;
          $(base_id+'_'+response['block']).remove();
           ModalBox.getInstance().clean();
           break;
        case Flags.getInstance().DELETE_ERROR:
          ModalBox.getInstance().show(Texts.getInstance().getT('ops'), response['error']);
          break;
         default:

       }
     }

    let _date;

    this.init = function(){
      _requester = Requester.getInstance();
      _setLikesRequestInProgress(false);
      _setNewCommentRequestInProgress(false);
    }

    this.run = function(){
      _posts = new Object();
      _controlPosts = new Object();
      _hiddenComments = new Object();

      _buildMirror();
      $(_component.container).off().on('keypress', '.post_cmpt .text_box', function(e){
         let charCode = (typeof e.which == "number") ? e.which : e.keyCode;
         let textInput = $(this).val();
         let lineBreak = (textInput.match(/\n/g)||[]).length;
         let url;

         if(charCode == 13 && !e.shiftKey) {
           if (textInput.length > lineBreak){
             let form = $(this).closest('form');
             if ($(this).closest('.comment_cmpt').html())
                url = '/user/post/reply-comment';
              else
                url = '/user/post/comment';

             autosize.update($('textarea.text_box'));
             makeComment(form, url);
             $(this).val("");

            return false;
         }
       }
     });

     $(_component.container).on('click', '.post-like', function(e){
       e.preventDefault();
       e.stopPropagation();
       like($(this), 'user/post/like-post', 'post');
     });

     $(_component.container).on('click', '.comment-like', function(e){
       e.preventDefault();
       e.stopPropagation();
       like($(this), 'user/post/like-comment', 'comment');
     });

     $(_component.container).on('click', _component.moreComments, function(){
       showOlderComments($(this));
     });

     $(_component.removeSocialBlock).on('click', 'button', function(){
       FormProcessor.getInstance().setCallback(updateSocialBlock);
     });

     let status = Status.getInstance();
     $(window).off(status.LAZY_LOADED).on(status.LAZY_LOADED, function(){

       let lastStoredId = _controlPosts['smallest_id'];
       let firstInsertedPost = $(_component.post+"_"+lastStoredId).next();

       let latestInsertedPost = $(_component.post).last();
       latestInsertedId = _getComponentUID(latestInsertedPost);

       let firstInsertedId = _getComponentUID(firstInsertedPost);
       while(firstInsertedId != latestInsertedId){

         let comments = firstInsertedPost.find(_component.comment).get();

         if (_posts[firstInsertedId] == undefined)
           _posts[firstInsertedId] = [];

         for (var i = 0; i < comments.length; i++) {
           let jComment = $(comments[i]);
           _updateMirror(firstInsertedId, jComment);
         }

         firstInsertedPost = firstInsertedPost.next();
         firstInsertedId = _getComponentUID(firstInsertedPost);
       }

       comments = latestInsertedPost.find(_component.comment).get();
       if (comments.length)
           for (var i = 0; i < comments.length; i++) {
             let jComment = $(comments[i]);
             _updateMirror(firstInsertedId, jComment);
           }
       else{
          _createNewEntryInMirror(latestInsertedId);
          _updateMirrorWithEmptyValue(latestInsertedId);
        }

      console.log(_posts);
     })

     setTimeout(function(){

       if (!_getNewCommentRequestInProgress()){
          checkFoNewComments();
       }


       if (!_getLikesRequestInProgress()){
         checkLikes();
       }

     }, TIME);
    }


  }

  var instance;

  return {
    getInstance: function(){
      if (!instance){
        instance = new Post();
        instance.init();
      }
      return instance;
    }
  }

})(jQuery);



let resizable = function(){
  autosize($('textarea.text_box'));
}



let wall = function(){
  resizable();

  let post = Post.getInstance();
  post.run();

}


$(function(){
  let register = Register.getInstance();
  register.addRegister('wall', wall, '#postContainer');

})
