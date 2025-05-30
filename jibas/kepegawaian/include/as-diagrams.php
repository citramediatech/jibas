<?
/**[N]**
 * JIBAS Education Community
 * Jaringan Informasi Bersama Antar Sekolah
 * 
 * @version: 32.0 (Feb 05, 2025)
 * @notes: 
 *  
 * Copyright (C) 2024 JIBAS (http://www.jibas.net)
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *  
 * You should have received a copy of the GNU General Public License
 **[N]**/ ?>
<?php
//require_once('config.php');
/*
============================================================================
as-diagrams.php - bar charts drawing class (CAsBarDiagram)
version 1.0.10  last modification: 17.01.2006 (dd.mm.yyyy)
Written by Alexander Selifonov,  http://as-works.narod.ru
Please read "as-diagrams.htm" for detailed instructions
============================================================================
*/
$css_drawn = 0;
class CAsBarDiagram
{ // bar diagram class
  var $imgpath = '../include/img/'; // place all 'diagram' images in this "folder";
  var $bt_lgtitle = '';
  var $graf_height = 240;
  var $bwidth = 0;
  var $precision  = 2;
  var $bt_total   = 'Totals';
  var $showtotals = 1;
  var $btilemode = 0;
  var $showdigits = 1; // in the bottom show digits by default
  var $autoshrink = 1024; // auto-adjust graph width to not greater than this value (pixels)
  var $legendx_url = ''; // URL with {ID} macro. If not empty, legend texts on X-axis become "hrefs"
  var $legendx_onClick = ''; // onClick event string, for the URL above, (with {ID} macro)
  var $legendy_url = ''; // URL with {ID} macro. If not empty, legend texts on Y-axis become "hrefs"
  var $legendy_onClick = ''; // onClick event string, for the URL above, (with {ID} macro)
  var $cell_url = ''; // tamplate for cell-URLs : {X}, {Y} will be subst-ed with current x,y "legend" values
  var $legendx_id = 0; // here must be an array of ID values for all x URL's. If not set, titles will be used
  var $data = array();
  var $legendx = array(); // for auto-making legend from SQL query
  var $legendy = array();
  var $ShowPercents = array(); // one element: showPercents['legend_y'] = "title" - as percent after [n2] row
  var $debug = 0; // show debug info

  function InitData($legend_x=0, $legend_y=0)
  { // clears all gathered data. If legends passed, fills (X x Y) with 0 values
    $this->data = array();
    if(!is_array($legend_x) || !is_array($legend_y)) return;
    $lenx = count($legend_x);
    $leny = count($legend_y);
    $onecol = array();
    for($kk=0; $kk<$leny; $kk++) {
        $onecol[] = 0;
    }
    for($kk=0; $kk<$lenx; $kk++) {
        $ret[] = $onecol;
    }
  }

