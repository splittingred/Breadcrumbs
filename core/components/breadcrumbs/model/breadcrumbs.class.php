<?php
/**
 * BreadCrumbs
 *
 * Copyright 2009-2011 by Shaun McCormick <shaun+bc@modx.com>
 *
 * BreadCrumbs is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * BreadCrumbs is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * BreadCrumbs; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package breadcrumbs
 */
/**
 * BreadCrumbs Class
 *
 * @package breadcrumbs
 */
class BreadCrumbs {
    /**
     * @var array $_crumbs An array of crumbs stored so far.
     * @access private
     */
    private $_crumbs;
    private $_tpls;

    /**
     * The BreadCrumbs constructor.
     *
     * @param modX $modx A reference to the modX constructor.
     * @param array $config A configuration array.
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('breadcrumbs.core_path',$config,$this->modx->getOption('core_path').'components/breadcrumbs/');
        $this->config = array_merge(array(
            'elements_path' => $basePath.'elements/',
        ),$config);
        $this->_crumbs = array();
        $this->_tpls = array();
    }

    /**
     * Show the current resource's breadcrumbs.
     *
     * @param int $resourceId The resource ID to load.
     * @return void
     */
    public function showCurrentPage($resourceId) {
        /* show current page, as link or not */
        $resource = $this->pullResource($resourceId);

        /* handle home page breadcrumb */
        if (!$this->config['showCrumbsAtHome'] && ($resource->get('id') == $this->modx->getOption('site_start'))) return false;

        if ($this->config['showCurrentCrumb']) {
            $titleToShow = $resource->get($this->config['titleField'])
                ? $resource->get($this->config['titleField'])
                : $resource->get('pagetitle');
            if ($this->config['currentAsLink'] && (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $resource->get('hidemenu') != 1 ))) {

                $descriptionToUse = ($resource->get($this->config['descField']))
                    ? $resource->get($this->config['descField'])
                    : $resource->get('pagetitle');

                $this->_crumbs[] = $this->getChunk('bcTplCrumbCurrentLink',array(
                    'resource' => $this->modx->resource->get('id'),
                    'description' => $descriptionToUse,
                    'text' => $titleToShow,
                ));
            } else {
                $this->_crumbs[] = $this->getChunk('bcTplCrumbCurrent',array(
                    'text' => $titleToShow,
                ));
            }
        }
    }

    /**
     * Get the mediary crumbs for an object.
     *
     * @param integer $resourceId The ID of the resource to pull from.
     * @param integer &$count
     * @return boolean
     */
    public function getMiddleCrumbs($resourceId,&$count) {
        /* insert '...' if maximum number of crumbs exceded */
        if ($count >= $this->config['maxCrumbs']) {
            $this->_crumbs[] = $this->getChunk('bcTplCrumbMax',array(
                'text' => $this->config['maxDelimiter'],
            ));
            return false;
        }

        $parent = $this->pullResource($resourceId);
        if ($parent == null) return false;
        if (($parent->get('parent') != $parent->get('id')) ) {
            if (($this->config['showHomeCrumb'] && $parent->get('id') != $this->modx->getOption('site_start')) || (!$this->config['showHomeCrumb'])) {
                if (!$this->config['respectHidemenu'] || ($this->config['respectHidemenu'] && $parent->get('hidemenu') != 1)) {
                    $titleToShow = $parent->get($this->config['titleField'])
                        ? $parent->get($this->config['titleField'])
                        : $parent->get('pagetitle');
                    $descriptionToUse = $parent->get($this->config['descField'])
                        ? $parent->get($this->config['descField'])
                        : $parent->get('pagetitle');
                    $this->_crumbs[] = $this->getChunk('bcTplCrumbLink',array(
                        'resource' => $parent->get('id'),
                        'description' => $descriptionToUse,
                        'text' => $titleToShow,
                    ));
                }
            }
        } /* end if */

        $count++;
        if ($parent->get('parent') != 0) {
            $this->getMiddleCrumbs($parent->get('parent'),$count);
        }
        return true;
    }

    /**
     * Get individual resource opject
     *
     * @access public
     * @param integer $resourceId The ID of the resource to pull.
     * @return modResource The resource object
     */
    public function pullResource($resourceId){
        $wa = array(
            'id' => $resourceId,
        );
        if (!$this->config['pathThruUnPub']) {
            $wa['published'] = true;
            $wa['deleted'] = false;
        }
        return $this->modx->getObject('modResource',$wa);
    }

    /**
     * Render the breadcrumbs.
     *
     * @access public
     * @return string The formatting string of crumbs to output
     */
    public function run() {
        /* get current resource parent info */

        $resource =& $this->modx->resource;
        $this->showCurrentPage($resource->get('id'));

        /* assemble intermediate crumbs */
        $crumbCount = 0;
        $this->getMiddleCrumbs($resource->get('parent'),$crumbCount);

        /* add home link if desired */
        if ($this->config['showHomeCrumb'] && ($resource->get('id') != $this->modx->config['site_start'])) {
            $this->_crumbs[] = $this->getChunk('bcTplCrumbHome',array(
                'description' => $this->config['homeCrumbDescription'],
                'text' => $this->config['homeCrumbTitle'],
            ));
        }

        $this->_crumbs = array_reverse($this->_crumbs);

        $o = '';
        $idx = 0;
        $crumbCount = count($this->_crumbs)-1;
        $oCrumbSeparator = '';
        if (!empty($this->config['crumbSeparator'])) {
            $oCrumbSeparator = $this->getChunk('bcTplCrumbSeparator',array('separator' => $this->config['crumbSeparator']));
        }
        foreach ($this->_crumbs as $crumb) {
            if ($idx == 0) {
                $o .= $this->getChunk('bcTplCrumbFirst',array(
                    'text' => $crumb,
                ))."\n";
            } else if ($idx == $crumbCount) {
                $o .= $this->getChunk('bcTplCrumbLast',array(
                    'text' => $oCrumbSeparator.$crumb,
                ))."\n";
            } else {
                $o .= $this->getChunk('bcTplCrumb',array(
                    'text' => $oCrumbSeparator.$crumb,
                ))."\n";
            }
            $idx++;
        }
        return $this->getChunk('bcTplCrumbOuter',array('text' => $o));
    }

    /**
     * Helper function for getting chunks that allows for faster grabbing and
     * dynamic insertion
     *
     * @access public
     * @param string $name
     * @param array $properties
     * @return string
     */
    public function getChunk($name,array $properties = array()) {
        $o = '';
        if (isset($this->_tpls[$name])) {
            return $this->modx->newObject('modChunk')->process($properties,$this->_tpls[$name]);
        } else {
            $chunk = $this->modx->getObject('modChunk',array('name' => $name));
            if (empty($chunk) || $chunk == null) {
                $chunk = $this->modx->newObject('modChunk');
                $chunk->setContent($this->config[$name]);
            }
            $this->_tpls[$name] = $chunk->getContent();
            $o = $chunk->process($properties,$chunk);
        }
        return $o;
    }
}