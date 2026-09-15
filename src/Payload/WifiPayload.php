<?php

declare(strict_types = 1);

namespace App\Payload;

use InvalidArgumentException;

final readonly class WifiPayload implements PayloadInterface
{
  public function __construct(
    private string $ssid,
    private string $password = '',
    private string $encryption = 'WPA'
  ) {
    if ($this->ssid === '') {
      throw new InvalidArgumentException("Le SSID ne peut pas être vide.");
    }
  }

  public function toRawString(): string 
  {
    $escapedSsid = addcslashes($this->ssid, '\;,:"');
    $escapedPassword = addcslashes($this->password, '\;,:"');

    return sprintf(
      'WIFI:T:%s;S:%s;P:%s;;',
      $this->encryption,
      $escapedSsid,
      $escapedPassword
    );
  }
}