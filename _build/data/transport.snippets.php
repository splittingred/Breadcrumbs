<?php
/**
 * @package breadcrumbs
 * @subpackage build
 */
$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => PKG_NAME,
    'description' => 'Creates a highly configurable and styleable breadcrumb navigation trail.',
    'snippet' => getSnippetContent($sources['snippets'].'snippet.'.PKG_NAME_LOWER.'.php'),
    'properties' => '',
),'',true,true);

$snippetProperties = array();
$props = include $sources['snippets'].'snippet.'.PKG_NAME_LOWER.'.properties.php';
foreach ($props as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }
    $snippetProperties[] = array(
        'name' => $key,
        'desc' => PKG_NAME_LOWER.'.prop_desc.'.$key,
        'type' => $type,
        'options' => '',
        'value' => ($value != null) ? $value : '',
        'lexicon' => PKG_NAME_LOWER.':properties'
    );
}
if (count($snippetProperties) > 0)
    $snippets[0]->setProperties($snippetProperties);

return $snippets;