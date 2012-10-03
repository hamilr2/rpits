<?php

include("include.php");
include("imagick_include.php");

$id = $_GET["id"];

$result = dbquery("SELECT * from titles where id=\"$id\" LIMIT 1;");
$titleRow = mysql_fetch_array($result);

$template_id = $titleRow["template"];

$result = dbquery("SELECT * from templates where id=\"$template_id\" LIMIT 1;");
$templateRow = mysql_fetch_array($result);

$templateXML = fopen($templateRow["path"],"r");
$contents = stream_get_contents($templateXML);

$canvas = new Imagick();
$canvas->newImage(1920,1080,"none","png");

$xml = new SimpleXMLElement($contents);

if($xml->geo->blackBox)
{
  foreach($xml->geo->blackBox as $box)
  {

    $l = dbFetch($id,$box);
    blackBox($canvas,$l["x"],$l["y"],$l["w"],$l["h"]);
  }
}

if($xml->geo->slantRectangle)
{
  foreach($xml->geo->slantRectangle as $slantRectangle)
  {
    $sR = dbFetch($id,$slantRectangle);
    slantRectangle($canvas,$sR["x"],$sR["y"],$sR["w"],$sR["h"],$sR["color"]);
  }
}

if($xml->overlay->shadowText)
{
  foreach($xml->overlay->shadowText as $text)
  {
    $t = dbFetch($id,$text);
    shadowedText($canvas,$t["x"],$t["y"],$t["w"],$t["h"],$t["text"],$t["gravity"],$t["font"],$t["color"]);
  }
}

if($xml->overlay->plainText)
{
  foreach($xml->overlay->plainText as $text)
  {
    $t = dbFetch($id,$text);
    plainText($canvas,$t["x"],$t["y"],$t["w"],$t["h"],$t["text"],$t["gravity"],$t["font"],$t["color"]);
  }
}

if($xml->overlay->placeImage)
{
  foreach($xml->overlay->placeImage as $image)
  {

    $l = dbFetch($id,$image);
    //print_r($l);
    placeImage($canvas,$l["x"],$l["y"],$l["w"],$l["h"],$l["path"]);
  }
}

header("Content-Type: image/png");
echo $canvas;

$thumb = $canvas->clone();
$thumb->cropImage(1440,1080,0,0);
$thumb->resizeImage(53,40,Imagick::FILTER_TRIANGLE,1);
$thumb->writeImage('thumbs/' . $titleRow["filename"] . '.png');

$canvas->setImageDepth(8);
$canvas->writeImage('out/' . $titleRow["filename"] . '.png');

?>
