<?php
namespace Source\Support;

/** Upload seguro de imagens; recebe o array de $_FILES e retorna caminho relativo à API. */
final class Upload
{
    public static function image(array $file, string $folder = 'portfolio', int $maxBytes = 8388608): string
    {
        if (!in_array($folder, ['portfolio', 'profiles'], true)) throw new \InvalidArgumentException('Pasta inválida.');
        $error = (int)($file['error'] ?? UPLOAD_ERR_NO_FILE);
        if ($error === UPLOAD_ERR_NO_FILE) throw new \InvalidArgumentException('Nenhum arquivo chegou à API. Use FormData com o campo image ou photo.');
        if ($error === UPLOAD_ERR_INI_SIZE || $error === UPLOAD_ERR_FORM_SIZE) throw new \LengthException('Arquivo maior que o limite do servidor.');
        if ($error !== UPLOAD_ERR_OK || empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) throw new \InvalidArgumentException('Nenhuma imagem válida foi enviada.');
        if ((int)$file['size'] > $maxBytes) throw new \LengthException('Imagem acima do limite permitido.');
        if ((int)$file['size'] <= 0) throw new \InvalidArgumentException('Arquivo vazio.');
        $mime = (new \finfo(FILEINFO_MIME_TYPE))->file($file['tmp_name']);
        $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp'];
        if (!isset($allowed[$mime]) || @getimagesize($file['tmp_name']) === false) throw new \InvalidArgumentException('Use uma imagem JPG, PNG ou WEBP válida.');
        $dir = dirname(__DIR__, 2) . '/uploads/' . $folder;
        if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) throw new \RuntimeException('Pasta de upload indisponível. Verifique api/uploads e permissões no XAMPP.');
        if (!is_writable($dir)) throw new \RuntimeException('Pasta de upload sem permissão de escrita: api/uploads/' . $folder);
        $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
        if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $filename)) throw new \RuntimeException('Falha ao gravar arquivo no XAMPP. Confira permissões e upload_tmp_dir do PHP.');
        if (!is_file($dir . '/' . $filename) || filesize($dir . '/' . $filename) < 1) throw new \RuntimeException('Arquivo não foi persistido no servidor.');
        return 'uploads/' . $folder . '/' . $filename;
    }

    public static function remove(string $relative, string $folder): void
    {
        if (!in_array($folder, ['portfolio', 'profiles'], true)) return;
        if (!preg_match('~^uploads/' . preg_quote($folder, '~') . '/[a-zA-Z0-9_-]+\.(jpg|png|webp)$~', $relative)) return;
        $path = dirname(__DIR__, 2) . '/' . $relative;
        if (is_file($path)) @unlink($path);
    }
}
