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
    public $footerHeight ;
    public $breakAfter ;
    public $mainSpace;
    public $globalX ;
    public $globalY ;
    public $tableY ;

    public function __construct($data, $pagePaddingX, $pagePaddingY)
    {
        parent::__construct($orientation = 'P', $unit = 'mm', $size = 'A4');
        $this->SetAutoPageBreak(false);
        $this->globalY = $this->GetY() ;
        $this->globalX = $this->GetX() ;
        $this->pagePaddingX = $pagePaddingX;
        $this->pagePaddingY = $pagePaddingY;
        $this->pageContainerWidth = $this->GetPageWidth() - $pagePaddingX * 2;
        $this->breakAfter = 20 ;
        $this->headerHeight = 30; // * to modify 
        $this->footerHeight = 15; // * to modify 
        $this->mainSpace = 8; // * to modify 
        $this->data = $data;
        $this->tableY = "" ;
    }

    // * modify this colonne and format
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
        $header = ["Designation", "PU", "PHT" , "Total_HT"];

        // for( $i = 0 ; $i < 1500 ; $i ++ )
        //     $body[] = [
        //     "nom" => "abdellah" ,
        //     "prenom" => "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte" ,
        //     "age" => "On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L'avantage du Lorem Ipsum sur un texte générique comme 'Du texte. Du texte. Du texte.' est qu'il possède une distribution de lettres plus ou moins normale, et en tout cas comparable avec celle du français standard. De nombreuses suites logicielles de mise en page ou éditeurs de sites Web ont fait du Lorem Ipsum leur faux texte par défaut, et une recherche pour 'Lorem Ipsum' vous conduira vers de nombreux sites qui n'en sont encore qu'à leur phase de construction. Plusieurs versions sont apparues avec le temps, parfois par accident, souvent intentionnellement (histoire d'y rajouter de petits clins d'oeil, voire des phrases embarassantes).
            
        //     " ,
        //     ] ;
        $products = [
            [
                "Designation" => "iPhone 14",
                "PU" => 799,
                "PHT" => 160,
                "Total_HT" => 639
            ],
            [
                "Designation" => "Samsung Galaxy S22",
                "PU" => 699,
                "PHT" => 140,
                "Total_HT" => 559
            ],
            [
                "Designation" => "MacBook Air",
                "PU" => 999,
                "PHT" => 200,
                "Total_HT" => 799
            ],
            [
                "Designation" => "Dell XPS 13",
                "PU" => 899,
                "PHT" => 180,
                "Total_HT" => 719
            ],
            [
                "Designation" => "Sony WH-1000XM4",
                "PU" => 349,
                "PHT" => 70,
                "Total_HT" => 279
            ],
            [
                "Designation" => "Bose QuietComfort 35",
                "PU" => 299,
                "PHT" => 60,
                "Total_HT" => 239
            ],
            [
                "Designation" => "Apple Watch Series 8",
                "PU" => 399,
                "PHT" => 80,
                "Total_HT" => 319
            ],
            [
                "Designation" => "Fitbit Charge 5",
                "PU" => 179,
                "PHT" => 36,
                "Total_HT" => 143
            ],
            [
                "Designation" => "Nintendo Switch",
                "PU" => 299,
                "PHT" => 60,
                "Total_HT" => 239
            ],
            [
                "Designation" => "PlayStation 5",
                "PU" => 499,
                "PHT" => 100,
                "Total_HT" => 399
            ],
            [
                "Designation" => "Xbox Series X",
                "PU" => 499,
                "PHT" => 100,
                "Total_HT" => 399
            ],
            [
                "Designation" => "GoPro HERO10",
                "PU" => 399,
                "PHT" => 80,
                "Total_HT" => 319
            ],
            [
                "Designation" => "Kindle Paperwhite",
                "PU" => 129,
                "PHT" => 26,
                "Total_HT" => 103
            ],
            [
                "Designation" => "Samsung QLED TV",
                "PU" => 1099,
                "PHT" => 220,
                "Total_HT" => 879
            ],
            [
                "Designation" => "LG OLED TV",
                "PU" => 1299,
                "PHT" => 260,
                "Total_HT" => 1039
            ],
            [
                "Designation" => "Dyson V11 Vacuum",
                "PU" => 599,
                "PHT" => 120,
                "Total_HT" => 479
            ],
            [
                "Designation" => "iPad Pro",
                "PU" => 799,
                "PHT" => 160,
                "Total_HT" => 639
            ],
            [
                "Designation" => "eee",
                "PU" => 749,
                "PHT" => 150,
                "Total_HT" => 599
            ],
            [
                "Designation" => "Canon EOS R6",
                "PU" => 2499,
                "PHT" => 500,
                "Total_HT" => 1999
            ],
            [
                "Designation" => "Nikon Z6 II",
                "PU" => 1999,
                "PHT" => 400,
                "Total_HT" => 1599
            ] ,
            [
                "Designation" => "Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500,",
                "PU" => 1999,
                "PHT" => 400,
                "Total_HT" => 1599
            ] ,
        ];
        


        $x = $this->globalX =  $this->pagePaddingX;
        $y =  $this->GetY() + $this->mainSpace;
        
        $this->SetXY($x, $y);
        $this->SetWidths($this->get_widths($header));
        $this->Row($header);
        $y = $this->GetY() ;
        $this->globalY = $y ;

        // * 

        $this->tableY = $y ;

        $heightTable = $this->GetPageHeight() - $this->GetY() - $this->footerHeight - $this->breakAfter  ;
        $this->Rect($x,  $y , $this->pageContainerWidth,  $heightTable  , "D");
        
        $x1 = $x ;
        $y2 = $y +  $heightTable   ;
       

        for ($i = 0; $i < count($header) ; $i++) {
            $this->Line($x1, $y, $x1, $y2  );
            $x1 += $this->pageContainerWidth / count($header);
        }

       

        foreach( $products as $dt  ) {
            $positionTable = $this->tableY + $heightTable  ;
            $check = $this->checkLine($this->prepareRow($dt)) ;

            if ( $check > $positionTable    ) {
                $this->AddPage();
                $this->SetXY($x,  $this->headerHeight + $this->mainSpace );
                $this->Row($header);
                $this->tableY =  $this->globalY = $this->GetY() ;
                $heightTable = $this->GetPageHeight() - $this->GetY() - $this->footerHeight - $this->breakAfter  ;
                $this->Rect($x, $this->GetY() , $this->pageContainerWidth,  $heightTable  , "D");

                $x1 = $x ;
                $y2 =  $this->GetY() +  $heightTable ;
                for ($i = 0; $i < count($header) ; $i++) {
                    $this->Line($x1, $this->GetY() , $x1, $y2  );
                    $x1 += $this->pageContainerWidth / count($header);
                }
            }

            $this->newLine( $this->prepareRow($dt) ) ;
        }
        

    }

    private function newLine($row) {
        $array_Y = [] ;
        $x = $this->globalX ;
        $y = $this->globalY + 5 ;

        foreach( $row as $singleRow  ) {
            $this->SetXY($x, $y ) ;
            $this->MultiCell($singleRow['size'] , 5  , $singleRow['content'] , 0 , 'C' ) ;
            $x+= $singleRow['size'] ; 
            $array_Y[] = $this->GetY() ;
        }

        $this->globalY = max($array_Y) ;

    }

    private function checkLine($row) {
        $array_Y = [] ;
        $x = $this->globalX ;
        $y = $this->globalY + 5 ;

        foreach( $row as $singleRow  ) {
            $this->SetXY( -1000000 , $y ) ;
            $this->MultiCell($singleRow['size'] , 5  , $singleRow['content'] , 0 , 'C' ) ;
            $x+= $singleRow['size'] ; 
            $array_Y[] = $this->GetY() ;
        }

        return max($array_Y) ;

    }


    private function prepareRow($row) {
        $header = ["Designation", "PU", "PHT" , "Total_HT"];
        $retour = [] ;
        $sizes = $this->get_width_cols($header) ;
        foreach( $row as $key => $val ) {
            $retour[] = [
                "size" => $sizes[$key] ,
                "content" => $val
            ] ;
        }

        return $retour ;
    }

    private function getLastPosOfline($row){

        
    }

    private function get_widths(array  $data)
    {
        $retour = [];
        for ($i = 0; $i < count($data); $i++) {
            $retour[] = $this->pageContainerWidth / count($data);
        }
        return $retour;
    }


    private function get_width_cols(array  $header) {
        $retour=[] ;
        for ( $i = 0 ; $i < count($header) ; $i++ ) {
            $retour[$header[$i]] = $this->pageContainerWidth / count($header)  ;
        }

        return $retour ;
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

    private function right()
    {
        $x = $this->pageContainerWidth / 2;
        $y = $this->headerHeight + $this->pagePaddingY + $this->mainSpace;
        $this->SetXY($x, $y);
        foreach ($this->data['document_infos']['left'] as $key => $line) { // fixed key to 'right'
            $this->Cell(0, 5, $key . " : " . $line, 0, 0, "R");
            $this->SetXY($x, $this->GetY() + 5);
        }
    }

    // private function addLine( $data ,$ligne, $tab)
    // {

    //     $ordonnee = 5;
    //     $maxSize = $ligne;

    //     foreach ($data as $lib => $pos) {
    //         $longCell = $pos - 1;
    //         $texte = $tab[$lib];
    //         $this->SetXY($ordonnee, $ligne - 1);
    //         $this->MultiCell($longCell, 4, $texte, 0, "C");
    //         if ($maxSize < ($this->GetY())) {
    //             $maxSize = $this->GetY();
    //         }
    //         $ordonnee += $pos;
    //     }
    //     return ($maxSize - $ligne);
    // }




    private function sizeOfText($texte, $largeur)
    {
        $index = 0;
        $nb_lines = 0;
        $loop = true;
        while ($loop) {
            $pos = strpos($texte, "\n");
            if (!$pos) {
                $loop = false;
                $ligne = $texte;
            } else {
                $ligne = substr($texte, $index, $pos);
                $texte = substr($texte, $pos + 1);
            }
            $length = floor($this->GetStringWidth($ligne));
            $res = 1 + floor($length / $largeur);
            $nb_lines += $res;
        }
        return $nb_lines;
    }

    public function Footer()
    {

        $this->SetY( - $this->footerHeight  );
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(0,  $this->footerHeight , 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}