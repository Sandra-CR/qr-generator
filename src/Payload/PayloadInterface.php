<?php

declare(strict_types = 1);

namespace App\Payload;

interface PayloadInterface
{
  // Transforme l'objet en chaîne brute formatée selon la norme attendue par les lecteurs QR.
  public function toRawString(): string;
}