<?php
function br2nl($string)
{
return PREG_REPLACE('#<br />#i', " ", $string); 
}
function pagination($strana,$broj_strana,$id)
{
  echo "<div id='paginacija' style='padding-left:395px;'><ul >";
  if($strana!=1)
  {
	$str = $strana - 1;
	echo "<li ><a href='galerija.php?p=$str&ddlGalerija=$id'>Prethodna</a></li>";
  }
  for($i=1;$i<=$broj_strana;$i++)
  {
    if($i==$strana)
	{
	 echo "<li ><a href='galerija.php?p=$strana&ddlGalerija=$id'>$strana</a></li>";
	}
	else
	{
	 echo "<li ><a href='galerija.php?p=$i&ddlGalerija=$id''>$i</a></li>";
	}
  }
  if($strana!=$broj_strana)
  {
	$str = $strana + 1;
	echo "<li ><a href='galerija.php?p=$str&ddlGalerija=$id'>Sledeca</a></li>";
  }
  echo "</ul></div>";
} 
function pagination_songs($strana,$broj_strana,$stil)
{
  echo "<div id='paginacija' style='padding-left:395px;'><ul >";
  if($strana!=1)
  {
	$str = $strana - 1;
	echo "<li ><a href='$stil.php?p=$str'>Prethodna</a></li>";
  }
  for($i=1;$i<=$broj_strana;$i++)
  {
    if($i==$strana)
	{
	 echo "<li ><a href='$stil.php?p=$strana'>$strana</a></li>";
	}
	else
	{
	 echo "<li ><a href='$stil.php?p=$i'>$i</a></li>";
	}
  }
  if($strana!=$broj_strana)
  {
	$str = $strana + 1;
	echo "<li ><a href='$stil.php?p=$str'>Sledeca</a></li>";
  }
  echo "</ul></div>";
} 
function pagination_songs1($strana,$broj_strana,$stil,$text1)
{
  echo "<div id='paginacija' style='padding-left:395px;'><ul >";
  if($strana!=1)
  {
	$str = $strana - 1;
	echo "<li ><a href='$stil.php?p=$str&text1=$text1&btnSubmit=+'>Prethodna</a></li>";
  }
  for($i=1;$i<=$broj_strana;$i++)
  {
    if($i==$strana)
	{
	 echo "<li ><a href='$stil.php?p=$strana&text1=$text1&btnSubmit=+'>$strana</a></li>";
	}
	else
	{
	 echo "<li ><a href='$stil.php?p=$i&text1=$text1&btnSubmit=+'>$i</a></li>";
	}
  }
  if($strana!=$broj_strana)
  {
	$str = $strana + 1;
	echo "<li ><a href='$stil.php?p=$str&text1=$text1&btnSubmit=+'>Sledeca</a></li>";
  }
  echo "</ul></div>";
} 
?>