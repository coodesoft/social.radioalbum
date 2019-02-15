
let callback = function(data){
  data = JSON.parse(data);
  let response = data['response'];

  let modal = ModalBox.getInstance();
  let texts = Texts.getInstance();

  let msg = response['entity'] == 'album' ? 'shareAlbumSuccess' : 'sharePostSuccess';

  if (data['flag'] == Flags.getInstance().ALL_OK )
    modal.show(texts.getT('success'),texts.getT(msg));
 else
    modal.show(texts.getT('ops'),texts.getT('unknownError'));
}

let widget = function(){
    autosize($('textarea.share_text_box'));

    FormProcessor.getInstance().setCallback(callback);
}

Register.getInstance().addRegister('share', widget, '#sharePost');
