<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Password extends \Core\Controller
{
    public function forgotAction()
    {
        View::renderTemplate('Password/forgot.html');
    }

    public function requestResetAction()
    {
        User::sendPasswordRest($_POST['email']);

        View::renderTemplate('Password/reset_requested.html');
    }

    /**
     * Show the reset password form
     * @return void
     */
    public function resetAction()
    {
        $token = $this->route_params['token'];

        $user = $this->getUserOrExit($token);

        View::renderTemplate('Password/reset.html', [
            'token' => $token
        ]);
    }

    /**
     * Reset the user's password
     *
     * @return void
     */
    public function resetPasswordAction()
    {
        $token = $_POST['token'];

        $user = $this->getUserOrExit($token);

        if ($user->resetPassword($_POST['password'])) {

            View::renderTemplate('Password/reset_success.html');

        } else {

            View::renderTemplate('Password/reset.html', [
                'token' => $token,
                'user'  => $user
            ]);
        }
    }

    protected function getUserOrExit($token)
    {
        $user = User::findByPasswordReset($token);

        if ($user) {
            return $user;
        }

        View::renderTemplate('Password/token_expired.html');
        exit;
    }
}