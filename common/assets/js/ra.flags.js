
var Flags = (function(){

  function Flags(){

    this.properties = {};

    Object.defineProperties(this.properties, {
      'SUCCESS'             : { value: 'success', writable: false, configurable: false, },
      'ERROR'               : { value: 'error',   writable: false, configurable: false, },

      'INVALID_TOKEN'       : { value: 9996, writable: false, configurable: false, },
      'MAIL_SEND_RESULT'    : { value: 9997, writable: false, configurable: false, },
      'ERROR'               : { value: 9998, writable: false, configurable: false, },
      'WARNING'             : { value: 9999, writable: false, configurable: false, },
      'ALL_OK'              : { value: 10000, writable: false, configurable: false, },
      'LOGIN_CREDENTIAL'    : { value: 10001, writable: false, configurable: false, },
      'FORM_VALIDATION'     : { value: 10002, writable: false, configurable: false, },
      'FORM_LOAD_MODEL'     : { value: 10003, writable: false, configurable: false, },

      'ERORR_UPDATE_DB'     : { value: 20000, writable: false, configurable: false, },
      'ALREADY_EXIST'       : { value: 20001, writable: false, configurable: false, },
      'SAVE_ERROR'          : { value: 20002, writable: false, configurable: false, },
      'SAVE_SUCCESS'        : { value: 20003, writable: false, configurable: false, },
      'DELETE_ERROR'        : { value: 20004, writable: false, configurable: false, },
      'DELETE_SUCCESS'      : { value: 20005, writable: false, configurable: false, },
      'UPDATE_ERROR'        : { value: 20006, writable: false, configurable: false, },
      'UPDATE_SUCCESS'      : { value: 20007, writable: false, configurable: false, },
      'LINK_SUCCESS'        : { value: 20008, writable: false, configurable: false, },
      'LINK_ERROR'          : { value: 20009, writable: false, configurable: false, },
      'UNLINK_SUCCESS'      : { value: 20010, writable: false, configurable: false, },
      'UNLINK_ERROR'        : { value: 20011, writable: false, configurable: false, },
      'UPLOAD_SUCCESS'      : { value: 20012, writable: false, configurable: false, },
      'UPLOAD_ERROR'        : { value: 20013, writable: false, configurable: false, },

      'UNAUTHORIZED_USER'   : { value: 30000, writable: false, configurable: false, },
      'USER_NOT_FOUND'      : { value: 30001, writable: false, configurable: false, },
      'USER_DISABLED'       : { value: 30002, writable: false, configurable: false, },

      'NOTIFICACTION_SAVE_ERROR'    : { value: 40000, writable: false, configurable: false, },
      'NOTIFICATION_SAVE_SUCCESS'   : { value: 40001, writable: false, configurable: false, },
      'NOTIFICATION_UPDATE_ERROR'   : { value: 40002, writable: false, configurable: false, },
      'NOTIFICATION_UPDATE_SUCCESS' : { value: 40003, writable: false, configurable: false, },
      'NOTIFICATION_INVALID_ID'     : { value: 40004, writable: false, configurable: false, },

      'RELATIONSHIP_SAVE_ERROR'     : { value: 50000, writable: false, configurable: false, },
      'RELATIONSHIP_SAVE_SUCCESS'   : { value: 50001, writable: false, configurable: false, },
      'RELATIONSHIP_UPDATE_ERROR'   : { value: 50002, writable: false, configurable: false, },

      'COMMENT_SAVE_ERROR'          : { value: 60000, writable: false, configurable: false, },
      'COMMENT_SAVE_SUCCESS'        : { value: 60001, writable: false, configurable: false, },
      'POST_FOLLOW_SAVE_ERROR'      : { value: 60002, writable: false, configurable: false, },

    });
  }

  var instance;

  return {
    getInstance: function(){
      if (!instance)
        instance = new Flags();
      return instance.properties;
    }
  }
  })();
