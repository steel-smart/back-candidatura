<?php

namespace App\UseCases;

use App\Infrastructure\CustomFpdi;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class SignPdfWithUploadedFiles
{
    private Filesystem $storageHandler;
    private string $storageDisk;

    public function __construct()
    {
        $this->storageDisk = 'local';
        $this->storageHandler = Storage::disk($this->storageDisk);
    }

    public function execute($document,  $certificate, string $password)
    {
        $basePathCert = storage_path('app');
        $basePath = storage_path('app/public');

        // return response()->json(file_get_contents($basePath.'/'.$certificate),200) ;

        $pdf = Storage::get($certificate);
        $uploadedCertificate = $this->storageHandler->put($certificate, $pdf);


        $completeCertificatePath = "{$basePathCert}/{$certificate}";

        $certData = $this->validateCertificate($completeCertificatePath, $password);

        file_put_contents($completeCertificatePath, $certData['cert'] . $certData['pkey']);

        $signerInfo = $this->getCertificateInfo($certData);

        $pdf = new CustomFpdi('P', 'mm', 'A4');
        $pdf->setFooterInfo('Assinado digitalmente: ' . $signerInfo);
        $pages = $pdf->setSourceFile("{$basePath}/{$document}");

        for ($i = 1; $i <= $pages; $i++) {
            $pdf->AddPage();
            $page = $pdf->importPage($i);
            $pdf->useTemplate($page, 0, 0);
            $pdf->setSignature('file://' . $completeCertificatePath, 'file://' . $completeCertificatePath, $password, '', 2, $signerInfo);
        }

        $signedDocumentPath = $pdf->Output();

        $this->storageHandler->delete($certificate, $pdf);
        // $this->storageHandler->delete($uploadedOrignalDocument);

        return $signedDocumentPath;
    }

    private function getCertificateInfo($certData)
    {
        $content = openssl_x509_parse(openssl_x509_read($certData['cert']));

        // company/name & CNPJ/CPF
        $info = explode(':', $content['subject']['CN']);

        // company/name
        $company = $info[0];

        if (strlen($info[1]) == 14) {
            $type = 'CNPJ: ' . $info[1];
        } else {
            $type = 'CPF: ' . $info[1];
        }

        return $company . " \n" . $type . " \n" . 'Data: ' . date('d/m/Y H:i');
    }

    private function validateCertificate(string $completeCertificatePath, string $password)
    {
        if (!openssl_pkcs12_read(file_get_contents($completeCertificatePath), $certData, $password)) {

            throw new \Exception('Senha ou certificado inválido');
        }

        return $certData;
    }
}
