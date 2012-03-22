<?php
  class BarGraph {
  var $identidades=1;
    /**
     * BarGraph::bar_width
     * Width of bars
     */
    var $bar_width = 25;
    /**
     * BarGraph::bar_height
     * Height of bars
     */
    var $bar_height = 8;
    /**
     * BarGraph::bar_data
     * Data of all bars
     */
    var $bar_data = array('a' => 7, 'b' => 3, 'c' => 6, 'd' => 0, 'e' => 2);
    /**
     * BarGraph::bar_padding
     * Padding of bars
     */
    var $bar_padding = 5;
    /**
     * BarGraph::bar_bordercolor
     * Border color of bars
     */
    var $bar_bordercolor = array(39, 78, 120);
    /**
     * BarGraph::bar_bgcolor
     * Background color of bars
     */
    var $bar_bgcolor = array(array(169, 129, 194),array(69, 229, 194),array(69, 129, 94));
    //---------------------------------------------
    /**
     * BarGraph::graph_areaheight
     * Height of graphic area
     */
    var $graph_areaheight = 250;
    /**
     * BarGraph::graph_padding
     * Paddings of graph
     */
    var $graph_padding = array('left' => 50, 'top' => 20, 'right'  => 20, 'bottom' => 20);
    /**
     * BarGraph::graph_title
     * Title text of graph
     */
    var $graph_title = "";
    /**
     * BarGraph::graph_bgcolor
     * Background color of graph
     */
    var $graph_bgcolor = array(255, 255, 255);
    /**
     * BarGraph::graph_bgtransparent
     * Boolean for background transparency
     */
    var $graph_bgtransparent = 0;
    /**
     * BarGraph::graph_transparencylevel
     * Transparency level (0=opaque, 127=transparent)
     */
    var $graph_transparencylevel = 0;
    /**
     * BarGraph::graph_borderwidth
     * Width of graph border
     */
    var $graph_borderwidth = 1;
    /**
     * BarGraph::graph_bordercolor
     * Border color of graph
     */
    var $graph_bordercolor = array(218, 218, 239);
    /**
     * BarGraph::graph_titlecolor
     * Color of title text of graph
     */
    var $graph_titlecolor = array(99, 88, 78);
    //---------------------------------------------
    /**
     * BarGraph::axis_step
     * Scale step of axis
     */
    var $axis_step = 2;
    /**
     * BarGraph::axis_bordercolor
     * Border color of axis
     */
    var $axis_bordercolor = array(99, 88, 78);
    /**
     * BarGraph::axis_bgcolor
     * Background color of axis
     */
    var $axis_bgcolor = array(152, 137, 124);
    


    /**
     * BarGraph::BarGraph()
     * Class Constructor
     **/
    function BarGraph() {
      //nothing @ the moment.. maybe later will set image at startup
    }

    /****************************************************************
                                GRAPH
    ****************************************************************/

    /**
     * BarGraph::SetGraphAreaHeight()
     * Sets graph height (not counting top and bottom margins)
     **/
    function SetGraphAreaHeight($height) {
      if ($height > 0) $this->graph_areaheight = $height;
    }
    
    function SetIdentidades($identidades) {
      if ($identidades > 0) $this->identidades = $identidades;
    }
    
    /**
     * BarGraph::SetGraphPadding()
     * Sets graph padding (margins)
     **/
    function SetGraphPadding($left, $top, $right, $bottom) {
      $this->graph_padding = array('left'   => (int) $left,
                                   'top'    => (int) $top,
                                   'right'  => (int) $right,
                                   'bottom' => (int) $bottom);
    }
    
    /**
     * BarGraph::SetGraphTitle()
     * Set title text
     **/
    function SetGraphTitle($title) {
      $this->graph_title = $title;
    }
    function SetLeyendas($array_leyendas) {
      $this->leyendas = $array_leyendas;
    }

    /**
     * BarGraph::SetGraphBorderColor()
     * Sets border color for graph
     **/
    function SetGraphBorderColor($red, $green, $blue) {
      $this->graph_bordercolor = array($red, $green, $blue);
    }

    /**
     * BarGraph::SetGraphBorderWidth()
     * Set width of border. 0 disables border
     **/
    function SetGraphBorderWidth($width = 0) {
      $this->graph_borderwidth = $width;
    }

    /**
     * BarGraph::SetGraphBackgroundColor()
     * Sets background color for graph
     **/
    function SetGraphBackgroundColor($red, $green, $blue) {
      $this->graph_bgcolor = array($red, $green, $blue);
    }

    /**
     * BarGraph::SetGraphBackgroundTransparent()
     * Sets background color for graph (and set it transparent)
     **/
    function SetGraphBackgroundTransparent($red, $green, $blue, $addtransparency = 1) {
      $this->graph_bgcolor = array($red, $green, $blue);
      $this->graph_bgtransparent = ($addtransparency ? 1 : 0);
    }
    
    /**
     * BarGraph::SetGraphTitleColor()
     * Sets title color for graph
     **/
    function SetGraphTitleColor($red, $green, $blue) {
      $this->graph_titlecolor = array($red, $green, $blue);
    }
    
    /**
     * BarGraph::SetGraphTransparency()
     * Sets transparency for graph
     **/
    function SetGraphTransparency($percent) {
      if ($percent < 0) $percent = 0;
      elseif ($percent > 100) $percent = 127;
      else $percent = $percent * 1.27;
      $this->graph_transparencylevel = $percent;
    }

    /****************************************************************
                                 BAR
    ****************************************************************/

    /**
     * BarGraph::SetBarBorderColor()
     * Sets border color for bars
     **/
    function SetBarBorderColor($red, $green, $blue) {
      $this->bar_bordercolor = array($red, $green, $blue);
    }

    /**
     * BarGraph::SetBarBackgroundColor()
     * Sets background color for bars
     **/
    function SetBarBackgroundColor($array_colors) {
      $this->bar_bgcolor = $array_colors;
    }

    /**
     * BarGraph::SetBarData()
     * Sets data of graph (parameter should be an array with key
     * being the name of the bar and the value the value of the bar.
     **/
    function SetBarData($data) {
      if (is_array($data)) $this->bar_data = $data;
    }

    /**
     * BarGraph::SetBarDimensions()
     * Sets with and height of each bar
     **/
    function SetBarDimensions($width, $height) {
      if ($width > 0) $this->bar_width = $width;
      if ($height > 0) $this->bar_height = $height;
    }
    function SetBarDimensions_time($timeline){
    if($this->bar_width*$timeline<500)
    $this->bar_width=(int)(500/$timeline);
    }
    
    /**
     * BarGraph::SetBarPadding()
     * Sets padding (border) around each bar
     **/
    function SetBarPadding($padding) {
      if ($padding > 0) $this->bar_padding = $padding;
    }
    function SetTimeLine($timeline) {
      if ($timeline > 0) $this->timeline = $timeline;
    }
    
    /****************************************************************
                                 AXIS
    ****************************************************************/
    
    /**
     * BarGraph::SetAxisBorderColor()
     * Sets border color for axis
     **/
    function SetAxisBorderColor($red, $green, $blue) {
      $this->axis_bordercolor = array($red, $green, $blue);
    }

    /**
     * BarGraph::SetAxisBackgroundColor()
     * Sets background color for axis
     **/
    function SetAxisBackgroundColor($red, $green, $blue) {
      $this->axis_bgcolor = array($red, $green, $blue);
    }

    /**
     * BarGraph::SetAxisStep()
     * Sets axis scale step
     **/
    function SetAxisStep($step) {
      if ($step > 0) $this->axis_step = $step;
    }

    /**
     * BarGraph::GetFinalGraphDimensions()
     * From the values already setted, it calculates image
     * width and height
     **/
    function GetFinalGraphDimensions() {
      $w = $this->graph_padding['left'] +
           (count($this->bar_data[0]) * ($this->bar_width + ($this->bar_padding * 2))) +
           $this->graph_padding['right'];
           if($w<500) $w=500;
      $h = $this->graph_padding['top'] +
           $this->graph_areaheight +
           $this->graph_padding['bottom'];
     # if($h<500)$h=500;
      return array($w, $h);
      
    }
    
    /**
     * BarGraph::LoadGraph()
     * Loads definitions from a file
     **/
    function LoadGraph($path) {
      if (($fp = @fopen($path, "r")) !== false) {
        $content = "";
        while (!feof($fp)) {              // I do not use filesize() here
          $content .= fread($fp, 4096);   // because of remote files. If
        }                                 // there is no problem with them
        fclose($fp);                      // please let me know
        $this->__LoadGraphDefinitions($content);
        return true;
      } else return false;
    }

    /**
     * BarGraph::DrawGraph()
     * Draw all the graph: bg, axis, bars, text.. and output it
     * Optional file parameter turns output to file, and bool on success
     **/
    function DrawGraph($file = "") {
      list($w, $h) = $this->GetFinalGraphDimensions();
      $this->graph_width = $w;
      $this->graph_height = $h;

      $this->im = imagecreatetruecolor($w, $h);
      if ($this->graph_transparencylevel) {
        imagealphablending($this->im, true);
      }

      $this->__PaintBackground();
      $this->__DrawAxis();


      for($datos=0;$datos<count($this->bar_data);$datos++){
      $p = 0;
      foreach ($this->bar_data[$datos] as  $value) {
        $p++;
        $this->__DrawBar($p, $value,$datos);
        }
        }
      if (strlen($this->graph_title)) {
        $this->__AllocateColor("im_graph_titlecolor",
                               $this->graph_titlecolor,
                               $this->graph_transparencylevel);
        $this->__DrawText($this->graph_title,
                          floor($this->graph_width / 2),
                          $this->graph_borderwidth + 2,
                          $this->im_graph_titlecolor,
                          2,
                          1);
      }
      if($this->timeline){
      $p = 1;
foreach($this->timeline as $name){
        $this->__DrawBarText($p, $name);
        $p++;
}//foreach

}//if
      if($this->leyendas){
      $color=0;
      $p=0;
        foreach($this->leyendas as $leyend){

        $p+=15;
              $this->__AllocateColor("im_leyenda_".$color,
                               $this->bar_bgcolor[$color],
                               $this->graph_transparencylevel);

        $this->__DrawText($leyend,
                          $this->graph_borderwidth + 25,
                          $this->graph_areaheight + 30+$p,
                          $this->im_graph_titlecolor,
                          2,
                          0);
        $cubo_x=$this->graph_borderwidth + 7;
        $cubo_y=$this->graph_areaheight + 34+$p;
        $this->__DrawPolygon($cubo_x, $cubo_y, $cubo_x+12, $cubo_y ,   $cubo_x+12, $cubo_y+5, $cubo_x , $cubo_y+5,$this->{"im_leyenda_".$color}, true);
                                  $color++;

        }//foreach

      }
      
      if (strlen($file)) {
        $ret = imagepng($this->im, $file);
      } else {
        imagepng($this->im);
        $ret = true;
      }
      imagedestroy($this->im);
      return $ret;
    }
    

    
    /**
     * BarGraph::PaintBackground()
     * Draw all the graph: bg, axis, bars, text.. and output it
     * Optional file parameter turns output to file, and bool on success
     **/
    function __PaintBackground() {
      $this->__AllocateColor("im_graph_bgcolor",
                             $this->graph_bgcolor,
                             0);
      imagefilledrectangle($this->im,
                           0,
                           0,
                           $this->graph_width,
                           $this->graph_height,
                           $this->im_graph_bgcolor);
      if ($this->graph_bgtransparent) {
        imagecolortransparent($this->im, $this->im_graph_bgcolor);
      }
      if ($this->graph_borderwidth) {
        $this->__AllocateColor("im_graph_bordercolor",
                               $this->graph_bordercolor,
                               $this->graph_transparencylevel);
        for ($i = 0; $i < $this->graph_borderwidth; $i++) {
          imagerectangle($this->im,
                         $i,
                         $i,
                         $this->graph_width - 1 - $i,
                         $this->graph_height - 1 - $i,
                         $this->im_graph_bordercolor);
        }
      }
    }
    
    /**
     * BarGraph::__DrawAxis()
     * Draws all the axis stuff (and scale steps)
     **/
    function __DrawAxis() {
      $this->__AllocateColor("im_axis_bordercolor",
                             $this->axis_bordercolor,
                             $this->graph_transparencylevel);
      $this->__AllocateColor("im_axis_bgcolor",
                             $this->axis_bgcolor,
                             $this->graph_transparencylevel);
      $this->__DrawPolygon($this->graph_padding['left'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->graph_padding['left'], $this->graph_padding['top'],
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_padding['top'] - $this->bar_height + 1,
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->im_axis_bgcolor, true);
      $this->__DrawPolygon($this->graph_padding['left'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->graph_padding['left'], $this->graph_padding['top'],
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_padding['top'] - $this->bar_height + 1,
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->im_axis_bordercolor);

      $this->__DrawPolygon($this->graph_padding['left'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->graph_width - $this->graph_padding['right'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->graph_width - $this->graph_padding['right'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->im_axis_bgcolor, true);
      $this->__DrawPolygon($this->graph_padding['left'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->graph_padding['left'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->graph_width - $this->graph_padding['right'] + $this->bar_height - 1, $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                           $this->graph_width - $this->graph_padding['right'], $this->graph_height - $this->graph_padding['bottom'],
                           $this->im_axis_bordercolor);

      // draw lines that separate bars
      $total_bars = count($this->bar_data[0]);
      for ($i = 1; $i < $total_bars; $i++) {
        $offset = $this->graph_padding['left'] +
                  (($this->bar_width + ($this->bar_padding * 2)) * $i);
        imageline($this->im,
                  $offset,
                  $this->graph_height - $this->graph_padding['bottom'],
                  $offset + $this->bar_height - 1,
                  $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height + 1,
                  $this->im_axis_bordercolor);
      }
      
      // draw scale steps
      $max_value = $this->__GetMaxGraphValue();
      if (($max_value % 10) > 0) {
        $max_value = $max_value + (10 - ($max_value % 10));
      }
      $this->axis_max = $max_value;
      $y = 0;
      $style = array($this->im_axis_bordercolor, $this->im_graph_bgcolor);
      imagesetstyle($this->im, $style);
      while ($y <= $max_value) {
        $offset = floor($this->graph_height - $this->graph_padding['bottom'] -
                  ($y * $this->graph_areaheight / $max_value));
        imageline($this->im,
                  $this->graph_padding['left'],
                  $offset,
                  $this->graph_padding['left'] + $this->bar_height - 1,
                  $offset - $this->bar_height + 1,
                  $this->im_axis_bordercolor);
        $this->__DrawText($y,
                          $this->graph_padding['left'],
                          $offset,
                          $this->im_axis_bordercolor,
                          1,
                          2,
                          1);
        // gridline
        if ($y > 0) {
          imageline($this->im,
                    $this->graph_padding['left'] + $this->bar_height,
                    $offset - $this->bar_height + 1,
                    $this->graph_width - $this->graph_padding['right'] + $this->bar_height - 1,
                    $offset - $this->bar_height + 1,
                    IMG_COLOR_STYLED);
        }
        $y += $this->axis_step;
      }

      imageline($this->im,
                $this->graph_width - $this->graph_padding['right'] + $this->bar_height - 1,
                $this->graph_padding['top'] - $this->bar_height + 1,
                $this->graph_width - $this->graph_padding['right'] + $this->bar_height - 1,
                $this->graph_height - $this->graph_padding['bottom'] - $this->bar_height,
                IMG_COLOR_STYLED);
    }
    
    /**
     * BarGraph::__DrawText()
     * Draws text on image with color, size and alignment options
     **/
    function __DrawText($text, $x, $y, $color, $size = 1, $align = 0, $valign = 0) {
      /*
       * Align: 0=left | 1=center | 2=right
       */
      if ($align == 1) $x -= floor(strlen($text) * imagefontwidth($size) / 2);
      elseif ($align == 2) $x -= (strlen($text) * imagefontwidth($size));
      if ($valign == 1) $y -= floor(imagefontheight($size) / 2);
      elseif ($valign == 2) $y -= imagefontheight($size);
      imagestring($this->im,
                  $size,
                  $x,
                  $y,
                  $text,
                  $color);
    }

    /**
     * BarGraph::__GetMaxGraphValue()
     * Returns max bar value
     **/
    function __GetMaxGraphValue() {
    
      $max_value = 0;
            for($datos=0;$datos<count($this->bar_data);$datos++){

      foreach ($this->bar_data[$datos] as $name => $value) {
        if ($value > $max_value) $max_value = $value;
      }
      }
      $this->SetAxisStep((int)($max_value/5));
      return $max_value;
    }
    
    /**
     * BarGraph::__DrawBarText()
     * Determines top and left to draw text to a choosen bar
     **/
    function __DrawBarText($bar, $text) {
      $this->__DrawText($text,
                        $this->graph_padding['left'] + (($this->bar_width + ($this->bar_padding * 2)) * ($bar - 0.5)),
                        $this->graph_height - $this->graph_padding['bottom'] + 1,
                        $this->axis_bordercolor,
                        1,
                        1);
    }
    
    /**
     * BarGraph::__DrawBar()
     * Draws a choosen bar with it's value
     **/
    function __DrawBar($bar, $value, $datos) {
      $x = $this->graph_padding['left'] +
           (($this->bar_width + ($this->bar_padding * 2)) * ($bar - 1)) +
           $this->bar_padding+($datos*$this->bar_width/$this->identidades);
      $y = $value * $this->graph_areaheight / $this->axis_max;
      $this->____DrawBar($x,
                         $this->graph_height - $this->graph_padding['bottom'] - $y,
                         $x +($this->bar_width/$this->identidades) ,
                         $this->graph_height - $this->graph_padding['bottom'], $datos);
    }
    
    /**
     * BarGraph::____DrawBar()
     * Draws the actual rectangles that form a bar
     **/
    function ____DrawBar($x1, $y1, $x2, $y2, $color) {
#    $x1=$x11; 
  # $x2= $x22;
      $this->__AllocateColor("im_bar_bordercolor",
                             $this->bar_bordercolor,
                             $this->graph_transparencylevel);
      $this->__AllocateColor("im_bar_bgcolor",
                             $this->bar_bgcolor[$color],
                             $this->graph_transparencylevel);
      $this->__DrawPolygon($x1,                         $y1,
                           $x2,                         $y1,
                           $x2,                         $y2,
                           $x1,                         $y2,
                           $this->im_bar_bgcolor,       true);
      $this->__DrawPolygon($x1,                         $y1,
                           $x2,                         $y1,
                           $x2,                         $y2,
                           $x1,                         $y2,
                           $this->im_bar_bordercolor);
      $this->__DrawPolygon($x1,                         $y1,
                           $x2,                         $y1,
                           $x2 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $x1 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $this->im_bar_bgcolor,       true);
      $this->__DrawPolygon($x1,                         $y1,
                           $x2,                         $y1,
                           $x2 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $x1 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $this->im_bar_bordercolor);
      $this->__DrawPolygon($x2,                         $y2,
                           $x2,                         $y1,
                           $x2 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $x2 + $this->bar_height - 1, $y2 - $this->bar_height + 1,
                           $this->im_bar_bgcolor,       true);
      $this->__DrawPolygon($x2,                         $y2,
                           $x2,                         $y1,
                           $x2 + $this->bar_height - 1, $y1 - $this->bar_height + 1,
                           $x2 + $this->bar_height - 1, $y2 - $this->bar_height + 1,
                           $this->im_bar_bordercolor);

    }
    
    /**
     * BarGraph::__DrawPolygon()
     * Draws a (filled) (ir)regular polygon
     **/
    function __DrawPolygon($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4, $color, $filled = false) {
      if ($filled) {
        imagefilledpolygon($this->im, array($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4), 4, $color);
      } else {
        imagepolygon($this->im, array($x1, $y1, $x2, $y2, $x3, $y3, $x4, $y4), 4, $color);
      }
    }
    
    /**
     * BarGraph::__LoadGraphDefinitions()
     * Loads definitions to a graph from text lines (normaly
     * they come from a file). This function is called by
     * BarGraph::LoadGraph()
     **/
    function __LoadGraphDefinitions($text) {
      $text = preg_split("/\r?\n/", $text);
      $data = array();
      $section = '';
      for ($i = 0; $i < count($text); $i++) {
        if (preg_match("/^\s*#/", $text[$i])) {
          //ignore.. it's just a comment
        } elseif (preg_match("/^\s*\}\s*/", $text[$i])) {
          $section = '';
        } elseif (preg_match("/^\s*(\w+)\s*\{\s*$/", $text[$i], $r)) {
          $section = $r[1];
        } else {
          $p = strpos($text[$i], "=");
          if ($p !== false) {
            $data[$section][trim(substr($text[$i], 0, $p))] = trim(substr($text[$i], $p + 1));
          }
        }
      }
      if (is_array($data['graph'])) {
        $this->__LoadGraphValues($data['graph']);
      }
      if (is_array($data['bar'])) {
        $this->__LoadBarValues($data['bar']);
      }
      if (is_array($data['axis'])) {
        $this->__LoadAxisValues($data['axis']);
      }
      if (is_array($data['data'])) {
        $this->bar_data[0] = $data['data'];
      }
    }

    /**
     * BarGraph::__LoadGraphValues()
     * Loads definitions to main graph settings
     **/
    function __LoadGraphValues($data) {
      foreach ($data as $name => $value) {
        $name = strtolower($name);
        switch ($name) {
          case 'background-color':
            $this->__SetColorToValue("graph_bgcolor", $value);
            break;
          case 'border-color':
            $this->__SetColorToValue("graph_bordercolor", $value);
            break;
          case 'title-color':
            $this->__SetColorToValue("graph_titlecolor", $value);
            break;
          case 'background-transparent':
            $this->graph_bgtransparent = ($value == 1 || $value == 'yes' ? 1 : 0);
            break;
          case 'transparency':
            $this->SetGraphTransparency(str_replace('%', '', $value));
            break;
          case 'title':
            $this->graph_title = $value;
            break;
          case 'border-width':
            $this->graph_borderwidth = (int) $value;
            break;
          case 'area-height':
            $this->graph_areaheight = (int) $value;
            break;
          default:
            if (substr($name, 0, 8) == 'padding-' && strlen($name) > 8) {
              $this->graph_padding[substr($name, 8)] = $value;
            }
        }
      }
    }

    /**
     * BarGraph::__LoadBarValues()
     * Loads definitions to bar settings
     **/
    function __LoadBarValues($data) {
      foreach ($data as $name => $value) {
        $name = strtolower($name);
        switch ($name) {
          case 'background-color':
            $this->__SetColorToValue("bar_bgcolor", $value);
            break;
          case 'border-color':
            $this->__SetColorToValue("bar_bordercolor", $value);
            break;
          case 'padding':
            $this->bar_padding = $value;
            break;
          case 'width':
            $this->bar_width = (int) $value;
            break;
          case 'height':
            $this->bar_height = (int) $value;
            break;
        }
      }
    }
    
    /**
     * BarGraph::__LoadAxisValues()
     * Loads definitions to axis settings
     **/
    function __LoadAxisValues($data) {
      foreach ($data as $name => $value) {
        switch (strtolower($name)) {
          case 'step':
            $this->SetAxisStep($value);
            break;
          case 'background-color':
            $this->__SetColorToValue("axis_bgcolor", $value);
            break;
          case 'border-color':
            $this->__SetColorToValue("axis_bordercolor", $value);
        }
      }
    }
    
    /**
     * BarGraph::__SetColorToValue()
     * Sets a color (rgb or in html format) to a variable
     **/
    function __SetColorToValue($varname, $color) {
      if ($color[0] == "#") { // if it's hex (html format), change to rgb array
        if (strlen($color) == 4) {
          // if only 3 hex values (I assume it's a shade of grey: #ddd)
          $color .= substr($color, -3);
        }
        $color = array(hexdec($color[1].$color[2]),
                       hexdec($color[3].$color[4]),
                       hexdec($color[5].$color[6]));
      }
      $this->$varname = $color;
    }
    
    function __AllocateColor($varname, $color, $alpha) {
      $this->$varname = imagecolorallocate($this->im,
                                                $color[0],
                                                $color[1],
                                                $color[2]);
     /*
      $this->$varname = imagecolorallocatealpha($this->im,
                                                $color[0],
                                                $color[1],
                                                $color[2],
                                                $alpha);
                                                */
    }
  }
?>
