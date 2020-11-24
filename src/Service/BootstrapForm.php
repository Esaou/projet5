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

    public function password(string $name):string
    {
        return $this->surround(
            '<label style="font-size:15px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="password" name="' . $name . '" value="" class="form-control">'
        );
    }

    public function inputProfil(string $name):string
    {
        return $this->surround(
            '<label style="font-size:15px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function passwordProfil(string $name):string
    {
        return $this->surround(
            '<label style="font-size:15px;">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="password" name="' . $name . '" value="" class="form-control">'
        );
    }

    public function inputActivite(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;font-family:RobotoMedium;" class="green">' . ucfirst($name) . ' <span style="font-family:sans-serif;font-size:15px;" class="colorTitle">(ex: Médecine générale)</span></label><input style="font-family:sans-serif;font-size:15px;margin-bottom:30px;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function inputTitre(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;font-family:RobotoMedium;" class="green">' . ucfirst($name) . ' <span style="font-family:sans-serif;font-size:15px;" class="colorTitle">(ex: Médecins généralistes)</span></label><input style="font-family:sans-serif;font-size:15px;margin-bottom:30px;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
        );
    }

    public function inputEditor(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;font-family:RobotoMedium;" class="colorTitle">' . ucfirst($name) . '</label><input style="font-family:sans-serif;" type="text" name="' . $name . '" value="' . $this->getValue($name) . '" class="form-control">'
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
            '<label style="font-size:17px;font-family:RobotoMedium;" class="green">' . ucfirst($name) . ' <span style="font-family:sans-serif;font-size:15px;" class="colorTitle">(s\'affichera dans la rubrique \'activité\' du site)</span></label><textarea style="min-height:300px;" name="' . $name . '" class="form-control" id="myEditor">' . $this->getValue($name) .'</textarea>'
        );
    }

    public function textAreaEditorContenu(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;font-family:RobotoMedium;" class="colorTitle">' . ucfirst($name) . '</label><textarea name="' . $name . '" style="min-height:300px;" class="form-control" id="myEditor">' . $this->getValue($name) .'</textarea>'
        );
    }

    public function inputFile(string $name):string
    {
        return $this->surround(
            '<label style="font-size:17px;font-family:RobotoMedium;margin-bottom:15px;" class="green">' . ucfirst($name) . '<span style="font-family:sans-serif;font-size:15px;" class="colorTitle"> (s\'affichera sur la page d\'accueil)</span></label><input style="font-family:sans-serif;font-size:15px;margin-bottom:20px;display:block;" type="file" name="' . $name . '" value="' . $this->getValue($name) . '">'
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
