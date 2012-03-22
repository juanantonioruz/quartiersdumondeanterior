<?php
include "chart.class.php";
//***********************************************************************
//***************Written by Rahman Haqparast February 2003***************
//*******************the class for creating pie charts*******************
//***********************************************************************
class piechart extends chart
{
	var $radius;
	var $final;
            var  $suma_total;
	function piechart($r,$na,$el,$co, $suma, $title)
	{
		$this->radius=$r;
		$this->elementnames=$na;
		$this->elements=$el;
		$this->colors=$co;
                            $this->suma_total=$suma;
                            $this->title=$title;
		$this->createimage();
	}
	function createimage()
	{
		$this->calculate();
		$r=$this->radius;
		$image=imagecreate($r*4,$r*4);
		$white=imagecolorallocate($image,255,255,255);
		$black=imagecolorallocate($image,60,60,60);
		for ($k=0;$k<count($this->elements);$k++)
		{
			$fillcolor[$k]=imagecolorallocate($image,$this->colors[$k][0],$this->colors[$k][1],$this->colors[$k][2]);
		}
		imagearc($image,$r,$r,$r*2-1,$r*2-1,0,360,$black);
		for ($j=0;$j<count($this->elements);$j++)
		{
			$degree+=359*$this->fractions[$j];
			imageline($image,$r,$r,$r+$r*cos($degree*pi()/180),$r+$r*sin($degree*pi()/180),$black);
			imagefill($image,$r+19*cos(($degree+5)*pi()/180),$r+19*sin(($degree+5)*pi()/180),$fillcolor[$j]);
			imagefilledrectangle($image,
                        2.1*$r,
                        .72*$r+($r/15)*$j,
                        2.12*$r+($r/25),
                        .72*$r+5+($r/15)*$j,
                        $fillcolor[$j]);
                        $porcentaje=(int)($this->elements[$j]*(100/$this->suma_total));
                        if(!$porcentaje) $porcentaje=1;
                        if($porcentaje<10) $porcentaje="0".$porcentaje;
                        imagestring($image,
                        2,
                        2.13*$r+$r/20,
                        .71*$r+($r/15)*$j-2,
                        $porcentaje."% ".$this->elementnames[$j],$black);
		}	
                        $titulo=explode(". ", $this->title);
                        foreach($titulo as $t){
                        $inc+=1.5;
                        imagestring($image,
                        3,
                        2.05*$r+$r/20,
                        .61*$r+($r/15)*(-5+$inc),
                        $t
                        ,$black);
                        }

			$this->final=$image;
	}
	function draw()
	{
			imagejpeg($this->final,'',100);
	}
	function out($filename,$quality)
	{
			imagejpeg($this->final,$filename,$quality);
	}
}
?>
