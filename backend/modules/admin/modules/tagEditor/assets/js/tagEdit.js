
let tagEditorCallback = function(data){
  data = JSON.parse(data);
  let response = data['response'];
  let flags = Flags.getInstance();
  dataFlag = data['flag'];
  let error = (dataFlag == flags.SAVE_ERROR ||
               dataFlag == flags.WARNING) ? true : false;

  let alert = getAlertBox(response['text'], response['type']);
  $('#tagEditorNavigationArea .messages').html(alert);

  let browser = Browser.getInstance();


    if (!error){
      setTimeout(function(){
      let tagEditor = TagEditor.getInstance();
      tagEditor.navigateToLastLocation();
      },500);
    }
}

let tagEditorNavAdmin = function(){
  let tagEditor = TagEditor.getInstance();
  tagEditor.init();
  tagEditor.run();

  let formProcessor = FormProcessor.getInstance();
  formProcessor.setCallback(tagEditorCallback);


}



let register = Register.getInstance();
register.addRegister('tagEditorNav', tagEditorNavAdmin, '#tagEditorNavigationArea');
