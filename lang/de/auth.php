<?php declare(strict_types=1);

return [

    'register' => [
        'success' => [
            'response' => [
                'message' => 'Du wurdest erfolgreich registriert! Bitte fahre mit der Überprüfung deines Kontos fort.',
            ],
        ],
        'failed' => [
            'request' => [
                'firstName' => [
                    'required' => 'Bitte gib deinen Vornamen an.',
                    'string' => 'Bitte gib einen gültigen Vornamen ein.',
                    'min' => 'Dein Vorname darf nicht weniger als :min Zeichen haben.',
                    'max' => 'Dein Vorname darf nicht mehr als :max Zeichen haben.',
                ],
                'lastName' => [
                    'required' => 'Bitte gib deinen Nachnamen an.',
                    'string' => 'Bitte gib einen gültigen Nachnamen ein.',
                    'min' => 'Dein Nachname darf nicht weniger als :min Zeichen haben.',
                    'max' => 'Dein Nachname darf nicht mehr als :max Zeichen haben.',
                ],
                'email' => [
                    'required' => 'Bitte gib deine E-Mail-Adresse an.',
                    'email' => 'Bitte gib eine gültige E-Mail-Adresse ein.',
                    'unique' => 'Diese E-Mail-Adresse wird bereits verwendet. Bitte verwende eine andere E-Mail-Adresse.',
                    'min' => 'Die E-Mail-Adresse sollte mindestens :min Zeichen haben.',
                    'max' => 'Die E-Mail-Adresse darf nicht mehr als :max Zeichen haben.',
                ],
                'password' => [
                    'required' => 'Ein Passwort ist erforderlich. Bitte gib ein Passwort ein.',
                    'string' => 'Bitte gib ein gültiges Passwort ein.',
                    'confirmed' => 'Die Passwortbestätigung stimmt nicht überein.',
                    'min' => 'Das Passwort sollte mindestens :min Zeichen lang sein.',
                    'max' => 'Das Passwort darf nicht mehr als :max Zeichen haben.',
                ],
            ],
            'response' => [
                'message' => 'Entschuldigung, etwas ist schiefgegangen, während wir versuchen, dich zu registrieren!',
            ],
        ],
    ],

    # 'failed' => 'These credentials do not match our records.',
    # 'password' => 'The provided password is incorrect.',
    # 'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
];
