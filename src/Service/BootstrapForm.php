<?php

declare(strict_types=1);

namespace App\Service;

class BootstrapForm
{
    private $data;

    
    public function __construct($data = [])
    {
        $this->data = $data;
    }

    protected function surround(string $html):string
    {
        return "<div class=\"form-group\">{$html}</div>";
    }

    public function input(string $name):string
    {
        return $this->surround(
            '<label style="font-size:15px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function inputActivite(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . ' (ex: Médecine générale)</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function inputTitre(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . ' (ex: Médecins généralistes)</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function inputEditor(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function password(string $name):string
    {
        return $this->surround(
            '<label style="font-size:15px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="password" name="' . $name . '" value="" class="form-control">'
        );
    }

    public function textArea(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . '</label><textarea style="min-height:100px;" name="' . $name . '" class="form-control">' . $this->getValue($name) .'</textarea>'
        );
    }

    public function textAreaEditor(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . ' (s\'affichera dans la rubrique \'activité\' du site)</label><textarea style="min-height:300px;" name="' . $name . '" class="form-control" id="myEditor">' . $this->getValue($name) .'</textarea>'
        );
    }

    public function textAreaEditorContenu(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;">' . ucfirst($name) . '</label><textarea name="' . $name . '" style="min-height:300px;" class="form-control" id="myEditor">' . $this->getValue($name) .'</textarea>'
        );
    }

    public function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }

        return $this->data[$index] ?? null;
    }
}
