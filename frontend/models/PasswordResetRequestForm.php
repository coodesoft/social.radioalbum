<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\helpers\Html;

use common\util\Response;
use common\util\Flags;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {
    public $email;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'username' => $this->email,
        ]);

        if (!$user)
            return Response::getInstance(false, Flags::USER_NOT_FOUND);

        if ($user->status == User::STATUS_INACTIVE)
          return Response::getInstance(false, Flags::USER_DISABLED);

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save())
                return Response::getInstance(false, Flags::INVALID_TOKEN);;
        }

        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'From: Radioalbum <info@radioalbum.com.ar>' . "\r\n";

        $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
        $profile = $user->getAssociatedModel()->profile;
        $url = Html::a(Html::encode($resetLink), $resetLink);

        $hi = \Yii::t('app', 'hi, {user}', ['user' => $profile->name ]);
        $followLink = \Yii::t('app', 'clickResetPassLink');

        $body  = '<div>';
        $body .= '<p>' . $hi . '</p>';
        $body .= '<p>' . $followLink . '</p>';
        $body .= '<p>' . $url . '</p>';
        $body .= '</div>';

        $result = mail($user->username, 'Recuperación de contraseña de cuenta RadioAlbum', $body, $cabeceras);
        return Response::getInstance($result, Flags::MAIL_SEND_RESULT);

        /*
        $message = Yii::$app->mailer->compose(
                      ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                      ['user' => $user]
                    )->toString();
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject(Yii::t('app', 'resetPassword') . ' ' . Yii::$app->name)
                    ->send();
            */
    }
}
