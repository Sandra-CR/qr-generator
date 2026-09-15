<?php

declare(strict_types = 1);

namespace App\Tests\Payload;

use App\Payload\WifiPayload;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class WifiPayloadTest extends TestCase
{
  public function testValidWifiPayloadFormattedCorrectly() : void 
  {
    $payload = new WifiPayload('MonWifi', 'Secret123', 'WPA');

    $this->assertSame('WIFI:T:WPA;S:MonWifi;P:Secret123;;', $payload->toRawString());
  }

  public function testWifiPayloadEscapesSpecialCharacters() : void 
  {
    $payload = new WifiPayload('Mon;Wifi:Box', 'pass;word', 'WPA');

    $this->assertSame('WIFI:T:WPA;S:Mon\;Wifi\:Box;P:pass\;word;;', $payload->toRawString());
  }

  public function testEmptySsidThrowsException() : void 
  {
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Le SSID ne peut pas être vide.');

    new WifiPayload('', 'Secret123');
  }
}