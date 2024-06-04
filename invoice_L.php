<?php

require('fpdf.php');
require("PDF_MC_Table.php");

class Invoice extends PDF_MC_Table
{
    public $data;
    public $options;
    public $pageContainerWidth;
    public $pagePaddingX;
    public $pagePaddingY;
    public $headerHeight;
    public $footerHeight;
    public $breakAfter;
    public $mainSpace;
    public $globalX;
    public $globalY;
    public $tableY;
    public $YdebutFooter;
    public $YFinReglement;
    public $EspaceVide;
    public $conditionsSize;
    public $halfWidth;
    public $colGab;
    public $type;
    public $hasEnLettre;
    public $hasConditions;
    public $hasValidite;
    public $hasTotal;

    public function __construct()
    {
        parent::__construct($orientation = 'P', $unit = 'mm', $size = 'A4');
        $this->SetAutoPageBreak(false);
        $this->data = [];
        // * print 
        $this->globalY = $this->GetY();
        $this->globalX = $this->GetX();
        $this->tableY = "";
        $this->pagePaddingX = 0;
        $this->pagePaddingY = 0;
        $this->mainSpace =  0;
        $this->colGab = 0;
        $this->pageContainerWidth = $this->GetPageWidth() - $this->pagePaddingX * 2;
        $this->halfWidth = $this->pageContainerWidth / 2;
        $this->breakAfter = 20;
        $this->conditionsSize = 0;
        // * document 
        $this->type = "";
        $this->hasEnLettre = false;
        $this->hasConditions = false;
        $this->hasValidite =  false;
        $this->hasTotal = false;
        // * style 
        $this->headerHeight = 30; // * todo
        $this->footerHeight = 20; // * todo

        // * clculabe 
    }


    public function Header()
    {
        //  temporary variables 
        $bg_color = [236, 236, 236];

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(...$bg_color);
        $this->Rect($this->pagePaddingX, 2, $this->pageContainerWidth, $this->headerHeight, 'F');
        $this->logo($this->data['header']['logo'], 15, 15);
        $this->companyInfo();
        $this->SetXY(0, $this->headerHeight - $this->pagePaddingY - 2);
        $this->Cell(0, 5, $this->PageNo() . '/{nb}', 0, 0, 'C');
    }


    public function Footer()
    {
        $bg_color = [236, 236, 236];
        $this->SetY(-$this->footerHeight);
        $y =  $this->GetY() + 2;
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(...$bg_color);
        $this->Rect($this->pagePaddingX, $this->GetY(), $this->pageContainerWidth, $this->footerHeight - $this->pagePaddingY, 'F');
        foreach ($this->data['footer'] as $dt) {
            $this->SetXY($this->pagePaddingX, $y);
            $this->MultiCell($this->pageContainerWidth, 5, $this->setText($dt), 0, "C");
            $y = $this->GetY() + 2;
        }
    }

    protected function logo($path, $width, $height)
    {
        $this->Image($path, $this->pagePaddingX + 2, ($this->headerHeight / 2 - ($height / 2.5)), $width, $height);
    }

    protected function companyInfo()
    {
        $y =  $this->headerHeight / 2 - 5;
        $x = $this->pageContainerWidth / 2;
        $this->SetFont('Arial', 'B', 8);

        foreach ($this->data['header']['company_infos'] as $line) {
            $this->SetXY($x, $y);
            $this->MultiCell(0, 5, $line, 0, "C");
            $y = $this->GetY();
        }
    }

