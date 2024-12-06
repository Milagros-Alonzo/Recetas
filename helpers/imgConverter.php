<?php
class ImgConverter
{
    private $quality;

    public function __construct($quality = 75)
    {
        $this->quality = $quality;
    }

    public function convertToWebp($file)
    {
        // Determinar la ruta del archivo
        $filePath = is_array($file) && isset($file['tmp_name']) ? $file['tmp_name'] : $file;
    
        // Validar que el archivo exista
        if (!file_exists($filePath)) {
            throw new Exception("El archivo no existe: $filePath");
        }
    
        // Obtener el tipo MIME real del archivo
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $realMime = finfo_file($fileInfo, $filePath);
        finfo_close($fileInfo);
    
        // Revisar el encabezado para detectar WebP renombrados
        $fp = fopen($filePath, 'rb');
        $header = fread($fp, 12);
        fclose($fp);
    
        if (substr($header, 0, 4) === "RIFF" && substr($header, 8, 4) === "WEBP") {
            $realMime = 'image/webp';
        }
    
        // Verificar tipo de archivo permitido
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($realMime, $allowedTypes)) {
            throw new Exception("Formato no compatible: $realMime");
        }
    
        // Crear la imagen según el tipo MIME real
        switch ($realMime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filePath);
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filePath);
                break;
            case 'image/webp':
                $image = imagecreatefromwebp($filePath);
                break;
            default:
                throw new Exception("Formato no compatible: $realMime");
        }
    
        // Crear un recurso temporal en memoria
        ob_start();
        if (!imagewebp($image, null, $this->quality)) {
            throw new Exception("Error al convertir la imagen a WebP.");
        }
    
        // Capturar los datos binarios de la imagen convertida
        $webpData = ob_get_contents();
        ob_end_clean();
    
        // Liberar recursos
        imagedestroy($image);
    
        return $webpData;
    }
    
    

    public function uploadImage($file, $uploadDir)
{   

    // Verificar errores
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('Error al subir la imagen.');
    }

    // Verificar tipo de archivo permitido
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('El tipo de archivo no es válido.');
    }

    // Crear un nombre único para la imagen
    $uniqueName = uniqid('img_', true) . '.webp';
    $uploadPath = $uploadDir . $uniqueName;

    // Convertir a WebP
    $webpData = $this->convertToWebp($file);

    // Guardar la imagen WebP en el servidor
    if (!file_put_contents($uploadPath, $webpData)) {
        throw new Exception('No se pudo guardar la imagen convertida.');
    }

    return $uniqueName;
}

}
