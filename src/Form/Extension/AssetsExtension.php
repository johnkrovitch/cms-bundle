<?php

namespace JK\CmsBundle\Form\Extension;

use App\Service\Assets\ScriptRegistry;
use Exception;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class AssetsExtension extends AbstractTypeExtension
{
    /**
     * @var ScriptRegistry
     */
    private $scriptRegistry;

    /**
     * AssetsExtension constructor.
     *
     * @param ScriptRegistry $scriptRegistry
     */
    public function __construct(ScriptRegistry $scriptRegistry)
    {
        $this->scriptRegistry = $scriptRegistry;
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            FormType::class,
        ];
    }

    /**
     * Register the configured scripts using the FormView variables.
     *
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     *
     * @throws Exception
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {

        dump('trce');

        if (!array_key_exists('scripts', $view->vars) || !is_array($view->vars['scripts'])) {
            return;
        }
        foreach ($view->vars['scripts'] as $location => $scripts) {
            if (!is_array($scripts)) {
                throw new Exception(
                    'Assets configuration for location '.$location.' should be an array in form '.$form->getName()
                );
            }

            foreach ($scripts as $name => $script) {
                // provide a script name if none is provided
                if (is_array($script) && !array_key_exists('script', $script)) {
                    $script['script'] = $name;
                }
                $this->registerScript($location, $script);
            }
        }
    }

    /**
     * Register a script for a location.
     *
     * @param string $location
     * @param string $script
     */
    private function registerScript($location, $script)
    {
        if (is_string($script)) {
            $this
                ->scriptRegistry
                ->register($location, $script)
            ;
        } elseif (is_array($script)) {
            if (!array_key_exists('template', $script)) {
                $script['template'] = null;
            }
            if (!array_key_exists('context', $script)) {
                $script['context'] = [];
            }
            $this
                ->scriptRegistry
                ->register($location, $script['script'], $script['template'], $script['context'])
            ;
        }
    }
}