    protected function DocumentInfo()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->left();
        $this->right();
    }


    protected function left()
    {
        $x = $this->pagePaddingX;
        $y = $this->headerHeight + $this->pagePaddingY + $this->mainSpace;
        $width = $this->pageContainerWidth / 2; // * possible add gab
        $this->SetXY($x, $y);
        foreach ($this->data['document_infos']['left'] as $key => $line) {
            $this->Cell($width, 5, $key . " : " . $line);
            $this->SetXY($x, $this->GetY() + 5);
        }
    }

    protected function right()
    {
        $x = $this->pageContainerWidth / 2;
        $y = $this->headerHeight + $this->pagePaddingY + $this->mainSpace;
        $this->SetXY($x, $y);
        foreach ($this->data['document_infos']['right'] as $key => $line) { // fixed key to 'right'
            $this->Cell(0, 5, $this->setText($key . " : " . $line), 0, 0, "R");
            $this->SetXY($x, $this->GetY() + 5);
        }
    }


    protected function Table()
    {
        $header = $this->data['table']['thead'];
        $x = $this->globalX =  $this->pagePaddingX;
        $y =  $this->GetY() + $this->mainSpace;

        $this->SetXY($x, $y);
        $this->SetWidths($this->get_widths($header));
        $this->Row($header);
        $this->globalY = $this->tableY =  $this->GetY();

        // * 
        $heightTable = $this->GetPageHeight() - $this->GetY() - $this->footerHeight - $this->breakAfter;

        $counter =  1;

        foreach ($this->data['table']['tbody'] as $dt) {
            $positionTable = $this->tableY + $heightTable;
            $check = $this->checkLine($this->prepareRow($header, $dt));

            if ($check > $positionTable) {

                $x1 = $x;

                for ($i = 0; $i <= count($header); $i++) {
                    $this->Line($x1, $this->globalY, $x1,  $positionTable);
                    $x1 += $this->pageContainerWidth / count($header);
                }

                $this->Line($x, $positionTable, $this->pageContainerWidth + 5,   $positionTable);


                $this->AddPage();
                $this->SetXY($x,  $this->headerHeight + $this->mainSpace);
                $this->Row($header);

                $this->tableY =  $this->globalY = $this->GetY();
                $heightTable = $this->GetPageHeight() - $this->GetY() - $this->footerHeight - $this->breakAfter;
            }

            $credentials = $this->newLine($this->prepareRow($header, $dt));

            $x1 = $x;

            for ($i = 0; $i <= count($header); $i++) {
                $this->Line($x1, $credentials['y1'], $x1, $credentials['y2']);
                $x1 += $this->pageContainerWidth / count($header);
            }

            if ($counter == count($this->data['table']['tbody'])) {
                $height = $this->GetPageHeight() - $this->footerHeight - $this->breakAfter;
                $this->globalY = $this->calcTotal() > $this->calcConditionsSize()['size'] ?   $height - $this->calcTotal() : $height - $this->calcConditionsSize()['size'];
                $diff = $this->globalY -  $credentials['y2'];
                $x1 = $x;
                $y =  $credentials['y2'];



                for ($i = 0; $i <= count($header); $i++) {
                    $this->Line($x1,  $y, $x1,  $y + $diff);
                    $x1 += $this->pageContainerWidth / count($header);
                }


                if ($credentials['y2'] + $this->calcConditionsSize()['size'] > $positionTable || $credentials['y2'] + $this->calcTotal()  > $positionTable) {
                    // * here 
                    $x1 = $x;

                    for ($i = 0; $i <= count($header); $i++) {
                        $this->Line($x1,  $this->globalY, $x1,  $positionTable);
                        $x1 += $this->pageContainerWidth / count($header);
                    }

                    $this->Line($x, $positionTable, $this->pageContainerWidth + 5,   $positionTable);

                    $this->AddPage();
                    $this->SetXY($x,  $this->headerHeight + $this->mainSpace);
                    $this->Row($header);
                    $x1 = $x;
                    $y = $this->GetY();
                    $diff = $this->globalY -  $y;


                    for ($i = 0; $i <= count($header); $i++) {
                        $this->Line($x1,  $y, $x1,  $y + $diff);
                        $x1 += $this->pageContainerWidth / count($header);
                    }
                }

                $this->Line($x,  $y + $diff, $this->pageContainerWidth + 5, $y + $diff);
            }

            $counter++;
        }

        $this->total();
    }

    protected function total()
    {
        $y = $this->globalY;
        $x = $this->halfWidth + 5;
        $h = 10;
        foreach ($this->data['table']['tfoot'] as $key => $value) {
            $this->SetXY($x, $y);
            $this->Cell($this->pageContainerWidth / 4,  $h, $this->setText($key), 1, 0, 'l');
            $this->Cell($this->pageContainerWidth / 4,  $h, $this->setText($value), 1, 0, 'R');
            $y = $this->GetY() +  $h;
        }
    }

    protected function Conditions()
    {
        $y = $this->globalY + 5;
        $this->SetXY($this->pagePaddingX, $y);
        $this->MultiCell($this->halfWidth -  $this->colGab, 5,  $this->setText($this->data['reglement_info']["enlettre"]));
        $y =  $this->GetY() +  5;

        $this->SetXY($this->pagePaddingX, $y);
        $this->Cell($this->halfWidth -  $this->colGab, 5, $this->setText("Conditions de paiement : "));


        $y =  $this->GetY() +  $this->mainSpace;


        foreach ($this->data['reglement_info']["conditions"] as $condition) {
            $this->SetXY($this->pagePaddingX + 5, $y);
            $text = "* le :  " . $condition['date'] . "  " . $condition['nom'] . "  " . $condition['montant'];
            $this->Cell($this->halfWidth -  $this->colGab, 5, $this->setText($text));
            $y += $this->mainSpace;
        }


        $this->SetXY($this->pagePaddingX, $y);
        $this->MultiCell($this->halfWidth -  $this->colGab, 5,  $this->setText($this->data['reglement_info']["validite"]));
    }


    // * helpers functions 


    private function calcConditionsSize()
    {

        $startY = $y =  $this->globalY + 5;
        $this->SetXY(-10000000000000000, $y);
        $this->MultiCell($this->pageContainerWidth / 2, 5,  $this->setText($this->data['reglement_info']["enlettre"]));
        $y =  $this->GetY() +  5;


        $this->SetXY(-100000000000000, $y);
        $this->Cell($this->pageContainerWidth / 2, 5, $this->setText("Conditions de paiement : "));


        $y =  $this->GetY() +  $this->mainSpace;


        foreach ($this->data['reglement_info']["conditions"] as $condition) {
            $this->SetXY(-10000000000, $y);
            $text = "* le :  " . $condition['date'] . "  " . $condition['nom'] . "  " . $condition['montant'];
            $this->Cell($this->pageContainerWidth / 2, 5,  $text);

            $y += $this->mainSpace;
        }

        $this->SetXY(-10000000000000000, $y);
        $this->MultiCell($this->pageContainerWidth / 2, 5,  $this->setText($this->data['reglement_info']["validite"]));

        $lastY = $this->GetY();

        $this->conditionsSize = $lastY - $startY;

        return ['startY' => $startY, "endY" => $lastY, "size" => $this->conditionsSize];
    }


    private function calcTotal()
    {
        $y = $startY = $this->globalY;
        $x = -100000000000000000;
        $h = 10;
        foreach ($this->data['table']['tfoot'] as $key => $value) {
            $this->SetXY($x, $y);
            $this->Cell($this->pageContainerWidth / 4,  $h, $this->setText($key), 1, 0, 'l');
            $this->Cell($this->pageContainerWidth / 4,  $h, $this->setText($value), 1, 0, 'R');
            $y = $this->GetY() +  $h;
        }

        return $y - $startY;
    }

    private function newLine($row)
    {
        $array_Y = [];
        $x = $this->globalX;
        $y = $this->globalY + 5;

        foreach ($row as $singleRow) {
            $this->SetXY($x, $y);
            $this->MultiCell($singleRow['size'], 5,  $this->setText($singleRow['content']), 0, 'C');
            $x += $singleRow['size'];
            $array_Y[] = $this->GetY();
        }

        $this->globalY = max($array_Y);
        return ['y1' => $y - 5, "y2" => max($array_Y)];
    }


    private function checkLine($row)
    {
        $array_Y = [];
        $x = $this->globalX;
        $y = $this->globalY + 5;

        foreach ($row as $singleRow) {
            $this->SetXY(-1000000, $y);
            $this->MultiCell($singleRow['size'], 5, $singleRow['content'], 0, 'C');
            $x += $singleRow['size'];
            $array_Y[] = $this->GetY();
        }

        return max($array_Y);
    }


    private function prepareRow($header, $row)
    {
        $retour = [];
        $sizes = $this->get_width_cols($header);
        foreach ($row as $key => $val) {
            $retour[] = [
                "size" => $sizes[$key],
                "content" => $val
            ];
        }

        return $retour;
    }


    private function get_widths(array  $data)
    {
        $retour = [];
        for ($i = 0; $i < count($data); $i++) {
            $retour[] = $this->pageContainerWidth / count($data);
        }
        return $retour;
    }


    private function get_width_cols(array  $header)
    {
        $retour = [];
        for ($i = 0; $i < count($header); $i++) {
            $retour[$header[$i]] = $this->pageContainerWidth / count($header);
        }

        return $retour;
    }


    private function setText($text)
    {
        return iconv('UTF-8', 'ISO-8859-1', $text);
    }

    // * run functions  

    public function setOptions(array $options = [])
    {
        $this->pagePaddingY = $options['print']['paddingY'] ?? 2;
        $this->pagePaddingX = $options['print']['paddingX'] ?? 5;
        $this->mainSpace = $options['print']['main_space'] ??  8;
        $this->colGab = $options['print']['cols_gab'] ?? 20;
    }

    public function prepareData(array $data)
    {
        $this->data = $data;
    }

    public function generateInvoice()
    {
        $this->AliasNbPages();
        $this->AddPage();
        $this->DocumentInfo();
        $this->Table();
        $this->Conditions();
        $this->Output();
    }
}
