<?php

namespace App\Mail\Traits;

trait CreatesPdfs
{
    protected function createPDF($design)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("
            <img src='{$design->getImagePath()}' width='100%'>
            <br>
            <h1>{$design->comment}</h1>
        ");
        $dompdf->render();
        return $dompdf->output();
    }

    protected function setAttachmentName($design)
    {
        return substr($design->image_name, 0, -3) . 'pdf';
    }
}