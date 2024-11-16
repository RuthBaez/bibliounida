<?php

namespace App\Core;

use App\Utils\Authentication\Authentication;

class helpers {
    public function generateUrl($controller, $action = '', $data_for_get = [])
    {
        $data_url = [];

        if ($action !== '') {
            $action = "&action={$action}";
        }

        foreach ($data_for_get as $key => $value) {
            $data_url[] = "{$key}={$value}";
        }

        $data_url = implode('&', $data_url);

        if ($data_url !== '')
            $data_url = "&{$data_url}";

        return "?controller={$controller}{$action}{$data_url}";
    }

    public function getMessage(array $message)
    {
        $icon = isset($message['icon']) ? "<span class=\"fas fa-{$message['icon']}\"></span>" : "";

        if (isset($message['type']) && isset($message['notification'])) {
            return "
                <div class=\"alert alert-{$message['type']} alert-dismissible fade show\" role=\"alert\">
                    {$icon} {$message['notification']}
                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"alert\" aria-label=\"Close\"></button>
                </div>
            ";
        }

        return "";
    }

    public function isEnabled($is_enabled)
    {
        if ($is_enabled) {
            return '<span class="fas fa-circle text-success"></span> Activo';
        }

        return '<span class="fas fa-circle text-danger"></span> Inactivo';
    }

    public function isEnabledOption($is_enabled) {
        if ($is_enabled) {
            return '
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            ';
        }

        return '
            <option value="0">Inactivo</option>
            <option value="1">Activo</option>
        ';
    }

    public function getHeader($title, $breadcrumb)
    {
        $paths = '';

        $breadcrumb = explode('/', $breadcrumb);

        foreach ($breadcrumb as $path) {
            $paths .= "<li class=\"breadcrumb-item\">{$path}</li>";
        }

        return "
            <div class=\"d-flex justify-content-between\">
                <h2 class=\"fw-normal\">
                    {$title}
                </h2>
                <nav aria-label=\"breadcrumb\">
                    <ol class=\"breadcrumb\">
                        {$paths}
                    </ol>
                </nav>
            </div>
        ";
    }

    public function generateStatePrestamo(int $status)
    {
        if ($status) {
            return '<span class="fas fa-check-square"></span> Devuelto';
        }

        return '<span class="far fa-square"></span> Pendiente';
    }

    public function generateStateCalification(int $calification)
    {
        $califications = [
            '0' => '<span class="fas fa-minus"></span> Neutral',
            '1' => '<span class="fas fa-check"></span> Positivo',
            '-1' => '<span class="fas fa-circle-xmark"></span> Negativo'
        ];

        return $califications[$calification];
    }

    public function getOptionStatePrestamo(int $status)
    {
        if ($status) {
            return '
                <option value="1">Devuelto</option>
                <option value="0">Pendiente</option>
            ';
        }

        return '
            <option value="0">Pendiente</option>
            <option value="1">Devuelto</option>
        ';
    }

    public function getSession()
    {
        $authentication = new Authentication();
        return $authentication->getSession();
    }

    public function getCurrentDate(int $after_days = 0)
    {
        date_default_timezone_set('America/Caracas');
        $current_date = date('Y-m-d');

        if ($after_days > 0) {
            $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
        }

        return $current_date;
    }

    public function getCurrentDateTime(int $after_days = 0)
    {
        date_default_timezone_set('America/Caracas');
        $current_date = date('Y-m-d: H:i:s');

        if ($after_days > 0) {
            $current_date = date('Y-m-d', strtotime('+1 day', strtotime($current_date)));
        }

        return $current_date;
    }

    public function getStateEvent(int $state)
    {
        $states = [
            '0' => 'Cancelado',
            '1' => 'Realizado',
            '2' => 'Pendiente',
            '3' => 'Por Confirmar',
        ];

        return $states[$state];
    }

    public function getTypeEventOption($type)
    {
        if ($type === 'Limitado') {
            return '<option value="Limitado">Limitado</option>
            <option value="No limitado">No limitado</option>';
        }

        return '<option value="No limitado">No limitado</option>
        <option value="Limitado">Limitado</option>';
    }

    public function getStateEventOption($state)
    {
        $states = [
            '0' => 'Cancelado',
            '1' => 'Realizado',
            '2' => 'Pendiente',
            '3' => 'Por Confirmar',
        ];

        $states_options = [];

        foreach($states as $key => $value) {
            if ((int) $key !== (int) $state) {
                $states_options[] = "<option value=\"{$key}\">{$value}</option>";
            }
        }

        return "<option value=\"{$state}\">{$states[$state]}</option>" . implode('', $states_options);
    }

    public function getCalificationsOptions($calification)
    {
        $califications = [
            '0' => 'Neutral',
            '1' => 'Positivo',
            '-1' => 'Negativo',
        ];

        $califications_options = [];

        foreach($califications as $key => $value) {
            if ((int) $key !== (int) $calification) {
                $califications_options[] = "<option value=\"{$key}\">{$value}</option>";
            }
        }

        return "<option value=\"{$calification}\">{$califications[$calification]}</option>" . implode('', $califications_options);
    }

    public function getCustomDate(string $date, string $format_date)
    {
        date_default_timezone_set('America/Caracas');
        return date($format_date, strtotime($date));
    }

    /**
     * Validar extension de la imagen
     *
     * @param  string $image_extention
     * @return bool
     */
    public function validateImage(string $image_extention)
    {
        $images_extentions = [
            'image/png',
            'image/gif',
            'image/jpeg',
            'image/webp'
        ];

        $index = array_search($image_extention, $images_extentions);

        return $index !== false ? true : false;
    }

    /**
     * uploadsFiles
     *
     * @param  string $folder
     * @param  array $files
     * @return bool|array
     */
    public function uploadsFiles(string $folder, array $files)
    {
        $file_path = __DIR__ . "/../../uploads/{$folder}/";

        if ( !is_dir($file_path) ) {
            mkdir($file_path, 0777, true);
            chmod($file_path, 0777);
        }

        $public_urls = [];

        foreach ($files as $file) {
            $extention = strtolower(explode('.', $file['name'])[1]);
            $new_file = uniqid() . ".{$extention}";
            $file_uploaded = $file_path . $new_file;

            if ( !move_uploaded_file($file['tmp_name'], $file_uploaded) ) {
                return false;
            }

            $public_urls[] = "/uploads/{$folder}/{$new_file}";
        }

        return $public_urls;
    }

    /**
     * removeUploadFile
     * Para remover archivos de La carpeta uploads
     *
     * @param  string $folder
     * @param  string $file
     * @return bool
     */
    public function removeUploadFile(string $folder, string $file)
    {
        $file_path = __DIR__ . "/../../uploads/{$folder}/";

        if ( !is_dir($file_path) ) {
            return true;
        }

        $dir_file  = $file_path . $file;

        return unlink($dir_file);
    }

    function getReputation(int $reputation) {
        $reputations = [
            '0' => '&#128528; Normal',
            '1' => '&#128512; Buena',
            '-1' => '&#128545; Mala'
        ];

        return $reputations[$reputation];
    }
}
