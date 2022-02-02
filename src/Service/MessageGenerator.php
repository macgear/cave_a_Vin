<?php

namespace App\Service;

class MessageGenerator
 {

    public function getMessage(string $cleMsg): string
    {

        $messages = [
            'loginOk' => 'Bienvenue',
            'csrfNonOk' => 'jeton CSRF invalide',
            'trois' => 'troisieme message',
                ];

        
        return $messages[$cleMsg];

    }

 }






