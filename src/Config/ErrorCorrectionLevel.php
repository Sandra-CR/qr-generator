<?php

declare(strict_types = 1);

namespace App\Config;

enum ErrorCorrectionLevel: string
{
  case LOW = 'L';
  case MEDIUM = 'M';
  case QUARTILE = 'Q';
  case HIGH = 'H';
}