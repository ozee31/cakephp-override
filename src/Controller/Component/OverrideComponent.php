<?php
namespace Override\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

class OverrideComponent extends Component
{
    /**
     * Constructor hook method. Set models.
     *
     * @param array $config The configuration settings provided to this component.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setModels(Configure::read('Overrides.models'));
    }

    public function beforeRender(Event $event)
    {
        $this->setHelpers(Configure::read('Overrides.helpers'));
    }

    /**
     * Overload models
     *
     * @param array $models
     */
    public function setModels(array $models)
    {
        foreach ($models as $alias => $options) {
            $this->setModel($alias, $options);
        }
    }

    /**
     * Overload model
     *
     * @param string $alias Name of the alias
     * @param array $options list of options for the alias
     * @return array The config data.
     */
    public function setModel($alias, $options = [])
    {
        return TableRegistry::config($alias, $options);
    }

    /**
     * Overload helpers
     *
     * @param array $helpers
     */
    public function setHelpers(array $helpers)
    {
        foreach ($helpers as $alias => $options) {
            if ($options['controllers'] === true || in_array($this->_registry->getController()->request->controller, (array) $options['controllers'])) {
                $this->setHelper($options['className']);
            }
        }
    }

    /**
     * Overload a helper
     *
     * @param $className
     */
    public function setHelper($className)
    {
        $this->_registry->getController()->viewBuilder()->setHelpers([$className]);
    }
}
