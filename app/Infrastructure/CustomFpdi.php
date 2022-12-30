<?php

namespace App\Infrastructure;

use setasign\Fpdi\Tcpdf\Fpdi;

class CustomFpdi extends Fpdi
{
    private string $footerInfo;

    public function setFooterInfo(string $info)
    {
        $this->footerInfo = $info;
    }

    public function Footer()
    {
        $this->SetY(-10);
        $this->SetFont('helvetica', 'I', 7);
        $this->Cell(0, 10, $this->footerInfo, 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

    public function Header()
    {

    }
}
