<?php

namespace App\Services;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QrCodeService
{
    /**
     * Generate a QR code and save it to storage.
     *
     * @param  string  $data
     * @return array{svg: string, png: string|null}  The paths to the saved QR codes
     */
    public function generate(string $data): array
    {
        $uuid = (string) Str::uuid();
        $directory = 'qrcodes';
        $svgFilename = $directory . '/' . $uuid . '.svg';
        $pngFilename = $directory . '/' . $uuid . '.png';

        Storage::disk('public')->makeDirectory($directory);

        // SVG generation
        $svgRenderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );

        $svgWriter = new Writer($svgRenderer);
        $svgContent = $svgWriter->writeString($data);
        Storage::disk('public')->put($svgFilename, $svgContent);

        $pngPath = null;

        if (extension_loaded('imagick')) {
            try {
                $imagick = new \Imagick();
                $imagick->readImageBlob($svgContent);
                $imagick->setImageFormat('png');
                Storage::disk('public')->put($pngFilename, $imagick->getImageBlob());
                $pngPath = $pngFilename;
            } catch (\Throwable $e) {
                $pngPath = null;
            }
        }

        return [
            'svg' => $svgFilename,
            'png' => $pngPath,
        ];
    }

    /**
     * Get the public URL for a QR code.
     *
     * @param  string  $path
     * @return string
     */
    public function getUrl(string $path): string
    {
        return Storage::disk('public')->url($path);
    }

    /**
     * Delete a QR code from storage.
     *
     * @param  string  $path
     * @return bool
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        
        return false;
    }

    /**
     * Generate a QR code and return it as a data URL.
     *
     * @param  string  $data
     * @return string
     */
    public function generateAsDataUrl(string $data): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        
        $writer = new Writer($renderer);
        $qrCodeContent = $writer->writeString($data);
        
        return 'data:image/svg+xml;base64,' . base64_encode($qrCodeContent);
    }
}
