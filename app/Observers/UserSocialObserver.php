<?php

namespace App\Observers;

use App\Models\UserSocial;

class UserSocialObserver 
{
    public function created(UserSocial $userSocial)
    {
        $this->handleRegisteredEvent('created', $userSocial);
    }

    public function handleRegisteredEvent($event, UserSocial $userSocial)
    {
        $class = config("social.events.{$userSocial->service}.{$event}", null);
        
        if (!$class) {
            return;
        }

        event(new $class($userSocial->user()->first()));
    }
}