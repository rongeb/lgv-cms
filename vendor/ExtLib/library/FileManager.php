<?php

namespace ExtLib;

//ini_set('display_errors', 1);

final class FileManager
{

    public static $renameUploadedFile = 0;
    public static $renameExistingFile = 1;
    public static $deleteExistingFile = 2;

    public function extractExtension($fichier)
    {
        /*
          $ok = ereg("^(.+)\.(.+)$", $fichier, $items);

          if($ok)
          return $items[2];
         */
        $fileInfo = pathinfo($fichier);

        $fileExtension = $fileInfo['extension'];

        return $fileExtension;
    }

    public function saferepertoirename($nomrep)
    {
        $echap = array("^", "[", "]", "<", ">", "'", "~", "!", "?", "€", "/", "@", "\\", "#", "{", "}", "$", "%", ":", "(", ")", "+", "*");

        $nomrep = strip_tags($nomrep);
        //$var = mysql_real_escape_string($var);
        $nomrep = addcslashes($nomrep, '%_');
        $nomrep = trim($nomrep);
        $nomrep = str_replace($echap, "", $nomrep);
        $nomrep = htmlspecialchars($nomrep);

        return $nomrep;
    }

    //formate le nom du fichier avant de le renommer
    public function formatNameFile($string)
    {
        $string = strtr($string, 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ', 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); //pour les accents
        $string = trim($string); //Empeche un espace avant le nom du fichier
        $string = stripslashes($string); //pour les apostrophes
        $string = strtr($string, '"|/\:*?<> ', '__________'); //pour les caractères interdits dans les noms de fichiers
        return $string;
    }

    //TODO create file and rename file
    public function createFile($path, $filename)
    {
        $message = true;
        $isOk = fopen($path . $filename, 'w');
        if (!$isOk) {
            $message = false;
        }

        return $message;
    }

    public function renameExistingFile($path, $oldName, $newName)
    {
        return @rename($path . $oldName, $path . $newName);
        //var_dump(@rename($path . $oldName, $path . $newName));
    }

    //fonction d'upload de fichier
    function uploadfiles($file, $path, $newNameF, $actionFileExists)
    {
        $newNameFichier = array(false, "");
        $deleteExisting = array(false, "");
        $renameExisting = array(false, "");

        if ($file['name'] != "") {
            //global $newNameFichier;
            if (empty($newNameF)) {
                $newNameFichier[1] = $this->formatNameFile($file['name']);
            } else {
                $newNameFichier[1] = $newNameF;
            }

            $newNameFichier[1] = strtolower($newNameFichier[1]);

            if (file_exists($path . $newNameFichier[1])) {

                if ($actionFileExists == self::$deleteExistingFile) {
                    $deleteExisting[0] = @unlink($path . $newNameFichier[1]);
                    $deleteExisting[1] = $newNameFichier[1];

                } elseif ($actionFileExists == self::$renameUploadedFile) {
                    $newNameFichier[1] = time() . "_" . $newNameFichier[1]; //Si un autre fichier du meme nom existe, on renomme
                } elseif ($actionFileExists == self::$renameExistingFile) {
                    $renameExisting[0] = @rename($path . $newNameFichier[1], $path . time() . "_" . $newNameFichier[1]);
                    $renameExisting[1] = time() . "_" . $newNameFichier[1];

                }
            }

            $newNameFichier[0] = @copy($file['tmp_name'], $path . $newNameFichier[1]);
        }

        return array("filename" => $newNameFichier, "deleteExisting" => $deleteExisting[0], "renameExisting" => $renameExisting);
    }

    // Fonction de modification de fichier
    //$newName est le nom à donner au fichier uploadé
    function updatefiles($fichier, $old_fichier, $path, $newName)
    {
        $newNameFichier = "";

        if (!empty($fichier['name'])) { // si un fichier uploadé
            if (empty($newName)) {
                $newNameFichier = $this->formatNameFile($fichier['name']);
            } else {
                $newNameFichier = $newNameF;
            }
            @unlink($chemin . $old_fichier); //suppression de l'ancien
            if (file_exists($chemin . $newName)) {
                $newName = time() . "_" . $newName;  //Si un autre fichier du meme nom existe, on renomme
            }

            @copy($fichier['tmp_name'], $chemin . $newName); //Copie le fichier

            $updatefiles = $newName;
        } else { // si pas de fichier uploadé
            if (file_exists($chemin . $old_fichier))
                $updatefiles = $old_fichier;
            else
                $updatefiles = "";
        }

        return $updatefiles;
    }

    // fonction qui reduit une image a partir d un fichier et l enregistre dans un ti_fichier 
    // Nom du fichier, tx de compression, Taille hauteur max, Taille largeur Max, rep source, rep de destination, prefixe a mettre
    function reduit_fichier($fichier_image, $nomFinal, $max_v, $max_h, $source, $destination, $prefixe)
    {
        //if(call_user_func(array("Outils","extractExtension"),$fichier_image)!="jpg" && call_user_func(array("ajoutfichier","extractExtension"),$fichier_image)!="png")	return;
        if (($this->extractExtension($fichier_image) != "jpg") && ($this->extractExtension($fichier_image) != "jpeg") && ($this->extractExtension($fichier_image) != "png"))
            return;
        // MAX_V = HAUTEUR -- MAX_H = LARGEUR
        // le nom de l'image "scalée" commencera par ti_ et le nom du fichier original 
        $ti_fichier_image = $prefixe . $nomFinal;

        if (file_exists($destination . $ti_fichier_image)) {
            $ti_fichier_image = $prefixe . time() . "_" . $nomFinal;
        }
        //global $nomfichier;


        if ($this->extractExtension($fichier_image) == "png") {
            $im = ImageCreateFrompng($source . $fichier_image);
        } else {
            $im = ImageCreateFromjpeg($source . $fichier_image);
        }

        $v = ImageSY($im); // $v prend la hauteur
        $h = ImageSX($im); // $h prend la largeur
        //Floor Arrondi à l'entier inférieur
        //ON GERE LA HAUTEUR
        if ($v > $max_v) { // Si la hauteur Img, est plus grand que le max, on reduit
            $taux_hauteur = $v / $max_v;    // On recupere le taux necessaire pour retrecir
            $ti_v = (int)floor($max_v); // ti_v = taille final de la hauteur
            $ti_h = (int)floor($h / $taux_hauteur); // ti_h = taille final de la largeur
        } else
            $ti_v = $v; // Sinon on fixe la hauteur


// Si il n'a pas deja subi une modification de la taille
        if ($ti_h != "")
            $h_comp = $ti_h;
        else
            $h_comp = $h;
        if ($ti_v != "")
            $v_comp = $ti_v;
        else
            $v_comp = $v;

        //ON GERE LA LARGEUR
        if ($h_comp > $max_h) {
            $taux_largeur = $h_comp / $max_h;
            $ti_h = (int)floor($max_h);
            $ti_v = (int)floor($v_comp / $taux_largeur);
        } else
            $ti_h = $h_comp;
        $ti_im = ImageCreateTrueColor($ti_h, $ti_v);
        imagecopyresampled($ti_im, $im, 0, 0, 0, 0, $ti_h, $ti_v, $h, $v);

        if ($this->extractExtension($fichier_image) == "png") {
            imagepng($ti_im, "$destination" . "$ti_fichier_image");
        } else {
            imagejpeg($ti_im, "$destination" . "$ti_fichier_image");
        }

        return $nomfichier = $ti_fichier_image;
    }

    //function de suppression de fichier
    function deletefile($file, $path)
    {
        if ((file_exists($path . $file)) && (isset($file))) {
            @unlink($path . $file);
        }
    }

    /*
      //supprimer le répertoire et les sous répertoires empty = false permet la suppression du repertoire designé
      NE FONCTIONNE QUE DIRECTEMENT DANS LE FICHIER CONCERNE ET PAS EN CREANT UNE INSTANCE
      public function suppRepEtFichiers($dir)
      {

      if (is_dir($dir)) // ensures that we actually have a directory
      {
      $objects = scandir($dir); // gets all files and folders inside
      foreach ($objects as $object)
      {
      if ($object != '.' && $object != '..')
      {
      if (is_dir($dir . '/' . $object))
      {
      // if we find a directory, do a recursive call
      suppSousRepEtFichiers($dir . '/' . $object);
      }
      else
      {
      // if we find a file, simply delete it
      unlink($dir . '/' . $object);
      }
      }
      }
      // the original directory is now empty, so delete it
      rmdir($dir);

      echo 'La suppression du r&eacute;pertoire et de ses fichiers s\'est d&eacute;roul&eacute; avec succ&egrave;s';
      }

      }
     */
}

?>