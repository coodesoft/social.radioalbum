<?php

namespace common\util;

class Flags{

    const INVALID_TOKEN     = 9995;
    const MAIL_SEND_RESULT  = 9996;
    const INVALID_ID        = 9997;
    const ERROR             = 9998;
    const WARNING           = 9999;
    const ALL_OK            = 10000;

    /*
     *  Data form validation
     */
    const LOGIN_CREDENTIAL  = 10001;

    const FORM_VALIDATION   = 10002;

    const FORM_LOAD_MODEL   = 10003;

    /*
     *  DB actions
     */

    const ERROR_UPDATE_DB   = 20000;

    const ALREADY_EXIST     = 20001;

    const SAVE_ERROR        = 20002;

    const SAVE_SUCCESS      = 20003;

    const DELETE_ERROR      = 20004;

    const DELETE_SUCCESS    = 20005;

    const UPDATE_ERROR      = 20006;

    const UPDATE_SUCCESS    = 20007;

    const LINK_SUCCESS      = 20008;

    const LINK_ERROR        = 20009;

    const UNLINK_SUCCESS    = 20010;

    const UNLINK_ERROR      = 20011;

    const UPLOAD_SUCCESS    = 20012;

    const UPLOAD_ERROR      = 20013;

    /*
     *  Authorization
     */
    const UNAUTHORIZED_USER   = 30000;

    const USER_NOT_FOUND      = 30001;

    const USER_DISABLED       = 30002;

    const AUTH_USER_LOGIN     = 30003;

    const AUTH_USER_SIGNUP    = 30004;

    const AUTH_SIGNUP_ERROR   = 30005;


    /*
     * Social Flags;
     */
    const NOTIFICACTION_SAVE_ERROR    = 40000;

    const NOTIFICATION_SAVE_SUCCESS   = 40001;

    const NOTIFICATION_UPDATE_ERROR   = 40002;

    const NOTIFICATION_UPDATE_SUCCESS = 40003;

    const NOTIFICATION_INVALID_ID     = 40004;


    const RELATIONSHIP_SAVE_ERROR     = 50000;

    const RELATIONSHIP_SAVE_SUCCESS   = 50001;

    const RELATIONSHIP_UPDATE_ERROR   = 50002;


    const COMMENT_SAVE_ERROR          = 60001;

    const COMMENT_SAVE_SUCCESS        = 60002;

    const POST_FOLLOW_SAVE_ERROR      = 60002;




}

?>
