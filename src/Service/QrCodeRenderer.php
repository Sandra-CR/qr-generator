<?php

declare(strict_types=1);

namespace App\Service;

use App\Config\ErrorCorrectionLevel;
use App\Config\QrOptions;
use App\Payload\PayloadInterface;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions as ChillerlanOptions;

final class QrCodeRenderer
{
	public function render(PayloadInterface $payload, QrOptions $options = new QrOptions()): string
	{
		// Mapper notre enum vers le niveau d'erreur attendu par la bibliothèque
		$eccLevel = match ($options->errorCorrectionLevel) {
			ErrorCorrectionLevel::LOW => EccLevel::L,
			ErrorCorrectionLevel::MEDIUM => EccLevel::M,
			ErrorCorrectionLevel::QUARTILE => EccLevel::Q,
			ErrorCorrectionLevel::HIGH => EccLevel::H,
		};

		$qrCode = new QRCode(new ChillerlanOptions([
			'eccLevel' => $eccLevel,
		]));

		$matrix = $qrCode->getQRMatrix($payload->toRawString());
		$matrixSize = $matrix->getSize();

		// Initialiser l'image GD
		$totalSize = $options->size;
		$margin = $options->margin;
		$image = imagecreatetruecolor($totalSize, $totalSize);

		$bgWhite = (int) imagecolorallocate($image, 255, 255, 255);
		$fgBlack = (int) imagecolorallocate($image, 0, 0, 0);

		// Remplissage du fond blanc
		imagefilledrectangle($image, 0, 0, $totalSize - 1, $totalSize - 1, $bgWhite);

		// Calcul de l'échelle d'un module
		$drawableSize = $totalSize - (2 * $margin);
		$moduleScale = $drawableSize / $matrixSize;

		// Tracé des modules sur l'image
		for ($y = 0; $y < $matrixSize; $y++) {
			for ($x = 0; $x < $matrixSize; $x++) {
				if ($matrix->check($x, $y)) {
					$x1 = (int) round($margin + ($x * $moduleScale));
					$y1 = (int) round($margin + ($y * $moduleScale));
					$x2 = (int) round($margin + (($x + 1) * $moduleScale) - 1);
					$y2 = (int) round($margin + (($y + 1) * $moduleScale) - 1);

					imagefilledrectangle($image, $x1, $y1, $x2, $y2, $fgBlack);
				}
			}
		}

		// Capture de la sortie binaire PNG
		ob_start();
		imagepng($image);
		$pngData = (string) ob_get_clean();

		imagedestroy($image);

		return $pngData;
	}
}