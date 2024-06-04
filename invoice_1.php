<?php
require('fpdf.php');
require("PDF_MC_Table.php");

class Invoice extends PDF_MC_Table
{
    public $data;
    public $pageContainerWidth;
    public $pagePaddingX;
    public $pagePaddingY;
    public $headerHeight;
    public $mainSpace;

    public function __construct($data, $pagePaddingX, $pagePaddingY)
    {
        parent::__construct($orientation = 'P', $unit = 'mm', $size = 'A4');
        $this->data = $data;
        $this->pagePaddingX = $pagePaddingX;
        $this->pagePaddingY = $pagePaddingY;
        $this->pageContainerWidth = $this->GetPageWidth() - $pagePaddingX * 2;
        $this->headerHeight = 30; // * to modify 
        $this->mainSpace = 8; // * to modify 
    }

    public function Header()
    {
        //  temporary variables 
        $bg_color = [236, 236, 236];

        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(...$bg_color);
        $this->Rect($this->pagePaddingX, 2, $this->pageContainerWidth, $this->headerHeight, 'F');
        $this->logo($this->data['header']['logo'], 15, 15);
        $this->companyInfo($this->pageContainerWidth);
    }

    private function logo($path, $width, $height)
    {
        $this->Image($path, $this->pagePaddingX + 2, ($this->headerHeight / 2 - ($height / 2.5)), $width, $height);
    }

    private function companyInfo($header_width)
    {
        $y =  $this->headerHeight / 2 - 5;
        $x = $header_width / 2;
        $this->SetFont('Arial', 'B', 8);

        foreach ($this->data['header']['company_infos'] as $line) {
            $this->SetXY($x, $y);
            $this->MultiCell(0, 5, $line, 0, "C");
            $y = $this->GetY();
        }
    }


    public function DocumentInfo()
    {
        $this->SetFont('Arial', 'B', 8);
        $this->left();
        $this->right();
    }

    public function Table()
    {
        $header = ["nom", "Prenom", "age"];
        for ($i = 0; $i < 100; $i++)
            $body[] = [
                "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte. Il n'a pas fait que survivre cinq siècles, mais s'est aussi adapté à la bureautique informatique, sans que son contenu n'en soit modifié. Il a été popularisé dans les années 1960 grâce à la ven",
                "1",
                "2"
            ];
        $x = $this->pagePaddingX;
        $y = $this->GetY() + $this->mainSpace;
        $width = $this->pageContainerWidth;

        $this->SetXY($x, $y);
        $this->SetWidths($this->get_widths($header));
        $this->Row($header);
        $j = 1;
        foreach ($body as $dt) {

            $this->SetXY($x, $this->GetY());
            $this->Row($dt);
            if ($this->GetY() >= $this->GetPageHeight() - 50) {
                $this->AddPage();
                $this->SetXY($x,  $this->headerHeight + 5);
                $this->Row($header);
            }


            if (count($body) == $j) {
                $deffirence = $this->GetPageHeight() - 50 -  $this->GetY();
                if ($deffirence > 0) {
                    for ($i = 0; $i < $deffirence / 5; $i++) {
                        $this->SetXY($x,  $this->GetY());
                        $this->Row(['', '', '']);
                    }
                }
            }

            $j++;
        }
    }


    private function get_widths($data)
    {
        $retour = [];
        for ($i = 0; $i < count($data); $i++) {
            $retour[] = $this->pageContainerWidth / count($data);
        }

        return $retour;
    }

    private function left()
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

    private function  right()
    {
        $x = $this->pageContainerWidth / 2;
        $y = $this->headerHeight + $this->pagePaddingY + $this->mainSpace;
        $this->SetXY($x, $y);
        foreach ($this->data['document_infos']['left'] as $key => $line) {
            $this->Cell(0, 5, $key . " : " . $line, 0, 0, "R");
            $this->SetXY($x, $this->GetY() + 5);
        }
    }
    private function thead()
    {
    }
    private function tbody()
    {
    }




    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}
