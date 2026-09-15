<?php

declare(strict_types = 1);

namespace App\Tests\Config;

use App\Config\ErrorCorrectionLevel;
use App\Config\QrOptions;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class QrOptionsTest extends TestCase
{
  public function testDefaultValues(): void {
    $options = new QrOptions();

    $this->assertSame(300, $options->size);
    $this->assertSame(10, $options->margin);
    $this->assertSame(ErrorCorrectionLevel::MEDIUM, $options->errorCorrectionLevel);
  }

  public function testCustomValues(): void 
  {
    $options = new QrOptions(size: 500, margin: 20, errorCorrectionLevel: ErrorCorrectionLevel::HIGH);

    $this->assertSame(500, $options->size);
    $this->assertSame(20, $options->margin);
    $this->assertSame(ErrorCorrectionLevel::HIGH, $options->errorCorrectionLevel);
  }

  public function testSizeTooSmallThrowsException(): void 
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('La taille du QR code doit être comprise entre 50 et 2000 pixels.');

    new QrOptions(size: 40);
  }

  public function testNegativeMarginThrowsException(): void 
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('La marge ne peut pas être négative.');

    new QrOptions(margin: -1);
  }
}