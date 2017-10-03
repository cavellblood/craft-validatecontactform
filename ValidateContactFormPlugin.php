<?php
/**
 * Validate Contact Form plugin for Craft CMS
 *
 * Validate contact form with Google reCAPTCHA
 *
 * @author    Cavell L. Blood
 * @copyright Copyright (c) 2017 Cavell L. Blood
 * @link      https://cavellblood.com
 * @package   ValidateContactForm
 * @since     1.0.0
 */

namespace Craft;

class ValidateContactFormPlugin extends BasePlugin
{
    /**
     * @return mixed
     */
    public function init()
    {
        parent::init();

        craft()->on('contactForm.beforeSend', function(ContactFormEvent $event) {
            $message = $event->params['message'];

            $captcha = craft()->request->getPost('g-recaptcha-response');
            $verified = craft()->recaptcha_verify->verify($captcha);
            if($verified)
            {
                ValidateContactFormPlugin::log("verified", LogLevel::Info);
            } else {
                ValidateContactFormPlugin::log("not verified", LogLevel::Info);
                $event->isValid = false;

                // TODO: Improve invalidation message.
                $message->addError('message', 'Not verified.');
            }
        });
    }

    /**
     * @return mixed
     */
    public function getName()
    {
         return Craft::t('Validate Contact Form');
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return Craft::t('Validate contact form with Google reCAPTCHA');
    }

    /**
     * @return string
     */
    public function getDocumentationUrl()
    {
        return 'https://github.com/cavellblood/validatecontactform/blob/master/README.md';
    }

    /**
     * @return string
     */
    public function getReleaseFeedUrl()
    {
        return 'https://raw.githubusercontent.com/cavellblood/validatecontactform/master/releases.json';
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getSchemaVersion()
    {
        return '1.0.0';
    }

    /**
     * @return string
     */
    public function getDeveloper()
    {
        return 'Cavell L. Blood';
    }

    /**
     * @return string
     */
    public function getDeveloperUrl()
    {
        return 'https://cavellblood.com';
    }

    /**
     * @return bool
     */
    public function hasCpSection()
    {
        return false;
    }

    /**
     */
    public function onBeforeInstall()
    {
    }

    /**
     */
    public function onAfterInstall()
    {
    }

    /**
     */
    public function onBeforeUninstall()
    {
    }

    /**
     */
    public function onAfterUninstall()
    {
    }
}