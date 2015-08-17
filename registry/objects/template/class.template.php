<?php
/**
 * Caldera Community Framework
 *
 * @version 1.0.0
 * @copyright 2015 Caldera Community Framework
 * @authors Matt Kent, Dan Jones
 */

namespace CCF\Registry\Objects;

use CCF\Registry\Objects\Template as Page;

if (!defined('IN_CCF')) exit;

class Template
{
    private $page;

    public function __construct()
    {
        require_once ROOT_PATH . '/registry/objects/class.template.php';
        $this->page = new Page();
    }

}