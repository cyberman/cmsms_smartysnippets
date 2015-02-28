<?php
/* @var $this SmartySnippets */
if (!is_object(cmsms())) exit;
if (!$this->CheckPermission("Modify Templates")) {
    $this->DisplayErrorPage($id, $params, $returnid, $this->Lang('accessdenied'));
}

$current_version = $oldversion;
switch($current_version)
{
    case "1.0":
         break;
    case "1.1":
         break;
}

$this->CreateDefaultTemplates();

// put mention into the admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));

