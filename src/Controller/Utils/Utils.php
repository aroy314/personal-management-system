<?php

namespace App\Controller\Utils;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Response;

class Utils extends AbstractController {

    /**
     * @param string $data
     * @return string
     */
    public static function unbase64(string $data) {
        return trim(htmlspecialchars_decode(base64_decode($data)));
    }

    /**
     * @param string $dir
     * @return bool
     */
    public static function removeFolderRecursively(string $dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? static::removeFolderRecursively("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    /**
     * @param string $source
     * @param string $destination
     * @throws \Exception
     */
    public static function copyFiles(string $source, string $destination) {

        $finder = new Finder();
        $finder->depth('==0');

        if (is_dir($source)) {

            $finder->files()->in($source);

            /**
             * @var $file SplFileInfo
             */
            foreach( $finder->files() as $file ){
                $filepath                   = $file->getPathname();
                $file_extension             = $file->getExtension();
                $filename_without_extension = $file->getFilenameWithoutExtension();

                $file_path_in_destination_folder = "{$destination}/{$filename_without_extension}.{$file_extension}";

                if( file_exists($file_path_in_destination_folder) ){
                    $curr_date_time     = new \DateTime();
                    $filename_date_time = $curr_date_time->format('Y_m_d_h_i_s');

                    $file_path_in_destination_folder = "{$destination}/{$filename_without_extension}.{$filename_date_time}.{$file_extension}";
                }

                copy($filepath, $file_path_in_destination_folder);
            }

        }else{
            copy($source, $destination);
        }

    }

    /**
     * @param Response $response
     * @return string
     */
    public static function getFlashTypeForRequest(Response $response){
        $flashType = ( $response->getStatusCode() === 200 ? 'success' : 'danger' );
        return $flashType;
    }

}
