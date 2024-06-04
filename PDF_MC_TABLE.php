<?php

class Pdf_mc_table extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'RL';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 5,  iconv('UTF-8', 'ISO-8859-1', $data[$i]), 0, 'C');
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function DashedLine($x1, $y1, $x2, $y2, $dash_length = 1, $space_length = 1)
    {
        $this->SetLineWidth(0.1);
        $this->SetDrawColor(0, 0, 0);
        $dash_length *= $this->k;
        $space_length *= $this->k;

        $x1 *= $this->k;
        $y1 = ($this->h - $y1) * $this->k;
        $x2 *= $this->k;
        $y2 = ($this->h - $y2) * $this->k;

        $dx = $x2 - $x1;
        $dy = $y2 - $y1;
        $hyp = sqrt($dx * $dx + $dy * $dy);
        $cos = $dx / $hyp;
        $sin = $dy / $hyp;
        $current_x = $x1;
        $current_y = $y1;

        while ($hyp > 0.000001) {
            $this->Line($current_x, $current_y, $current_x + $dash_length * $cos, $current_y + $dash_length * $sin);
            $current_x += ($dash_length + $space_length) * $cos;
            $current_y += ($dash_length + $space_length) * $sin;
            $hyp -= $dash_length + $space_length;
        }
    }
}
