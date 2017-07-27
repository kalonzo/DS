<?php
namespace App\Utilities;

/**
 * Description of StyleTools
 *
 * @author Nico
 */
class StyleTools {
    
    public static function genRandomColorHexa(){
        $red = rand(0, 255);
        $blue = rand(0, 255);
        $green = rand(0, 255);
        $hexRed = dechex($red);
        $hexBlue = dechex($blue);
        $hexGreen = dechex($green);

        if(strlen($hexRed) < 2){
            $hexRed = '0'.$hexRed;
        }
        if(strlen($hexBlue) < 2){
            $hexBlue = '0'.$hexBlue;
        }
        if(strlen($hexGreen) < 2){
            $hexGreen = '0'.$hexGreen;
        }
        return '#'.$hexRed.$hexGreen.$hexBlue;
    }
    
    public static function genColorHexaForVisualGradient($lowGradientColor, $highGradientColor, $weightRatio){
        if(strlen($lowGradientColor) === 3){
            $lowGradientColor += $lowGradientColor;
        }
        if(strlen($highGradientColor) === 3){
            $highGradientColor += $highGradientColor;
        }
        $lowGradientRedHexa = substr($lowGradientColor, 0, 2);
        $lowGradientRed = hexdec($lowGradientRedHexa);
        $lowGradientGreenHexa = substr($lowGradientColor, 2, 2);
        $lowGradientGreen = hexdec($lowGradientGreenHexa);
        $lowGradientBlueHexa = substr($lowGradientColor, 4, 2);
        $lowGradientBlue = hexdec($lowGradientBlueHexa);
        
        $highGradientRedHexa = substr($highGradientColor, 0, 2);
        $highGradientRed = hexdec($highGradientRedHexa);
        $highGradientGreenHexa = substr($highGradientColor, 2, 2);
        $highGradientGreen = hexdec($highGradientGreenHexa);
        $highGradientBlueHexa = substr($highGradientColor, 4, 2);
        $highGradientBlue = hexdec($highGradientBlueHexa);
        
        $redDiff = abs($highGradientRed - $lowGradientRed);
        $greenDiff = abs($highGradientGreen - $lowGradientGreen);
        $blueDiff = abs($highGradientBlue - $lowGradientBlue);
        
        $resultColorRed = ($lowGradientRed + ($redDiff * $weightRatio)) % 255;
        $resultColorGreen = ($lowGradientGreen + ($greenDiff * $weightRatio)) % 255;
        $resultColorBlue = ($lowGradientBlue + ($blueDiff * $weightRatio)) % 255;
        
        $resultColorRedHexa = dechex($resultColorRed);
        $resultColorGreenHexa = dechex($resultColorGreen);
        $resultColorBlueHexa = dechex($resultColorBlue);
        
        if(strlen($resultColorRedHexa) < 2){
            $resultColorRedHexa = '0'.$resultColorRedHexa;
        }
        if(strlen($resultColorGreenHexa) < 2){
            $resultColorGreenHexa = '0'.$resultColorGreenHexa;
        }
        if(strlen($resultColorBlueHexa) < 2){
            $resultColorBlueHexa = '0'.$resultColorBlueHexa;
        }
        return '#'.$resultColorRedHexa.$resultColorGreenHexa.$resultColorBlueHexa;
    }
}
