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
 * @name BreadCrumbs
 * @version 0.9f
 * @created 2012-04-02
 * @since 2009-05-11
 * @author Jerome Perrin <hello@jeromeperrin.com>
 * @package breadcrumbs
 *
 * This snippet was designed to show the path through the various levels of site
 * structure back to the root. It is NOT necessarily the path the user took to
 * arrive at a given page.
 *
 */

return array(

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
     * The class of the outer container
     *
     * @var string $outerClass
     */
    'outerClass' => 'breadcrumb',
    /**
     * The class of the current crumb
     *
     * @var string $currentCrumbClass
     */
    'currentCrumbClass' => 'active',
    /**
     * The string that will show if the maximum number of breadcrumbs
     * has been shown.
     *
     * @var string $max_delimiter
     */
    'maxDelimiter' => '...',
    'bcTplCrumbCurrent' => '<li class="[[+class]]" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
    'bcTplCrumbCurrentLink' => '<a itemprop="url" href="[[~[[+resource]]]]"><span itemprop="title">[[+text]]</span></a>',
    'bcTplCrumbHome' => '<a itemprop="url" href="[[~[[++site_start]]]]"><span itemprop="title">[[+text]]</span></a>',
    'bcTplCrumbMax' => '<li class="maxDelimiter" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
    'bcTplCrumbLink' => '<a itemprop="url" href="[[~[[+resource]]]]"><span itemprop="title">[[+text]]</span></a>',
    'bcTplCrumbOuter' => '<ul class="[[+class]]">[[+text]]</ul>',
    'bcTplCrumb' => '<li itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">[[+text]]</li>',
    'bcTplCrumbSeparator' => '<span class="divider">[[+separator]]</span>'
);

?>