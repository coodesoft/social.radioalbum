
var Register = (function($){

  function Register(){

    let widgets = [];

    let enviroments = [];

    let lazy_widgets = [];

    let _addEnviroment = function(targets, env){
      if (Array.isArray(targets)){
        for (var i = 0; i < targets.length; i++) {
          let key = targets[i];

          if (!(key in enviroments))
            enviroments[key] = env;
        }
      } else
          if (!(targets in enviroments))
            enviroments[targets] = env;

    }

    let _setEnviroment = function(targets, env){
      _refreshEnviroments();
      _addEnviroment(target, env);
    }

    let _getEnviroments = function(){
      return enviroments;
    }

    let _removeEnviroment = function(env){
      let envs = _getEnviroments();
      for (var key in envs) {
        if (envs.hasOwnProperty(key)) {
          if (envs[key] == env)
            delete envs[key];
        }
      }
    }

    let _refreshEnviroments = function(){
      enviroments = [];
    }


    let _register = function(key, param){
      if (!(key in widgets))
        widgets[key] = param;
    }

    let _unregister = function(key){
      delete widgets[key];
    }

    let _lazyRegister = function(key, param){
      if (!(key in lazy_widgets))
        lazy_widgets[key] = param;
    }

    let _lazyUnregister = function(key){
      delete lazy_widgets[key];
    }

    let _getBehavior = function(env){
      return (env != undefined) ? widgets[env] : null;
    }

    /* ****************
     * Métodos Públicos
     * ****************
     */

    this.addRegister = function(env, param, targets){
      _addEnviroment(targets, env);
      _register(env, param);
    }

    this.setRegister = function(env, param, targets){
      _setEnviroment(targets, env);
      _register(env, param);
    }

    this.removeRegister = function(env){
      _removeEnviroment(env);
      _unregister(env);
    }

    this.addLazyRegister = function(env, param, targets){
      _addEnviroment(targets, env);
      _lazyRegister(env, param);
    }

    this.removeLazyRegister = function(env){
      _removeEnviroment(env);
      _lazyUnregister(env)
    }

    this.run = function(){
      let enviroments = _getEnviroments();

      for (var target in enviroments) {
        if (enviroments.hasOwnProperty(target)) {
          if ($(target).length>0){
            let env = enviroments[target];
            fn = _getBehavior(env);
            console.log(env);
            fn();
          }
        }
      }
    }

    this.log = function(){
      let enviroments = _getEnviroments();
      console.log('############### Enviroments ###############');
      for (var variable in enviroments) {
        if (enviroments.hasOwnProperty(variable)) {
          console.log(variable+": "+enviroments[variable]);
        }
      }
      console.log('############### Behaviors ###############');
      for (var env in widgets) {
        if (widgets.hasOwnProperty(env)) {
          console.log(env+": "+widgets[env]);
        }
      }
    }
  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Register();
      return instance;
    }
  }
})(jQuery);
