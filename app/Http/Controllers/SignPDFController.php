<?php

namespace App\Http\Controllers;

use App\UseCases\SignPdfWithUploadedFiles;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SignPDFController
{
    private SignPdfWithUploadedFiles $signPdfWithUploadedFiles;

    public function __construct(SignPdfWithUploadedFiles $signPdfWithUploadedFiles)
    {
        $this->signPdfWithUploadedFiles = $signPdfWithUploadedFiles;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try {
            $this->signPdfWithUploadedFiles->execute(
                $request->file('documento'),
                $request->file('certificado'),
                $request->post('senha')
            );
        } catch (\Exception $exception) {
            return new JsonResponse([
                'message' => 'Erro ao assinar',
                'error' => $exception->getMessage()
            ], 400);
        }

        return new JsonResponse(['message' => 'assinado com sucesso!']);
    }
}
