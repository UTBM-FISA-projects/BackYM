<?php

namespace App\Misc;

use InvalidArgumentException;

/**
 * Représente une quantité de temps en heure et minutes pouvant dépasser 24 heures.
 */
class Time
{
    private int $hours;
    private int $minutes;

    /**
     * Contruit un objet temps qui gère les temps de plus de 24 heures (ex. 80:00).<br>
     * Si heure et minutes sont fournis et sont des nombres,
     * il sont utilisés respectivement pour les heures et les minutes.<br>
     * Si heure est fourni et est un nombre, heure utilise cette valeur et minute uitlise 0.<br>
     * Si heure est fourni et est un string, il est parsé avec la forme heures:minutes.<br>
     * Si aucun attribut n'est présent, le temps est 00:00.<br>
     *
     * @param string|int $hours
     * @param int|null        $minutes
     */
    public function __construct($hours = 0, ?int $minutes = 0)
    {
        if (is_int($hours) && is_int($minutes)) {
            $this->hours = $hours;
            $this->minutes = $minutes;
            return;
        }

        if (is_string($hours) && $minutes == 0) {
            $times = explode(':', $hours);
            $this->hours = (int)$times[0];
            $this->minutes = (int)$times[1];
            return;
        }

        throw new InvalidArgumentException("Impossible de construire l'objet " . self::class);
    }

    /**
     * Détermine si le temps actuel est strictement plus grand que le temps B.
     *
     * @param \App\Misc\Time $b
     * @return bool
     */
    public function isGreater(Time $b): bool
    {
        return $this->hours > $b->hours || ($this->hours == $b->hours && $this->minutes > $b->minutes);
    }

    /**
     * Détermine si le temps actuel est strictement plus petit que le temps B.
     *
     * @param \App\Misc\Time $b
     * @return bool
     */
    public function isLesser(Time $b): bool
    {
        return $this->hours < $b->hours || ($this->hours == $b->hours && $this->minutes < $b->minutes);
    }

    /**
     * Détermine si deux temps sont égaux.
     *
     * @param \App\Misc\Time $b
     * @return bool
     */
    public function isEqual(Time $b): bool
    {
        return $this->hours == $b->hours && $this->minutes == $b->minutes;
    }

    /**
     * Donne le temps stocké sous la forme HH:MM.
     * @return string
     */
    public function __toString(): string
    {
        return sprintf("%02d:%02d", $this->hours, $this->minutes);
    }
}
