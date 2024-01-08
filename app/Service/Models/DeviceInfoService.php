<?php

namespace App\Service\Models;

class DeviceInfoService
{
    /**
     * Récupère la classe d'icône en fonction du périphérique.
     *
     * @param  string  $device Le nom du périphérique.
     * @return string La classe d'icône.
     */
    public static function getIconByDevice(string $device): string
    {
        return match ($device) {
            'Windows|Chrome' => 'fa-brands fa-windows',
            'GNU/Linux|Chrome' => 'fa-brands fa-linux',
            default => 'fa-solid fa-question-circle',
        };
    }

    /**
     * Vérifie si le périphérique est le périphérique actuel.
     *
     * @param  string  $user_agent Le user agent du périphérique.
     * @param  string  $ip L'adresse IP du périphérique.
     * @return bool Vrai si le périphérique est le périphérique actuel.
     */
    public static function isCurrentDevice(string $user_agent, string $ip): bool
    {
        return $user_agent === request()->userAgent() && $ip === request()->ip();
    }

    /**
     * Vérifie si un appareil a été piraté.
     *
     * @param  string|null  $device_hijacked_at Le timestamp indiquant quand l'appareil a été piraté.
     * @return bool Indique si l'appareil a été piraté ou non.
     */
    public static function deviceIsHijack(?string $device_hijacked_at)
    {
        return $device_hijacked_at !== null;
    }
}
