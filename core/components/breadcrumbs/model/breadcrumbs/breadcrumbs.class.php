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

        $this->config = array_merge(array(
            /**
             * Max number of elements to have in a path. 100 is an arbitrary
             * high number. If you make it smaller, like say 2, but you are 5
             * levels deep, it will appear as: Home > ... > Level 4 > Level 5 It
             * should be noted that "Home" and the current page do not count.
             * Each of these are configured separately.
             *
             * @var integer $maxCrumbs
             */
            'maxCrumbs' => 100,
            /**
             * When your path includes an unpublished folder, setting this to 1
             * will show all documents in path EXCEPT the unpublished. Example
             * path (unpublished in caps): home > news > CURRENT > SPORTS >
             * skiiing > article $pathThruUnPub = true would give you this: home
             * > news > skiiing > article $pathThruUnPub = false would give you
             * this: home > skiiing > article (assuming you have home crumb
             * turned on)
             *
             * @var boolean $pathThruUnPub
             */
            'pathThruUnPub' => true,
            /**
             * Setting this to 1 will hide items in the breadcrumb list that
             * are set to be hidden in menus.
             *
             * @var boolean $respectHidemenu
             */
            'respectHidemenu' => true,
            /**
             * Would you like your crumb string to start with a link to home?
             * Some would not because a home link is usually found in the site
             * logo or elsewhere in the navigation scheme.
             *
             * @var boolean $showHomeCrumb
             */
            'showHomeCrumb' => true,
            /**
             * You can use this to turn off the breadcrumbs on the home page
             * with 1. grad: actually '1' shows and '0' hides crumbs at
             * homepage.
             *
             * @var boolean $showCrumbsAtHome
             */
            'showCrumbsAtHome' => false,
            /**
             * Show the current page in path with 1 or not with 0.
             *
             * @var boolean $showCurrentCrumb
             */
            'showCurrentCrumb' => true,
            /**
             * If you want the current page crumb to be a link (to itself) then
             * set to 1.
             *
             * @var boolean $currentAsLink
             */
            'currentAsLink' => true,
            /**
             * Define what you want between the crumbs.
             *
             * @var string $crumbSeparator
             */
            'crumbSeparator' => '&raquo;',
            /**
             * Just in case you want to have a home link, but want to call it
             * something else.
             *
             * @var string $homeCrumbTitle
             */
            'homeCrumbTitle' => 'Home',
            /**
             * In case you want to have a custom description of the home link.
             * Defaults to title of home link.
             *
             * @var string $homeCrumbDescription
             */
            'homeCrumbDescription' => 'Home',
            /**
             * To change default page field to be used as a breadcrumb title,
             * default is pagetitle.
             *
             * @var string $titleField
             */
            'titleField' => 'pagetitle',
            /**
             * To change default page field to be used as a breadcrumb
             * description, default is description (GA: falls back to pagetitle
             * if description is empty).
             *
             * @var string $descField
             */
            'descField' => 'description',
            /**
             * The string that will show if the maximum number of breadcrumbs
             * has been shown.
             *
             * @var string $max_delimiter
             */
            'maxDelimiter' => '...',
            'bcTplCrumbCurrent' => '<li itemscope="itemscope" class="B_currentCrumb" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
            'bcTplCrumbCurrentLink' => '<a class="B_currentCrumb" itemprop="url" rel="[[+description]]" href="[[~[[+resource]]]]"><span itemprop="title">[[+text]]</span></a>',
            'bcTplCrumbFirst' => '<li class="B_firstCrumb" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
            'bcTplCrumbHome' => '<a class="B_homeCrumb" itemprop="url" rel="[[+description]]" href="[[~[[++site_start]]]]"><span itemprop="title">[[+text]]</span></a>',
            'bcTplCrumbLast' => '<li class="B_lastCrumb" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
            'bcTplCrumbMax' => '<li class="B_hideCrumb" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
            'bcTplCrumbLink' => '<a class="B_crumb" itemprop="url" rel="[[+description]]" href="[[~[[+resource]]]]"><span itemprop="title">[[+text]]</span></a>',
            'bcTplCrumbOuter' => '<ul class="B_crumbBox">[[+text]]</ul>',
            'bcTplCrumb' => '<li itemscope="itemscope" class="B_crumb" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
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
        foreach ($this->_crumbs as $crumb) {
            if ($idx == 0) {
                $o .= $this->getChunk('bcTplCrumbFirst',array(
                    'text' => $crumb,
                ))."\n";
            } else if ($idx == $crumbCount) {
                $o .= ' '.$this->config['crumbSeparator'].' ';
                $o .= $this->getChunk('bcTplCrumbLast',array(
                    'text' => $crumb,
                ))."\n";
            } else {
                $o .= ' '.$this->config['crumbSeparator'].' ';
                $o .= $this->getChunk('bcTplCrumb',array(
                    'text' => $crumb,
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