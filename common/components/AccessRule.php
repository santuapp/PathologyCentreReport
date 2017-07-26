<?php

namespace common\components;


class AccessRule extends \yii\filters\AccessRule {

    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role === '?') {
                /*
                 * Changed: Any user can access page if role is ?
                 */
                return true;
                /*
                if ($user->getIsGuest()) {
                    return true;
                }*/
            } elseif ($role === '@') {
                if (!$user->getIsGuest()) {
                    return true;
                }
            // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $role === $user->identity->user_type) {
                return true;
            }
        }

        return false;
    }
}