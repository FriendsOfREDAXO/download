<?php

/**
 * media_manager_autorewrite Addon.
 *
 * @author Friends Of REDAXO
 *
 * @var rex_addon
 */
$content = '';
$addon = rex_addon::get('download');

if (rex_post('config-submit', 'boolean')) {
    $addon->setConfig(rex_post('config', [
        ['send_as_http_file', 'boolean'],
    ]));

    $content .= rex_view::info($addon->i18n('config_saved'));
}

$content .= '
<div class="rex-form">
<form action="'.rex_url::currentBackendPage().'" method="post">
<fieldset>';

$formElements = [];

// set tags
$formElements = [];
$elements = array();
$formElements[] = $elements;
// parse select element
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/form.php');

// is base tag
$formElements = [];
$n = [];
$n['label'] = '<label for="send_as_http_file">'.$addon->i18n('send_as_http_file').'</label>';
$n['field'] = '<input type="checkbox" id="send_as_http_file" name="config[send_as_http_file]" value="1" '.($addon->getConfig('send_as_http_file') ? ' checked="checked"' : '').' />';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/checkbox.php');

$content .= '
</fieldset>

<fieldset class="rex-form-action">';

$formElements = [];
$n = [];
$n['field'] = '<input class="btn btn-save rex-form-aligned" type="submit" name="config-submit" value="'.$addon->i18n('config_save').'" '.rex::getAccesskey($addon->i18n('config_save'), 'save').' />';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/submit.php');

$content .= '
</fieldset>

</form>
</div>';

$fragment = new rex_fragment();
$fragment->setVar('title', $addon->i18n('config'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');

$hasParser = true;
$content = rex_file::get(rex_path::addon('download').'info.md');
// Parse Navigation & Content
if (class_exists('rex_markdown')) {
    $parser = rex_markdown::factory();
    $content = $parser->parse($content);
} else if (class_exists('Parsedown')) {
    $parser = new Parsedown();
    $content = $parser->text($content);
} else {
    $hasParser = false;
    $content = rex_view::error(rex_i18n::rawMsg('documentation_noparser'));
}

if($hasParser) {
    $fragment = new rex_fragment();
    $fragment->setVar('title', $addon->i18n('information'));
    $fragment->setVar('body', $content, false);
    echo $fragment->parse('core/page/section.php');
}
