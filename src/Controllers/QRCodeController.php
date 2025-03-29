<?php
namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Label\Font\NotoSans;

class QRCodeController
{
    public function generate(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
        
        // Get the text to encode from query parameters or use default
        $text = $params['text'] ?? 'Hello World';
        
        // Get optional parameters with defaults
        $size = isset($params['size']) ? (int)$params['size'] : 300;
        $margin = isset($params['margin']) ? (int)$params['margin'] : 10;
        
        // Create QR code instance
        $qrCode = QrCode::create($text)
            ->setSize($size)
            ->setMargin($margin)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create writer
        $writer = new PngWriter();
        
        // Create QR code result
        $result = $writer->write($qrCode);

        // Add label if specified
        if (isset($params['label'])) {
            $label = Label::create($params['label'])
                ->setFont(new NotoSans(12))
                ->setTextColor(new Color(0, 0, 0));
            
            $result = $writer->write($qrCode, null, $label);
        }
        
        // Get the content type (e.g., image/png)
        $contentType = $result->getMimeType();

        // Return response with image
        $response = $response->withHeader('Content-Type', $contentType);
        $response->getBody()->write($result->getString());
        
        return $response;
    }

    public function generateBase64(Request $request, Response $response)
    {
        $params = $request->getQueryParams();
        
        // Get the text to encode from query parameters or use default
        $text = $params['text'] ?? 'Hello World';
        
        // Create QR code instance
        $qrCode = QrCode::create($text)
            ->setSize(300)
            ->setMargin(10)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));

        // Create writer
        $writer = new PngWriter();
        
        // Create QR code result
        $result = $writer->write($qrCode);

        // Add label if specified
        if (isset($params['label'])) {
            $label = Label::create($params['label'])
                ->setFont(new NotoSans(12))
                ->setTextColor(new Color(0, 0, 0));
            
            $result = $writer->write($qrCode, null, $label);
        }
        
        // Get base64 string
        $base64 = $result->getDataUri();
        
        $response->getBody()->write(json_encode([
            'base64' => $base64
        ]));
        
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}