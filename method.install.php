<?php
/* @var $this SmartySnippets */
if (!is_object(cmsms())) exit;
if (!$this->CheckPermission("Modify Templates")) {
    $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$this->CreateDefaultTemplates();

// put mention into the admin log
$this->Audit(0, $this->Lang('friendlyname'), $this->Lang('installed', $this->GetVersion()));
