<?php
/**
 * @author Leo<jiangwenhua@yoyohr.com>
 */

use setasign\Fpdi;

$parser = 'fpdi-pdf-parser';

require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');
require_once('fpdi_pdf-parser/src/autoload.php');

// overwrite FPDI to define which parser should be used.
class Pdf extends Fpdi\Fpdi
{
    /**
     * @var string
     */
    protected $pdfParserClass = null;

    /**
     * Set the pdf reader class.
     *
     * @param string $pdfParserClass
     */
    public function setPdfParserClass($pdfParserClass)
    {
        $this->pdfParserClass = $pdfParserClass;
    }

    /**
     * Get a new pdf parser instance.
     *
     * @param Fpdi\PdfParser\StreamReader $streamReader
     * @return Fpdi\PdfParser\PdfParser|setasign\FpdiPdfParser\PdfParser\PdfParser
     */
    protected function getPdfParserInstance(Fpdi\PdfParser\StreamReader $streamReader)
    {
        if ($this->pdfParserClass !== null) {
            return new $this->pdfParserClass($streamReader);
        }

        return parent::getPdfParserInstance($streamReader);
    }

    /**
     * Checks whether a compressed cross-reference reader instance was used or not.
     *
     * @return bool
     */
    public function isCompressedXref()
    {
        foreach (array_keys($this->readers) as $readerId) {
            $crossReference = $this->getPdfReader($readerId)->getParser()->getCrossReference();
            $readers = $crossReference->getReaders();
            foreach ($readers as $reader) {
                if ($reader instanceof \setasign\FpdiPdfParser\PdfParser\CrossReference\CompressedReader) {
                    return true;
                }
            }
        }

        return false;
    }
}



function edit_pdf($source, $target) {
    $pdf = new Pdf();

    $pdf->AddPage();
    $pageCount = $pdf->setSourceFile($source);

    for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
        if($pageNo!=2) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            $pdf->addPage();
        }

    }



    $pdf->Output('F',$target);
}

$filename = 'data/source/1529417357501.pdf';

$target = 'data/target/1529417357501.pdf';

edit_pdf($filename, $target);
