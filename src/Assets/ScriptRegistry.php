<?php

namespace JK\CmsBundle\Assets;


use JK\CmsBundle\Exception\Exception;
use Twig\Environment;

/**
 * Manage script to avoid adding javascript into the body, and allow dumping them into the head and footer section of
 * the html page.
 */
class ScriptRegistry
{
    /**
     * Scripts dumped into the head section of the html page.
     *
     * @var array
     */
    protected $headScripts = [];

    /**
     * Scripts dumped into the footer section of the html page.
     *
     * @var array
     */
    protected $footerScripts = [];

    /**
     * Default template for rendering scripts.
     *
     * @var string
     */
    protected $defaultTemplate;

    /**
     * Used to render scripts template.
     *
     * @var Environment
     */
    protected $twig;

    /**
     * ScriptRegistry constructor.
     *
     * @param Environment $twig
     * @param string           $defaultTemplate
     */
    public function __construct(
        Environment $twig,
        $defaultTemplate = '@JKCms/Assets/script.template.html.twig'
    ) {
        $this->defaultTemplate = $defaultTemplate;
        $this->twig = $twig;
    }

    /**
     * Register an array for a location. A custom template and context can be provided.
     *
     * @param string      $location Where the script will be dumped (only head and footer are allowed)
     * @param string      $script   The script name. If $template is provided, the script name is only used as array key
     * @param string|null $template The template name (MyBundle:Some:template.html.twig)
     * @param array       $context  The context given to the Twig template
     */
    public function register($location, $script, $template = null, array $context = [])
    {
        $this->checkLocation($location);
        $asset = [
            'location' => $location,
            'template' => $template,
            'context' => $context,
        ];

        if (null === $template) {
            // if no template is provided, we use the default script template
            $asset['template'] = $this->defaultTemplate;
            $asset['context'] = [
                'script' => $script,
            ];
        }

        // register assets according to location
        if ('head' === $location) {
            $this->headScripts[$script] = $asset;
        } elseif ('footer' === $location) {
            $this->footerScripts[$script] = $asset;
        }
    }

    /**
     * Dump the scripts for the given location.
     *
     * @param string $location "footer" or "head"
     *
     * @return string
     */
    public function dumpScripts($location)
    {
        $this->checkLocation($location);
        $content = '';

        if ('head' === $location) {
            foreach ($this->headScripts as $script) {
                $content .= $this->renderScript($script);
            }
        } elseif ('footer' === $location) {
            foreach ($this->footerScripts as $script) {
                $content .= $this->renderScript($script);
            }
        }

        return $content;
    }

    /**
     * Check if the location is correct (only head and footer are allowed).
     *
     * @param string $location
     *
     * @throws Exception
     */
    private function checkLocation($location)
    {
        if (!in_array($location, ['footer', 'head'])) {
            throw new Exception('Only "head" and "footer" locations are allowed');
        }
    }

    /**
     * Render a script using the provided template and context.
     *
     * @param array $script
     *
     * @return string
     */
    private function renderScript($script)
    {
        return $this
            ->twig
            ->render($script['template'], $script['context'])
        ;
    }
}
