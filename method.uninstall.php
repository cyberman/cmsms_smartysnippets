<?php
/* @var $this SmartySnippets */
if (!is_object(cmsms())) exit;
if (!$this->CheckPermission("Modify Templates")) {
    $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

// remove the templates
$this->DeleteTemplate();

// put mention into the admin log
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

