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
 * Properties English Topic for breadcrumbs.
 *
 * @author Jerome Perrin <hello@jeromeperrin.com>
 * @package BreadCrumbs
 * @subpackage lexicon
 * @language en
 */
$_lang['breadcrumbs.prop_desc.maxCrumbs'] = 'Max number of elements to have in a path. If you make it smaller, like say 2, but you are 5 levels deep, it will appear as: Home > ... > Level 4 > Level 5. "Home" and the current page do not count. Each of these are configured separately.';
$_lang['breadcrumbs.prop_desc.pathThruUnPub'] = 'When your path includes an unpublished folder, setting this to 1 will show all documents in path EXCEPT the unpublished. Refer to the documentation for more details: http://rtfm.modx.com/display/ADDON/Breadcrumbs';
$_lang['breadcrumbs.prop_desc.respectHidemenu'] = 'Setting this to 1 will hide items in the breadcrumb list that are set to be hidden in menus.';
$_lang['breadcrumbs.prop_desc.showHomeCrumb'] = 'Would you like your crumb string to start with a link to home? Some would not because a home link is usually found in the site logo or elsewhere in the navigation scheme.';
$_lang['breadcrumbs.prop_desc.showCrumbsAtHome'] = 'You can use this to turn off the breadcrumbs on the home page with 1. grad: actually \'1\' shows and \'0\' hides crumbs at homepage';
$_lang['breadcrumbs.prop_desc.showCurrentCrumb'] = 'Show the current page in path with 1 or not with 0';
$_lang['breadcrumbs.prop_desc.currentAsLink'] = 'If you want the current page crumb to be a link (to itself) then set to 1.';
$_lang['breadcrumbs.prop_desc.crumbSeparator'] = 'Define what you want between the crumbs.';
$_lang['breadcrumbs.prop_desc.homeCrumbTitle'] = 'Just in case you want to have a home link, but want to call it something else.';
$_lang['breadcrumbs.prop_desc.homeCrumbDescription'] = 'In case you want to have a custom description of the home link. Defaults to title of home link.';
$_lang['breadcrumbs.prop_desc.titleField'] = 'To change default page field to be used as a breadcrumb title, default is pagetitle.';
$_lang['breadcrumbs.prop_desc.descField'] = 'To change default page field to be used as a breadcrumb description, default is description (GA: falls back to pagetitle if description is empty).';
$_lang['breadcrumbs.prop_desc.maxDelimiter'] = 'The string that will show if the maximum number of breadcrumbs has been shown.';
$_lang['breadcrumbs.prop_desc.bcTplCrumbCurrent'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbCurrentLink'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbHome'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbMax'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbLink'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbOuter'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumb'] = '';
$_lang['breadcrumbs.prop_desc.bcTplCrumbSeparator'] = '';
