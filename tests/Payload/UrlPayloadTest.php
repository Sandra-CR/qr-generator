<?php

declare(strict_types = 1);

namespace App\Tests\Payload;

use App\Payload\UrlPayload;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class UrlPayloadTest extends TestCase
{
  public function testValidUrlReturnsRawString(): void
  {
    $url = 'https://github.com';
    $payload = new UrlPayload($url);

    $this->assertSame($url,$payload->toRawString());
  }

  public function testInvalidUrlThrowsException(): void 
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage("L'URL fournie est invalide.");

    new UrlPayload('not-a-valid-url');
  }
}