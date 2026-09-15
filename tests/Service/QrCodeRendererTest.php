<?php

declare(strict_types = 1);

namespace App\Tests\Service;

use App\Config\QrOptions;
use App\Payload\UrlPayload;
use App\Service\QrCodeRenderer;
use PHPUnit\Framework\TestCase;

final class QrCodeRendererTest extends TestCase
{
  public function testRenderProducesValidPngImageWithExpectedDimensions(): void 
  {
    $renderer = new QrCodeRenderer();
    $payload = new UrlPayload('https://example.com');
    $options = new Qroptions(size: 400);

    $pngData = $renderer->render($payload, $options);

    // Vérification que la donnée n'est pas vide
    $this->assertNotEmpty($pngData);

    // Vérification de la signature binaire PNG
    $this->assertStringStartsWith("\x89PNG\r\n\x1a\n", $pngData);

    // Vérification des dimensions de l'image
    $imageInfo = getimagesizefromstring($pngData);
    $this->assertNotFalse($imageInfo);
    $this->assertSame(400, $imageInfo[0]); // Largeur
    $this->assertSame(400, $imageInfo[1]); // Hauteur
  }
}