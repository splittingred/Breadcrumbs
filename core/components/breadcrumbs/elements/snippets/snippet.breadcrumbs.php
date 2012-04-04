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
 * @created 2006-06-12
 * @since 2009-05-11
 * @author Jared <jaredc@honeydewdesign.com>
 * @editor Bill Wilson
 * @editor wendy@djamoer.net
 * @editor grad
 * @editor Shaun McCormick <shaun@collabpad.com>
 * @editor Shawn Wilkerson <shawn@shawnwilkerson.com>
 * @editor Wieger Sloot, Sterc.nl <wieger@sterc.nl>
 * @editor Jerome Perrin <hello@jeromeperrin.com>
 * @tester Bob Ray
 * @package breadcrumbs
 *
 * This snippet was designed to show the path through the various levels of site
 * structure back to the root. It is NOT necessarily the path the user took to
 * arrive at a given page.
 *
 * @see breadcrumbs.class.php for config settings
 *
 * Included classes
 * .breadcrumb ul tag that surrounds all crumb output
 * .active a tag surrounding the current crumb
 * .maxDelimiter li tag surrounding the "..." if there are more crumbs than will be shown
 */
$path = $modx->getOption('breadcrumbs.core_path',null,$modx->getOption('core_path').'components/breadcrumbs/');

$p = include $path.'elements/snippets/snippet.breadcrumbs.properties.php';
$p = array_merge($p,$scriptProperties);

$breadcrumbs = $modx->getService('breadcrumbs','BreadCrumbs',$path.'model/',$p);
if (!($breadcrumbs instanceof BreadCrumbs)) return $modx->lexicon('breadcrumbs.error.loadingclass',array('path' => $path.'model/'));

return $breadcrumbs->run();