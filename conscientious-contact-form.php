<?php
/**
 * Plugin Name: Conscientious Contact Form
 * Plugin URI: https://github.com/dashifen/conscientious-contact-form
 * Description: A WordPress plugin that produces a contact form that can conscientiously either email or simply store messages in the database (or both).
 * Author: David Dashifen Kees
 * Author URI: http://dashifen.com
 * Version: 2.3.0
 */

namespace Dashifen\WordPress\Plugins;

use Dashifen\Exception\Exception;
use Dashifen\WordPress\Plugins\ConscientiousContactForm\Agents\FormAgent;
use Dashifen\WordPress\Plugins\ConscientiousContactForm\Agents\SettingsAgent;
use Dashifen\WordPress\Plugins\ConscientiousContactForm\Agents\PostTypeAgent;
use Dashifen\WordPress\Plugins\ConscientiousContactForm\ConscientiousContactForm;
use Dashifen\WPHandler\Agents\Collection\Factory\AgentCollectionFactory;

if (!class_exists(ConscientiousContactForm::class)) {
  require_once 'vendor/autoload.php';
}

try {
  (function () {
    
    // our form object has some public methods related to accessing options
    // to which we don't want other areas of the site having access.  so, we
    // instantiate it here in this anonymous function so that it's not added
    // to the global PHP scope.
    
    $acf = new AgentCollectionFactory();
    $acf->registerAgent(FormAgent::class);
    $acf->registerAgent(SettingsAgent::class);
    $acf->registerAgent(PostTypeAgent::class);
    $conscientiousContactForm = new ConscientiousContactForm();
    $conscientiousContactForm->setAgentCollection($acf);
    $conscientiousContactForm->initialize();
  })();
} catch (Exception $e) {
  ConscientiousContactForm::catcher($e);
}