  function DiagramBar($legend_x='', $legend_y='', $dtarray=0, $data_title='')
  {
    global $css_drawn;
    if(!is_array($legend_x)) $legend_x = $this->legendx;
    if(!is_array($legend_y)) $legend_y = $this->legendy;
    if(count($this->ShowPercents)>0)
        $this->showdigits |= 1;
    if(empty($css_drawn))
    { //<2>
         $css_drawn = 1;
?>
<STYLE TYPE="text/css">
<!--
tr.barodd   { background-color: #ffffff; color:#000000;
              FONT-size: 10px; FONT-FAMILY: Arial, Helvetica;
            }
tr.bareven  { background-color: #d5d5d5; color:#000000;
              FONT-size: 10px; FONT-FAMILY: Arial, Helvetica;
            }
tr.barhead  { background-color: #3fa64b; color:#000000;
           BORDER-TOP: 1px solid #0a931e; BORDER-LEFT: 1px solid #0a931e ;
           BORDER-RIGHT: 1px solid #0a931e ; BORDER-BOTTOM: 1px solid #0a931e ;
           font-size: 12px; FONT-FAMILY: Arial, Helvetica; font-weight: bold;
           text-align: center;
           filter: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#f8fffc,endColorStr=#c0f0c3);
}
td.barhead  { background-color: #3fa64b; color:#000000;
           BORDER-TOP: 1px solid #0a931e; BORDER-LEFT: 1px solid #0a931e;
           BORDER-RIGHT: 1px solid #0a931e; BORDER-BOTTOM: 1px solid #0a931e;
           font-size: 12px; FONT-FAMILY: Arial, Helvetica; font-weight: bold;
           filter: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#f8fffc,endColorStr=#c0f0c3);
}
-->
</STYLE>
<?
    } //<2> - draw css block for drawing bars
    $data = (is_array($dtarray))? $dtarray : $this->data;
    // if data array not passed, we use prepared array filled by GatherData()

    $bar[] = 'bar-v01.png';
    $bar[] = 'bar-v02.png';
    $bar[] = 'bar-v03.png';
    $bar[] = 'bar-v04.png';
    $bar[] = 'bar-v05.png';
    $bar[] = 'bar-v06.png';
    $bar[] = 'bar-v07.png';
    $bar[] = 'bar-v08.png';
    $bar[] = 'bar-v09.png';
    $bar[] = 'bar-v10.png';
    $bar[] = 'bar-v11.png';
    $bar[] = 'bar-v12.png';

    if(!empty($this->btilemode)) { //  tiled picture arrenged with css
     echo "<style TYPE='text/css'>\n";
     for($ii=0; $ii<count($bar); $ii++) {
        $img = $this->imgpath.$bar[$ii];
        echo "  td.tbar{$ii} {  background-image: url($img); background-repeat: repeat; }\n";
     }
     echo "</style>\n";
   }

  if(empty($this->graf_height)) $this->graf_height = 240; // workarea height

  if(empty($this->bwidth)) $this->bwidth = 0; // one bar width, px, 0=auto

  if(!empty($data_title))
    echo "<h3 align=center>$data_title</h3>\n<p>";
  $bgpic = $this->imgpath.'bar-bg'.$this->graf_height. '.png'; // background picture under bars
  $maxval = 0;
  $minval = 0;
  for($i=0; $i < count($legend_x); $i++)
  {
    for($j=0; $j < count($legend_y); $j++) {
      $vl = empty($data[$i][$j]) ? 0 : floatval($data[$i][$j]);
      $maxval = max($maxval, $vl);
      $minval = min($minval, $vl);
    }
  }

  // $maxval,$minval - compute values nearest to max, base-multiplied numbers

  $pos_part = ($maxval > 0); // true - positive area exist
  $neg_part = ($minval < 0); // true - negative area exist

  if($pos_part)
  { //<1-1>
    $maxfound = false;
    $decbase = array(0.01, 0.016, 0.02, 0.024, 0.032, 0.04, 0.05,0.06,0.08);
    for($tt=0; ($tt < 15) && (!$maxfound); $tt++)
    { //<2>
     for($ii=0; $ii < count($decbase); $ii++) { //<3>
      if ($maxval < $decbase[$ii]) {
         $maxval = $decbase[$ii];
         $maxfound = true;
         break;
      }
      $decbase[$ii] = $decbase[$ii]*10; // next loop - next scale check
     } //<3>
    } //<2>
  } //<1-1>
  $Ystep = floor($maxval/4); // ���� 1 ������� �� ��� Y

  if($neg_part)
  { //<1-1>
    $decbase = array(0.01, 0.016, 0.02, 0.024, 0.032, 0.04, 0.05,0.06,0.08);
    $maxfound = false;
    for($tt=0; ($tt < 15) && (!$maxfound); $tt++)
    { //<2>
     for($ii=0; $ii < count($decbase); $ii++) { //<3>
      if ( $minval >(-1)*$decbase[$ii]) {
         $minval = (-1)*$decbase[$ii];
         $maxfound = true;
         break;
      }
      $decbase[$ii] *= 10; // next loop - next scale check
     } //<3>
    } //<2>
    $Ystep = abs($minval)/4;
  } //<1-1>


  // evaluate positive and negative parts scales
  // So if max=200 and min=-40 we make Y-axis  "+200...0...-50"
  // $steps_pos|neg - number of "steps" on Y axis (pos. and neg.)
  $steps_pos = ($pos_part)? 4 : 0;
  $steps_neg = ($neg_part)? 4 : 0;

  if($pos_part && $neg_part) { //<2>
     if($maxval>=abs($minval)) { // <3> (+)area greater, cut down negative part
       $Ystep = $maxval/4;
       if (abs($minval) <= $maxval/4) $steps_neg = 1; // 1/4
       elseif (abs($minval) <= $maxval/2) $steps_neg = 2; // 2/4
       elseif (abs($minval) <= $maxval*3/4) $steps_neg = 3; // 2/4
       else $steps_neg = 4; // 4/4
       $minval = $maxval*$steps_neg/(-4);
     } //<3>
     else {  // <3> (-)area greater, cut down positive part
       $Ystep = abs($minval)/4;
       if ($maxval <= abs($minval)/4) $steps_pos = 1; // 1/4
       elseif ($maxval <= abs($minval)/2) $steps_pos = 2; // 2/4
       elseif ($maxval <= abs($minval)*3/4) $steps_pos = 3; // 3/4
       else $steps_pos = 4;
       $maxval = $minval*$steps_pos/(-4);
     } //<3>
  } //<2>

  // so, we have $pos_part(true), $neg_part(true), $Ystep, $steps_pos, $steps_neg

  if( empty($this->bwidth))
  { // compute optimal width for one bar (�������� ����������� ������ ��������)
     $this->bwidth = 740/(count($legend_x)*(count($legend_y)+1));
     $this->bwidth = floor($this->bwidth);
  }
  else

  if(($this->autoshrink>0) && (count($legend_x)*(count($legend_y))*$this->bwidth > $this->autoshrink))
  { // ������������� �������� ������ ��������, ���� �� ������� �����
     $this->bwidth = floor($this->autoshrink/(count($legend_x)*count($legend_y)));
  }
  $this->bwidth = max($this->bwidth,4); // width is at least 4px
  $ewidth = $this->bwidth+2; // empty bars width, plus border 2px
  $height_q = floor($this->graf_height/4);
  $bars_width = 240 + count($legend_x)*(count($legend_y)+1)*$this->bwidth; // minimal pixel width needed for diagram
  if($bars_width>900)
  {
    $gr_width = '100%';
    $tdwidth = floor(100/count($legend_x)).'%'; // one chart "block" width
  }
  else
  {
    $gr_width = $bars_width;
    $tdwidth = (count($legend_y)+1)*($this->bwidth+2);
  }

  $legend_drawn = false; // turn to true when legend has drawn
  //echo "height : $graf_height, maxval: $maxval <!-- grafiki outline table -->";
  echo "<!-- bar ouline table-->\n<P align=center>";
  echo "<table name='001' width='$gr_width' border=0 cellspacing=1 cellpadding=0>\n";

  // first row (+) - is a main, Y axis, charts and legend if needed
  if($steps_pos>0)
  { //<2>- pos_parts>
    $pos_h = floor($height_q*$steps_pos);

    echo "<tr height=$pos_h><td valign=top>\n";

    // sub-table for Y axis
    echo "<table width='100%' sname=002 border=0 cellspacing=0 cellpadding=0>\n";
    for ($kk=1; $kk<=$steps_pos; $kk++)
    {
      $cls = ($kk % 2) ? 'barodd' : 'bareven';
      $nNo = ( ($steps_pos+1-$kk) * $maxval / $steps_pos );
      $fNo = ($nNo == floor($nNo)) ? number_format($nNo) : number_format($nNo,$this->precision);
      echo "<tr class='$cls' valign=top height='$height_q'><td width='100%' nowrap valign=top align=right><b>$fNo</b></td></tr>\n";
    }
    echo "</table></td><!-- Y(+) axis done -->\n";

    echo "<!-- (+)main graphics area maxval = $maxval-->\n";

//    if($maxval<1) $maxval=2; // TODO: values less than 1 - 0.005... ???!!!
    for ($ix=0; $ix < count($legend_x); $ix++)
    {
      echo "<Td nowrap width='$tdwidth' align=center valign=bottom
      style=\"background-image: url($bgpic); background-repeat: repeat; \">\n";
      echo " <table border=0 cellspacing=0 cellpadding=0><tr valign=bottom>\n";
      for($iy=0; $iy < count($legend_y); $iy++)
      { //<4>
        $pc = $bar[$iy % count($bar)]; // todo - $iy % count($bar);
        $value = empty($data[$ix][$iy]) ? 0 : floatval($data[$ix][$iy]);
        $hght = floor($value * $height_q * $steps_pos / $maxval);
//        echo "height[$ix,$iy] = $hght = ($value * $height_q * $steps_pos / $maxval )<br>"; // debug
        $onebar = ( empty($this->btilemode)? "<img src='$this->imgpath$pc' width=$this->bwidth height=$hght border=1 bordercolor=black>" :
            "<table cellspacing=0 border=0 cellpadding=0><tr><td class='tbar$iy'><img src='{$this->imgpath}empty.png'
            width=$this->bwidth height=$hght border=1 bordercolor=black></td></tr></table>");
        if(!empty($this->cell_url))
        {
          $ato = array( $legend_x[$ix], $legend_y[$iy]);
          $onebar = "<a href='".(str_replace(array('{X}','{Y}'),$ato, $this->cell_url))."'>$onebar</a>";
        }
        if($hght>0) {
          echo empty($this->btilemode)? "<td>$onebar</td>" : "<table cellspacing=0 border=0 cellpadding=0><tr><td class='tbar$iy'>$onebar</td></tr></table>";
        }
        else { // draw "empty" block with the same width
          echo "<td><img width=$ewidth height=1 border=0></td>";
        }
      } //<4>
      echo " </tr></table>"; // inner table for bars
      echo "</Td>";
    }
  //echo "</tr></table><!-- 003 finish -->";

    echo "\n<!-- (+)main graphics area finished-->\n";

    $legend_drawn = true;
    echo "<td nowrap valign=top width=0 align=center class='barhead'><!-- legend area -->\n";
    if(empty($this->showdigits))
    { //<3>
      echo "  <table name='legend' width=0 border=0>";
      for ($iy=0; $iy<count($legend_y); $iy++)
      {
        $pc = $bar[$iy % count($bar)];
        $lgd = $legend_y[$iy];
        echo "   <tr><td nowrap><img src='$this->imgpath$pc' width=$this->bwidth height=12 border=1 bordercolor=black></td><td nowrap>$lgd</td></tr>\n";
       }
       echo "  </table><!-- legend -->\n";
    } //<3>
    echo "</td><!-- main Legend area finished-->\n";

    echo "</tr>\n<!-- X axis area -->\n";
  // now it's time to draw  X-axis
  } //<2>- pos_parts>

  // Negative values area
  if($steps_neg>0)
  { // <2>-draw negative values area
    $neg_h = floor($height_q*$steps_neg);
    $absmin = abs($minval);
    echo "<tr height=$neg_h class='barhead'><td valign=top>\n";

    // ������ ���-������� ��� ��� Y(-)
    echo "<table width='100%' sname=002 border=0 cellspacing=0 cellpadding=0>\n";
    for ($kk=1; $kk<=$steps_neg; $kk++)
    {
      $cls = ($kk % 2) ? 'barodd' : 'bareven';
      $nNo = ( $kk * $absmin / $steps_neg );
      $fNo = ($nNo == floor($nNo)) ? number_format($nNo) : number_format($nNo,$this->precision);
      echo "<tr class='$cls' valign=top height='$height_q'><td nowrap width='100%' valign=bottom align=right><b>-$fNo</b></td></tr>\n";
    }
    echo "</table></td><!-- Y(-) axis done -->\n";
    // Y(-) axis drawn - Y-axis done, now we'll draw area with the bar charts

    echo "<!-- (-)main graphics area minval = $minval-->\n";

//    if($absmin<1) $absmin=2; // TODO: values less than 1 - 0.005... ???!!!
    for ($ix=0; $ix < count($legend_x); $ix++)
    {
      echo "<td nowrap width='$tdwidth' align=center valign=top
       style=\"background-image: url($bgpic); background-repeat: repeat; \">\n";

      echo " <table border=0 cellspacing=0 cellpadding=0><tr valign=top>\n";
      for($iy=0; $iy < count($legend_y); $iy++)
      {
        $pc = $bar[$iy % count($bar)]; // todo - $iy % count($bar);
        $value = empty($data[$ix][$iy]) ? 0 : floatval($data[$ix][$iy]);
        $hght = -1 * floor($value * $height_q * $steps_neg / $absmin);
//        echo "height $hght = ($value * $steps_pos * $Ystep / $maxval )<br>"; // debug
        if($hght>0) {
          echo empty($this->btilemode) ? "<td><img src='$this->imgpath$pc' width=$this->bwidth height=$hght border=1 bordercolor=black></td>"
          : "<td><table cellspacing=0 border=0 cellpadding=0><tr><td class='tbar$iy'><img src='{$this->imgpath}empty.png' width=$this->bwidth height=$hght border=1 bordercolor=black></td></tr></table></td>";
        }
        else // draw "empty" block with the same width
          echo "<td><img width=$ewidth height=1 border=0></td>";
      }
      echo " </tr></table>\n";
      echo "</td>";
    }

    echo "\n<!-- (-)main graphics area finished-->\n";

    echo "<td valign=top width=0 align=center  class='barhead'><!-- legend area -->\n";
    if(empty($legend_drawn) && empty($this->showdigits))
    { // <3-legend in neg.area>
      echo "  <table name='legend' width=0 border=0>";
      for ($iy=0; $iy<count($legend_y); $iy++)
      {
       $pc = $bar[$iy % count($bar)];
       $lgd = $legend_y[$iy];
       echo "   <tr><td><img src='$this->imgpath$pc' width=$this->bwidth height=12 border=1 bordercolor=black></td><td>$lgd</td></tr>\n";
      }
      echo "  </table><!-- legend -->\n";
    } // <3-legend in neg.area>
//    else echo "<table width=0 border=0><tr><td></td></tr></table>";

    echo "</td><!-- main Legend area finished-->\n";

  } // <2>-draw negative values area

  $cspan = count($legend_x)+2;

  // values in numeric form, and totals column
  echo "<tr height=4><td colspan=$cspan class='barhead'><img height=4></td></tr>"; // for nicer look

  echo "<tr class='barhead'><td class='head'>$this->bt_lgtitle</td>"; // left bottom td - legend y titles
  for($ix=0; $ix<count($legend_x); $ix++) { //<2>
    // $legendx_url, $legendx_onClick - use them !
    $ltext = $legend_x[$ix];
    if(!empty($this->legendx_url)) { //<3>
       $idval = isset($this->legendx_id[$ix]) ? $this->legendx_id[$ix] : $legend_x[$ix];
       $lurl = str_replace('{ID}',$idval, $this->legendx_url);
       $onClick = empty($this->legendx_onClick) ? '' : str_replace('{ID}',$idval, 'onClick="'.$this->legendx_onClick.'"');
       $ltext = "<a href='$lurl' $onClick>$ltext</a>";
    } //<3>
    echo "<td class='barhead' nowrap>$ltext</td>\n";
  } //<2>
  echo "<td class='barhead'>".( (($this->showtotals & 1) && $this->showdigits) ? $this->bt_total :'')."</td></tr>\n"; // ��� ������ ��������
//echo "<table border=0><tr><td align=right>����-�</td></tr>\n";
  if($this->showdigits)
  { //<2> output number presentation of samples
    $cls = 'barodd';
    for ($iy=0; $iy<count($legend_y); $iy++)
    { //<3>
//   $pc = $bar[$iy]; // todo - $iy % count($bar);
      $summs = 0;
      $lgd = $legend_y[$iy];
      if(!empty($this->legendy_url)) { //<3>
         $idval = isset($this->legendy_id[$iy]) ? $this->legendy_id[$iy] : $legend_y[$iy];
         $lurl = str_replace('{ID}',$idval, $this->legendy_url);
         $onClick = empty($this->legendy_onClick) ? '' : str_replace('{ID}',$idval, 'onClick="'.$this->legendy_onClick.'"');
         $lgd = "<a href='$lurl' $onClick>$lgd</a>";
      } //<3>

      $cls = ($cls=='bareven') ? 'barodd' : 'bareven';
      $igrf = $iy % count($bar); // no more bar samples - rotate them !
      $img = $this->imgpath.$bar[$igrf];
      echo "   <tr class='$cls'><td nowrap><img src='$img' width=$this->bwidth height=12 border=1 bordercolor=black> $lgd</td>\n";
      for($ix=0; $ix<count($legend_x); $ix++)
      {
        $value = empty($data[$ix][$iy]) ? 0 : number_format($data[$ix][$iy], $this->precision);
        $summs += empty($data[$ix][$iy])? 0 : $data[$ix][$iy];
        echo "   <td align=right nowrap>&nbsp; $value &nbsp;</td>\n";
      }
      $smm = ($this->showtotals & 1) ? number_format($summs, $this->precision): '';
      echo "<td align=right nowrap><b>&nbsp; $smm &nbsp;</b></tr>\n";

      if(!empty($this->ShowPercents[$lgd]) && ($iy>=1) )
      { //<4> draw data[n-1]/data[n]*100 in percents
        $y2 = $iy; // last row
        $y1 = $iy-1; // row before last
        $prcttl = (strlen($this->ShowPercents[$lgd]) ? $this->ShowPercents[$lgd] : $legend_y[$y1].'/'.$legend_y[$y2].',%');
        $cls = ($cls=='bareven') ? 'barodd' : 'bareven';
        echo "   <tr class='$cls'><td nowrap>$prcttl</td>\n"; // title "percents"
        $sum1 = 0;
        $sum2 = 0; // for totals percents
        for($ix=0; $ix<count($legend_x); $ix++)
        {
          $sum1 += (empty($data[$ix][$y1]) ? 0 : $data[$ix][$y1]);
          $sum2 += (empty($data[$ix][$y2]) ? 0 : $data[$ix][$y2]);
          $value = (empty($data[$ix][$y2])  ? '' : $data[$ix][$y1]*100/$data[$ix][$y2] );
          if($value !='') {
           if( abs($value) > 10) $value = round($value);
           else $value = round($value,2);
          }
          echo "   <td align=right nowrap>&nbsp; $value &nbsp;</td>\n";
        }
        $totprc = ($sum2!=0 ? round($sum1*100/$sum2,2): 0);
        if($totprc>10) $totprc = round($totprc);
        $prctotal = ($this->showtotals & 1) ? $totprc : '';
        echo "<td align=right nowrap><b> $prctotal &nbsp; </b></tr>\n";
      } //<4>

    } //<3>

    if(($this->showtotals & 2))
    { // <4> count 'horizontal' totals
      $cls = ($iy % 2) ? 'barodd' : 'bareven';
      echo "   <tr class='$cls'><td nowrap>$this->bt_total</td>\n"; // title "totals"
      for($ix=0; $ix<count($legend_x); $ix++)
      {
        $value = 0;
        for($yy=0; $yy<count($legend_y); $yy++)
            $value += (empty($data[$ix][$yy]) ? 0 : $data[$ix][$yy]);
        if( abs($value) > 10) $value = round($value);
        else $value = round($value,2);

        $value = number_format($value);
        echo "  <td align=right nowrap>&nbsp; $value &nbsp;</td>\n";
      }
      echo "<td nowrap><b>&nbsp;</b></tr>\n";
    } //<4>
  } //<2> - $this->showdigits

  echo "</table><!-- 001 finish -->\n</p>";
 // bar chart drawn


  } // DiagramBar() end

  function GatherData($sqlquery, $legend_x='', $legend_y='', $position_y=-1)
  { // runs sql query and places all needed data into array for drawing
    // if legend_* array not passed, SQL query will be used to make them
//    echo "GatherData: $sqlquery<br>"; // debug
    $onecol = array();
    $lenx = is_array($legend_x) ? count($legend_x) : 0;
    $leny = is_array($legend_y) ? count($legend_y) : 0;
    for($kk=0; $kk<max($leny,1); $kk++) {
        $onecol[] = 0;
    }
    for($kk=0; $kk<$lenx; $kk++) {
        if(!isset($this->data[$kk][0]))
          $this->data[$kk] = $onecol;
    }
    // $array[$lenx][$lny] ready for filling with data
    $res = mysqli_query($sqlquery);
    if($this->debug) {
      if($res === false)
        echo "GatherData query error, qry: $sqlquery<br>Error:".mysqli_error();
      else
        echo "GatherData: query : $sqlquery<br>returned rows:".mysqli_affected_rows().'<br>';
    }
    $cur_x = '-?-';
    $cur_y = '-?-';
    $x_pos = 0;
    $y_pos = 0;
    if($res) { //<3>
        while(($rw = mysqli_fetch_row($res)))
        { //<4>
           $rcnt = count($rw);
           if($rcnt<2) return 0; // wrong sql query !
           $summa = $rw[$rcnt-1];
           if(is_array($legend_x))
           { //<5>
             $x_pos = -1;
             for($kk=0; $kk<$lenx; $kk++)
             {
                 if($rw[0] == $legend_x[$kk]) {$x_pos=$kk; break; }
             }

           } //<5>
           else
           { //<5>
              if($cur_x !== $rw[0]) { //<6>
                $cur_x = $rw[0];
                for($x_pos=0; $x_pos<count($this->legendx); $x_pos++)
                { if($this->legendx[$x_pos]===$cur_x) break; }
                if($x_pos>=count($this->legendx))
                { // <7> add new title to 'internal' legendx array
                    $this->legendx[] = $cur_x;
                    $x_pos = count($this->legendx)-1;
                } //<7>
              } //<6>

           } //<5>

           if(is_array($legend_y) && count($legend_y)>0)
           { //<5>
             $y_pos = -1;
             if($rcnt<3 || $position_y>=0) { $y_pos = $position_y; }
             else { //<6>
//             $summa = $rw[2];
               for($kk=0; $kk<$leny; $kk++)
               { //<7>
//                 if($this->debug) echo "test y: $kk ==".$legend_y[$kk].'/'.$rw[1]."<br>\n";
                 if($rw[1] == $legend_y[$kk]) {$y_pos=$kk; break; }
               } //<7>
             } //<6>
           } //<5>
           else
           { //<5-else>
             if($cur_y !== $rw[1]) { //<6>
                $cur_y = $rw[1];
                for($y_pos=0; $y_pos<count($this->legendy); $y_pos++)
                { if($this->legendy[$y_pos]===$cur_y) break; }
                if($y_pos>=count($this->legendy))
                {// <7>add new title to 'internal' legend-y
                    $this->legendy[] = $cur_y;
                    $y_pos = count($this->legendy)-1;
                } //<7>
             } //<6>

           } //<5-else>
           if($x_pos>=0 && $y_pos>=0)
           {
              $this->data[$x_pos][$y_pos] = $summa;
           }
/*           else {
                if($this->debug) echo "wrong position for Data in ".$rw[0].($rcnt>2 ? ','.$rw[1] : '').'<br>';
           }
*/
//           else echo "nowhere to put data for [".$rw[0]."][".$rw[1]."]<br>"; // debug
           if($this->debug) echo "[$cur_x,$cur_y] [$x_pos][$y_pos] = $summa<br>\n";
        } //<4>
    } //<3>
    else echo "GatherData: Error in query : $sqlquery<br>error : ".mysqli_error();
//    var_dump($this->legendx);  var_dump($this->legendy); // debug
    return $this->data;
  } //<GatherData() function end
} // end class definition CAsBarDiagram
?>