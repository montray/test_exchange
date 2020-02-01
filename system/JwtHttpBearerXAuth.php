<?php
/**
 * Author: Aleksey Mikhailov
 * Date: 31.01.2020
 * Time: 15:36
 */

namespace app\system;


use sizeg\jwt\JwtHttpBearerAuth;

class JwtHttpBearerXAuth extends JwtHttpBearerAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get('X-Authorization');
        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches)) {
            $token = $this->loadToken($matches[1]);
            if ($token === null) {
                return null;
            }

            if ($this->auth) {
                $identity = call_user_func($this->auth, $token, get_class($this));
            } else {
                $identity = $user->loginByAccessToken($token, get_class($this));
            }

            return $identity;
        }

        return null;
    }
}