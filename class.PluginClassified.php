<?php

defined('AJXP_EXEC') or die( 'Access not allowed');

/**
 * @package info.ajaxplorer.plugins
 * A plugin to replace the header and footer with the site classification level.
 */
class PluginClassified extends AJXP_Plugin {

    /**
     * @param DOMNode $contribNode
     * @return void
     */
    public function parseSpecificContributions(&$contribNode){
        
        if($contribNode->nodeName != "client_configs") return;
        
        $actionXpath=new DOMXPath($contribNode->ownerDocument);
        
        $footerTplNodeList = $actionXpath->query('template[@name="bottom"]', $contribNode);
        $footerTplNode = $footerTplNodeList->item(0);
        
        $headerTplNodeList = $actionXpath->query('template[@name="head"]', $contribNode);
        $headerTplNode = $headerTplNodeList->item(0);

        $siteClassificationLevel = $this->pluginConf["SITE_CLASSIFICATION_LEVEL"];

        switch ($siteClassificationLevel) {
             case 1:
                 $content = "Unclassified";
                 break;
             case 2:
                $content = "Classified";
                 break;
             case 3:
                $content = "Top Secret";
                 break;
        }





        $cdata = '<div id="optional_bottom_div">
        <link type="text/css" rel="stylesheet" href="plugins/gui.classified/css/style-'.$siteClassificationLevel.'.css" 
        media="screen">'.$content.'</div>';


        $cdataSection = $contribNode->ownerDocument->createCDATASection($cdata);
        
        foreach($footerTplNode->childNodes as $child) $footerTplNode->removeChild($child);
        $footerTplNode->appendChild($cdataSection);  

        
        $hdata = '<div id="optional_header_div">'.$content.'</div>';
        // <link type="text/css" rel="stylesheet" href="plugins/gui.classified/css/style.css" media="screen">'.$content.'</div>';
        

        $hcdataSection = $contribNode->ownerDocument->createCDATASection($hdata);
        
        foreach($headerTplNode->childNodes as $child) $headerTplNode->removeChild($child);
        $headerTplNode->appendChild($hcdataSection);

    }
}

?>