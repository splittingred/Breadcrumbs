<?php
/**
 * @package breadcrumbs
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'Breadcrumbs',
    'description' => '',
    'snippet' => getSnippetContent($sources['source_core'].'/elements/snippets/snippet.breadcrumbs.php'),
    'properties' => '',
),'',true,true);

return $snippets;