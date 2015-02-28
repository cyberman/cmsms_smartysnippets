<?php
#-------------------------------------------------------------------------
# Module: SmartySnippets - SmartySnippets Administration
# Version: 0.1, Mike Crowe
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2014 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
# This file originally created by ModuleMaker module, version 0.3.2
# Copyright (c) 2014 by Samuel Goldstein (sjg@cmsmadesimple.org)
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------


class SmartySnippets extends CGExtensions
{

	function GetName()              { return 'SmartySnippets';                   }
	function GetFriendlyName()      { return $this->Lang('friendlyname');        }
    function GetVersion()           { return '0.2';                              }
	function GetHelp()              { return $this->Lang('help');                }
	function GetAuthor()            { return 'Mike Crowe';                       }
	function GetAuthorEmail()       { return 'drmikecrowe@gmail.com';            }
    function GetAdminSection()      { return 'layout';                           }
	function GetChangeLog()         { return $this->Lang('changelog');           }
	function IsPluginModule()       { return true;                               }
    function HasAdmin()             { return true;                               }
	function MinimumCMSVersion()    { return "1.11.10";                          }
	function MaximumCMSVersion()    { return "1.99.99";                          }
	function InstallPostMessage()   { return $this->Lang('postinstall');         }
	function UninstallPostMessage() { return $this->Lang('postuninstall');       }
	function UninstallPreMessage()  { return $this->Lang('really_uninstall');    }

    public function GetDependencies()      {
        return array("CGExtensions" => "1.42");
    }

    public function CheckAccess($perm = 'SmartySnippets_Permission')
    {
        return $this->CheckPermission($perm);
    }

    public function DisplayErrorPage($id, &$params, $return_id, $message = '')
    {
        $this->smarty->assign('title_error', $this->Lang('error'));
        $this->smarty->assign_by_ref('message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }

    public function __construct() {
        parent::CMSModule();
        global $config;
        $this->smarty = cms_utils::get_smarty();
        $this->smarty->addPluginsDir(__DIR__ . '/plugins');
    }

    public function CreateStubFiles() {
        $templates = $this->ListTemplates();
        $existing = array_merge(get_matching_files(__DIR__ . "/plugins", "php", true, true, "block.ss_", 0), get_matching_files(__DIR__ . "/plugins", "php", true, true, "function.ss_", 0));
        $new = array();

        foreach ($templates as $template) {

            list($tpl_type, $tpl_name) = explode('_', $template, 2);
            switch ( $tpl_type ) {
                case 'block':
                    $new[] = "block.ss_$tpl_name.php";
                    $fname = __DIR__."/plugins/block.ss_$tpl_name.php";
                    if ( !file_exists($fname)) file_put_contents($fname, <<<EOS
<?php
function smarty_block_ss_$tpl_name(\$params,\$content,&\$smarty,\$repeat) { return SmartySnippets::do_block("$template",\$params,\$content,\$smarty,\$repeat); }
EOS
                    );
                    break;
                case 'function':
                    $new[] = "function.ss_$tpl_name.php";
                    $fname = __DIR__."/plugins/function.ss_$tpl_name.php";
                    if ( !file_exists($fname)) file_put_contents($fname, <<<EOS
<?php
function smarty_function_ss_$tpl_name(\$params,\$content,&\$smarty,\$repeat) { echo SmartySnippets::do_function("$template",\$params,\$content,\$smarty,\$repeat); }
EOS
                    );
                    break;
            }
        }
        $todel = array_diff($existing, $new);
        foreach ( $todel as $file ) {
            @unlink(__DIR__."/plugins/$file");
        }
    }

    public function CreateDefaultTemplates() {
        $files = get_matching_files(__DIR__ . "/defaults", "tpl", true, true, "block", 0);
        foreach ( $files as $file ) {
            $template = str_replace(".tpl", "", $file);
            $template = str_replace(".", "_", $template);
            $existing = $this->GetTemplate($template);
            if ( $existing == '' )
                $this->SetTemplate($template, @file_get_contents(cms_join_path(__DIR__,"defaults",$file)));
        }
        $files = get_matching_files(__DIR__ . "/defaults", "tpl", true, true, "function", 0);
        foreach ( $files as $file ) {
            $template = str_replace(".tpl", "", $file);
            $template = str_replace(".", "_", $template);
            $existing = $this->GetTemplate($template);
            if ( $existing == '' )
                $this->SetTemplate($template, @file_get_contents(cms_join_path(__DIR__,"defaults",$file)));
        }
    }

    public static function do_function($template_name, $params, $content, &$smarty, $repeat) {
        return self::process($template_name, $params, $content, $smarty, $repeat);
    }

    public static function do_block($template_name, $params, $content, &$smarty, $repeat) {
        if( !$content ) return;

        if ( !$repeat ) {
            return self::process($template_name, $params, $content, $smarty, $repeat);
        }
    }

    public static function process($template_name, $params, $content, &$smarty, $repeat)
    {
        $res = $content;
        try {
            static $nest=0;

            $legalAttrs = [
                'id', 'name', 'autocomplete', 'autocorrect', 'autofocus', 'autosuggest', 'checked', 'dirname', 'disabled', 'tabindex', 'list', 'max',
                'maxlength', 'min', 'multiple', 'novalidate', 'pattern', 'placeholder', 'readonly', 'required', 'size', 'step', 'data_target', 'data_toggle'
            ];
            $smarty = cms_utils::get_smarty();
            if ( !isset($params['id']) ) {
                $params['id'] = $smarty->get_template_vars('page_alias') . ($nest > 0 ? "$nest" : "");
            }
            // TODO: Make this config driven
            $content = sshelper::stripp($content);
            $toclear = [];
            $col_xs  = ( isset($params['extrasmall']) ) ? " col-xs-".$params['extrasmall'] : '';
            $col_sm  = ( isset($params['small']) )      ? " col-sm-".$params['small']      : '';
            $col_md  = ( isset($params['medium']) )     ? " col-md-".$params['medium']     : '';
            $col_lg  = ( isset($params['large']) )      ? " col-lg-".$params['large']      : '';
            $params['class']   = @$params['class']."$col_xs$col_sm$col_md$col_lg";
            $attributes = "";
            $attributes_without_id = "";
            foreach ( $legalAttrs as $attr ) {
                if ( isset($params[$attr]) ) {
                    $smarty->assign($attr, $params[$attr]);
                    $toclear[] = $attr;
                    $adder = " ".str_replace("_", "-", $attr) . "='{$params[$attr]}'";
                    $attributes .= $adder;
                    if ( $attr != "id" ) {
                        $attributes_without_id .= $adder;
                    }
                    unset($params[$attr]);
                }
            }
            foreach ( $params as $attr => $value ) {
                $attr = str_replace("_", "-", $attr);
                //$attr = str_replace("ss_","ss{$nest}_", $attr);
                $smarty->assign($attr, $params[$attr]);
                $toclear[] = $attr;
            }
            $smarty->assign("content", $content);
            $smarty->assign("attributes", $attributes);
            $smarty->assign("attributes_without_id", $attributes_without_id);
            $SS = cms_utils::get_module("SmartySnippets");
            $template = $SS->GetTemplate($template_name);
            $res = $smarty->fetch("string:$template");
            foreach ( $toclear as $attr ) {
                $smarty->clear_assign($attr);
            }
            $nest++;
        } catch ( Exception $ex ) {
            if ( strpos($ex->getMessage(),"Syntax error in template") !== false ) {
                throw $ex;
            }
        }
        return $res;
    }

}
