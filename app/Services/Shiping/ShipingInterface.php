<?php

namespace App\Services\Shiping;
use setasign\Fpdi\Fpdi;
use setasign\Fpdf\Fpdf;
interface ShipingInterface
{
    public static  function   shiping(array $data): string;

    public static  function printInvoice($invoice_number, $filePath);

    public static  function printMultibleInvoice($invoice_number);



}
