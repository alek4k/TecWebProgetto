<?php


class Template {

    private $_arrTemplateData = array();

    public function __construct() {
    }

    /*
    * Assign a variable by name to scope of template
    *
    * @param str variable name within template
    * @param mix variable value
    */
    public function assign($strName,$mixValue) {
        $this->_arrTemplateData[$strName] = $mixValue;
        return $this;
    }

    /*
    * Get variable assigned to the template
    *
    * @param str name
    * @return mix variable value
    */
    public function getTemplateVars($strName) {
        return isset($this->_arrTemplateData[$strName])?$this->_arrTemplateData[$strName]:null;
    }

    /*
    * Get contents of a Template
    *
    * @param str template file path
    * @return str template contents
    */
    public function fetch($strTemplateFile) {

        if(!file_exists($strTemplateFile)) {
            trigger_error("Template file $strTemplateFile doesn't exist.");
        }

        $strFileContents = file_get_contents($strTemplateFile);

        ob_start();
        $this->_compileTemplate($strFileContents);
        $strTemplateContents = ob_get_contents();

        ob_end_clean();

        return $strTemplateContents;

    }

    /*
    * Makes it possible for the template to return without
    * affecting anything.
    *
    * @param str file contents
    * @param obj module
    */
    private function _compileTemplate($strFileContents) {
        extract($this->_arrTemplateData);
        eval('?>'.$strFileContents);
    }

}