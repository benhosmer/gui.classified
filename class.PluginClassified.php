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

        //$content = $this->pluginConf["SITE_CLASSIFICATION_LEVEL"];
        
        

        $content = $siteClassificationLevel;

        //$content = str_replace("\\n", "<br>", $content);
        
        //$cdata = '<div id="optional_bottom_div" style="font-family:arial;padding:10px;">'.$content.'</div>';
        
        $cdata = '<div id="optional_bottom_div">
        <link type="text/css" rel="stylesheet" href="plugins/gui.classified/css/style.css" media="screen">'.$content.'</div>';
        


        $cdataSection = $contribNode->ownerDocument->createCDATASection($cdata);
        
        foreach($footerTplNode->childNodes as $child) $footerTplNode->removeChild($child);
        $footerTplNode->appendChild($cdataSection);  

        
        $hdata = '<div id="optional_header_div">
        <link type="text/css" rel="stylesheet" href="plugins/gui.classified/css/style.css" media="screen">'.$content.'</div>';
        

        $hcdataSection = $contribNode->ownerDocument->createCDATASection($hdata);
        
        foreach($headerTplNode->childNodes as $child) $headerTplNode->removeChild($child);
        $headerTplNode->appendChild($hcdataSection);          

        




    }
}

?>