<?php

declare(strict_types = 1);

namespace App\Payload;

use InvalidArgumentException;

final readonly class UrlPayload implements PayloadInterface
{
  public function __construct(
    private string $url
  ) {
    // filter_var renvoie false si la chaîne n'est pas une URL valide
    if (filter_var($this->url, FILTER_VALIDATE_URL) === false) {
      throw new InvalidArgumentException("L'URL fournie est invalide.");
    }
  }

  public function toRawString() : string 
  {
    return $this->url;
  }
}