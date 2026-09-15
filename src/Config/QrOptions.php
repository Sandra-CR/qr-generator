<?php

declare(strict_types=1);

namespace App\Config;

use InvalidArgumentException;

final readonly class QrOptions
{
  public function __construct(
    public int $size = 300,
    public int $margin = 10,
    public ErrorCorrectionLevel $errorCorrectionLevel = ErrorCorrectionLevel::MEDIUM
  ) {
    if ($this->size < 50 || $this->size > 2000) {
      throw new InvalidArgumentException('La taille du QR code doit être comprise entre 50 et 2000 pixels.');
    }

    if ($this->margin < 0) {
      throw new InvalidArgumentException('La marge ne peut pas être négative.');
    }
  }
}